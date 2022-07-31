<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\OrderItem;
use App\Repository\ItemAvailabilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class ItemAvailabilityRepositoryTest extends TestCase
{
    public function testGetBookedItemsOnStations(): void
    {
        $query = $this->createMock(AbstractQuery::class);
        $query->expects($this->once())->method('getResult')->willReturn(['result']);

        $queryBuilder = $this->createMock(QueryBuilder::class);
        $queryBuilder->expects($this->exactly(2))->method('select')->willReturn($queryBuilder);
        $queryBuilder->expects($this->once())->method('from')->willReturn($queryBuilder);
        $queryBuilder->expects($this->exactly(2))->method('innerJoin')->willReturn($queryBuilder);
        $queryBuilder->expects($this->once())->method('andWhere')->willReturn($queryBuilder);
        $queryBuilder->expects($this->once())->method('andHaving')->willReturn($queryBuilder);
        $queryBuilder->expects($this->once())->method('groupBy')->willReturn($queryBuilder);
        $queryBuilder->expects($this->exactly(2))->method('setParameter')->willReturn($queryBuilder);
        $queryBuilder->expects($this->once())->method('getQuery')->willReturn($query);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('getClassMetadata')->willReturn($this->createMock(ClassMetadata::class));
        $entityManager->expects($this->once())->method('createQueryBuilder')->willReturn($queryBuilder);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->with(OrderItem::class)->willReturn($entityManager);

        $repo = new ItemAvailabilityRepository($registry, OrderItem::class);

        $date = new \DateTimeImmutable();
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($date, $interval , $date->add($interval));

        $rows = $repo->getBookedItemsOnStations($period, 1);
        $this->assertInstanceOf(ArrayCollection::class, $rows);
        $this->assertEquals('result', $rows->first());
    }
}