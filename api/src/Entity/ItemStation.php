<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ItemAvailabilityController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(collectionOperations: [
    'get',
    'get_items_on_station' => [
        'method' => 'GET',
        'path' => '/items-availability/{station}',
        'controller' => ItemAvailabilityController::class,
        'openapi_context' => [
            'summary'     => 'Get items on station',
            'description' => "# Pop a great rabbit ",
            "parameters" => [
                ['name'=> 'station', 'in' => 'query', 'schema' => ['type' => 'integer']],
                ['name'=> 'date_from', 'in' => 'query', 'schema' => ['type' => 'date']],
                ['name'=> 'date_to', 'in' => 'query', 'schema' => ['type' => 'date']],
            ]
        ],
    ],
])]
#[ORM\Entity]
#[ORM\Table(name: 'item_station')]
class ItemStation
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'Item', inversedBy: 'orderItems')]
    private Item $item;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    public \DateTimeInterface $lastDate;

    #[ORM\ManyToOne(targetEntity: 'Station')]
    public Station $station;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStation(): Station
    {
        return $this->station;
    }

    public function setInStation(Station $station): self
    {
        $this->station = $station;

        return $this;
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    public function setItem(Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getLastDate(): \DateTimeInterface
    {
        return $this->lastDate ?? new \DateTimeImmutable();
    }

    public function setLastDate(\DateTimeInterface $lastDate): self
    {
        $this->lastDate = $lastDate;

        return $this;
    }
}
