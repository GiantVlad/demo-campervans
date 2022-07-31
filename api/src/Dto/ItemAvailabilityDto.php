<?php

declare(strict_types=1);

namespace App\Dto;

class ItemAvailabilityDto
{
    public string $itemType;

    public string $date;

    public string $station;

    public int $amount;

    public function __construct(array $data)
    {
        $this->itemType = $data['type'];
        $this->date = (new \DateTimeImmutable($data['date']))->format('Y-m-d');
        $this->amount = (int) $data['amount'];
        $this->station = $data['station'];
    }
}
