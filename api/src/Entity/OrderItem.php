<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ItemAvailabilityController;
use App\Controller\ItemBookedController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'get',
        'get_items_on_station' => [
            'method' => 'GET',
            'path' => '/items-availability',
            'controller' => ItemAvailabilityController::class,
            'openapi_context' => [
                'summary'     => 'Get available items on station',
                'description' => "# Get available items on station ",
                "parameters" => [
                    ['name'=> 'station', 'in' => 'query', 'schema' => ['type' => 'integer']],
                    ['name'=> 'date_from', 'in' => 'query', 'schema' => ['type' => 'date']],
                    ['name'=> 'date_to', 'in' => 'query', 'schema' => ['type' => 'date']],
                ]
            ],
        ],
        'get_booked_items_on_station' => [
            'method' => 'GET',
            'path' => '/items-booked',
            'controller' => ItemBookedController::class,
            'openapi_context' => [
                'summary'     => 'Get booked items on station',
                'description' => "# Get booked items on station ",
                "parameters" => [
                    ['name'=> 'station', 'in' => 'query', 'schema' => ['type' => 'integer']],
                    ['name'=> 'date_from', 'in' => 'query', 'schema' => ['type' => 'date']],
                    ['name'=> 'date_to', 'in' => 'query', 'schema' => ['type' => 'date']],
                ]
            ],
        ],
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: 'order_item')]
class OrderItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: 'Order', inversedBy: 'orderItems')]
    private Order $order;

    #[ORM\ManyToOne(targetEntity: 'Item', inversedBy: 'orderItems')]
    private ?Item $item;

    #[ORM\ManyToOne(targetEntity: 'ItemType', inversedBy: 'orderItems')]
    #[Assert\NotBlank]
    public ItemType $itemType;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    #[Assert\Date]
    public \DateTimeInterface $dateFrom;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    #[Assert\Date]
    public \DateTimeInterface $dateTo;

    #[ORM\ManyToOne(targetEntity: 'Station')]
    #[ORM\JoinColumn(name: 'in_station_id')]
    public Station $inStation;

    #[ORM\ManyToOne(targetEntity: 'Station')]
    #[ORM\JoinColumn(name: 'out_station_id')]
    public Station $outStation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getInStation(): Station
    {
        return $this->inStation;
    }

    public function setInStation(Station $inStation): self
    {
        $this->inStation = $inStation;

        return $this;
    }

    public function getOutStation(): Station
    {
        return $this->outStation;
    }

    public function setOutStation(Station $outStation): self
    {
        $this->outStation = $outStation;

        return $this;
    }

    public function getDateFrom(): \DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): \DateTimeInterface
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getItemType(): ItemType
    {
        return $this->itemType;
    }

    public function setItemType(ItemType $itemType): self
    {
        $this->itemType = $itemType;

        return $this;
    }
}
