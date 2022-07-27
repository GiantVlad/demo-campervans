<?php

namespace App\Repository;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Entity\ItemStation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

class ItemAvailabilityRepository extends ServiceEntityRepository
{
    const ITEMS_PER_PAGE = 20;

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ItemStation::class);
    }

    /**
     * @throws Exception
     */
    public function getItemsOnStations(\DatePeriod $period, ?int $stationId, int $page = 1): iterable
    {
        $rows = new ArrayCollection();

        $andWhere = $stationId ? ' AND oi.in_station_id = ? ' : '';
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "
            SELECT count(item_id), in_station_id, it.type, ? AS date FROM order_item oi
               JOIN items i ON oi.item_id = i.id
               JOIN item_types it ON i.type_id = it.id
            WHERE (date_to, item_id) IN
                  (SELECT MAX(date_to) date, item_id FROM order_item
                   WHERE date_to < ? GROUP BY item_id)
                {$andWhere}
            GROUP BY it.type, in_station_id;
        ";
        $stmt = $conn->prepare($sql);

        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $stmt->bindValue(1, $date);
            $stmt->bindValue(2, $date);
            if ($stationId) {
                $stmt->bindValue(3, $stationId);
            }
            $result = $stmt->executeQuery()->fetchAssociative();
            if (!empty($result)) {
                $rows->add($result);
            }
        }

        return $rows;
    }
}


//        $firstResult = ($page -1) * self::ITEMS_PER_PAGE;
//        $queryBuilder = $this->createQueryBuilder('i');
//        $itemStation = $queryBuilder->select()
//            ->from(ItemStation::class, 'is')
//            ->where('is.station = :station')
//            ->andWhere('is.lastDate < :selected_date')
//            ->groupBy('is.item')
//            ->setParameter('station', $stationId)
//            ->setParameter('selected_date', $date->format('Y-m-d H:i:s'))
//            ->getQuery()
//            ->getSingleScalarResult();
//
//        $criteria = Criteria::create()
//            ->setFirstResult($firstResult)
//            ->setMaxResults(self::ITEMS_PER_PAGE);
//        $queryBuilder->addCriteria($criteria);
//
//        $doctrinePaginator = new DoctrinePaginator($queryBuilder);
//
//        return new Paginator($doctrinePaginator);
