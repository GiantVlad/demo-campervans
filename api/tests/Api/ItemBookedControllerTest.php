<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Station;
use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ItemBookedControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public static function setUpBeforeClass(): void
    {
        self::$purgeWithTruncate = true;
    }

    public function test_get_booked_items_on_station()
    {
        /** @var ArrayCollection<Station> $stations */
        $stations = static::getContainer()->get(StationRepository::class)->findAll();

        $response = static::createClient()->request(
            'GET',
            '/items-booked',
            ['query' => ['station' => $stations[2]->getId(), 'date_from' => '2022-07-01', 'date_to' => '2022-08-01']]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(7, json_decode($response->getContent()));
        $this->assertJsonContains([
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-18", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-25", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-26", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-07-31", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Tent', "date" => "2022-07-31", 'station' => $stations[2]->getName(),],
            ["amount" => 1, 'itemType' => 'Car', "date" => "2022-08-01", 'station' => $stations[2]->getName(),],
            ["amount" => 2, 'itemType' => 'Tent', "date" => "2022-08-01", 'station' => $stations[2]->getName(),],
        ]);
    }
}
