<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: 'OrderItem')]
    public iterable $orderItems;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderItems(): iterable
    {
        return $this->orderItems;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt ?? new \DateTimeImmutable();
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
