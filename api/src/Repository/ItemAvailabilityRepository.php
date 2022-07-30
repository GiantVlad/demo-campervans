<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\ItemAvailabilityDto;
use App\Entity\ItemType;
use App\Entity\OrderItem;
use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class ItemAvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, OrderItem::class);
    }

    /**
     * @throws Exception
     */
    public function getItemsOnStations(\DatePeriod $period, int $stationId): iterable
    {
        /** @var ArrayCollection $rows */
        $rows = new ArrayCollection([]);

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "
            SELECT SUM(amount) AS amount, MAX(it.alias) AS type, ? AS date, MAX(s.name) AS station FROM (
                SELECT count(oi.id) as amount, item_type_id, MAX(in_station_id) AS station_id FROM order_item oi
                WHERE in_station_id = ? AND date_to < ? AND date_from != ? GROUP BY item_type_id
                UNION
                SELECT -count(oi.id) as amount, item_type_id, MAX(out_station_id) AS station_id FROM order_item oi
                WHERE out_station_id = ? AND date_from <= ? GROUP BY item_type_id) as foo
                JOIN item_types it ON foo.item_type_id = it.id
                JOIN stations s ON foo.station_id = s.id
            GROUP BY item_type_id HAVING SUM(amount) != 0
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
            $resultsPerDay = $stmt->executeQuery()->fetchAllAssociative();

            foreach ($resultsPerDay as $result) {
                $rows->add(new ItemAvailabilityDto($result));
            }
        }

        return $rows;
    }

    /**
     * @throws Exception|NonUniqueResultException
     */
    public function getBookedItemsOnStations(\DatePeriod $period, int $stationId): iterable
    {
        $rows = new ArrayCollection([]);
        $queryBuilder = $this->createQueryBuilder('oi')
            ->select('count(oi.id) AS amount, MAX(it.alias) AS itemType, MAX(s.name) AS station, MAX(:selected_date) AS date')
            ->innerJoin(ItemType::class, 'it', Join::WITH,'oi.itemType = it.id')
            ->innerJoin(Station::class, 's', Join::WITH,'oi.outStation = s.id AND s.id = :station')
            ->andWhere(':selected_date BETWEEN oi.dateFrom AND oi.dateTo')
            ->andHaving('count(oi.id) != 0')
            ->groupBy('oi.itemType')
            ->setParameter('station', $stationId)
        ;

        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $queryBuilder->setParameter('selected_date', $date);

            $resultsPerDay = $queryBuilder->getQuery()->getResult();

            foreach ($resultsPerDay as $result) {
                $rows->add($result);
            }
        }

        return $rows;
    }
}
