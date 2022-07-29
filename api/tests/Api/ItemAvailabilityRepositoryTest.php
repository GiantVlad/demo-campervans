<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Greeting;

class ItemAvailabilityRepositoryTest extends ApiTestCase
{
    public function testCreateGreeting()
    {
        $response = static::createClient()->request(
            'GET',
            '/items-availability',
            ['query' => ['station' => 85, 'date_from' => '2022-07-01', 'date_to' => '2022-08-01']]
        );

        $this->assertResponseStatusCodeSame(200);

        $this->assertJsonContains([
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-16"],
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-17"],
            ["amount" => "0", "item_type_id" => 11, "date" => "2022-07-18"],
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-19"],
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-20"],
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-21"],
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-22"],
            ["amount" => "1", "item_type_id" => 11, "date" => "2022-07-23"],
            ["amount" => "3", "item_type_id" => 11, "date" => "2022-07-24"],
            ["amount" => "2", "item_type_id" => 11, "date" => "2022-07-25"],
            ["amount" => "2", "item_type_id" => 11, "date" => "2022-07-26"],
            ["amount" => "2", "item_type_id" => 11, "date" => "2022-07-27"],
            ["amount" => "2", "item_type_id" => 11, "date" => "2022-07-28"],
            ["amount" => "2", "item_type_id" => 11, "date" => "2022-07-29"],
            ["amount" => "2", "item_type_id" => 11, "date" => "2022-07-30"],
            ["amount" => "4", "item_type_id" => 11, "date" => "2022-07-31"],
            ["amount" => "4", "item_type_id" => 11, "date" => "2022-08-01"],
        ]);
    }
}
