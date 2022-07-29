<?php

namespace App\Dto;

use App\Entity\ItemType;
use App\Entity\Station;

class ItemAvailabilityDto
{
//    private ItemType $itemType;
//
//    private \DateTimeInterface $date;
//
//    private Station $station;
    
    public int $itemType;

    public \DateTimeInterface $date;

    public int $station;

    public int $amount;

//    public function __construct(array $data)
//    {
//        $this->itemType = (new ItemType())->setId($data['item_type_id']);
//        $this->date = new \DateTimeImmutable($data['date']);
//        $this->amount = (int) $data['amount'];
//        $this->station = (new Station())->setId($data['station_id']);
//    }

//    public function getStation(): Station
//    {
//        return $this->station;
//    }
//
//    public function setInStation(Station $station): self
//    {
//        $this->station = $station;
//
//        return $this;
//    }
//
//    public function getItemType(): ?ItemType
//    {
//        return $this->itemType;
//    }
//
//    public function setItemType(?ItemType $itemType): self
//    {
//        $this->itemType = $itemType;
//
//        return $this;
//    }
//
//    public function getDate(): \DateTimeInterface
//    {
//        return $this->date ?? new \DateTimeImmutable();
//    }
//
//    public function setDate(\DateTimeInterface $date): self
//    {
//        $this->date = $date;
//
//        return $this;
//    }
//
//    public function getAmount(): int
//    {
//        return $this->amount;
//    }
//
//    public function setAmount(int $amount): self
//    {
//        $this->amount = $amount;
//
//        return $this;
//    }
}
