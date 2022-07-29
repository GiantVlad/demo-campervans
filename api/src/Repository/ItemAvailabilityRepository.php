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
    public function getItemsOnStations(\DatePeriod $period, int $stationId, int $page = 1): iterable
    {
        $rows = new ArrayCollection();

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "
            SELECT SUM(am) AS amount, item_type_id, ? AS date FROM (
                SELECT count(oi.id) as am, item_type_id FROM order_item oi
                WHERE in_station_id = ? AND date_to < ? AND date_from != ? GROUP BY item_type_id
                UNION
                SELECT -count(oi.id) as am, item_type_id FROM order_item oi
                WHERE out_station_id = ? AND date_from <= ? GROUP BY item_type_id) as foo
            GROUP BY item_type_id
        ";
        $stmt = $conn->prepare($sql);

        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $stmt->bindValue(1, $date);
            $stmt->bindValue(2, $stationId);
            $stmt->bindValue(3, $date);
            $stmt->bindValue(4, $date);
            $stmt->bindValue(5, $stationId);
            $stmt->bindValue(6, $date);
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
