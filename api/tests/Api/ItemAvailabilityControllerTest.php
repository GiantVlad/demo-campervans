<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Station;
use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ItemAvailabilityControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public static function setUpBeforeClass(): void
    {
        self::$purgeWithTruncate = true;
    }

    public function test_get_items_on_station()
    {
        /** @var ArrayCollection<Station> $stations */
        $stations = static::getContainer()->get(StationRepository::class)->findAll();

        $response = static::createClient()->request(
            'GET',
            '/items-availability',
            ['query' => ['station' => $stations[2]->getId(), 'date_from' => '2022-07-01', 'date_to' => '2022-08-01']]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(16, json_decode($response->getContent()));
        $this->assertJsonContains([
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-16", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-17", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-19", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-20", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-21", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-22", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-23", 'station' => $stations[2]->getName(),],
            ["amount" => 3, 'itemType' => 'Car', "date" => "2022-07-24", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Car', "date" => "2022-07-25", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Car', "date" => "2022-07-26", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Car', "date" => "2022-07-27", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Car', "date" => "2022-07-28", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Car', "date" => "2022-07-29", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Car', "date" => "2022-07-30", 'station' => $stations[2]->getName(),],
            ["amount" => 3, 'itemType' => 'Car', "date" => "2022-07-31", 'station' => $stations[2]->getName(),],
            ["amount" => 3, 'itemType' => 'Car', "date" => "2022-08-01", 'station' => $stations[2]->getName(),],
        ]);
    }
}
