<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
#[ORM\Table(name: 'item_types')]
class ItemType
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank]
    #[Assert\Unique]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2, max: 100)]
    public string $type;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 255)]
    public string $alias;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: Item::class)]
    public iterable $items;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
    public iterable $orderItems;

    public function __construct()
    {
        $this->type = '';
        $this->alias = '';
        $this->items = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getItems(): iterable
    {
        return $this->items;
    }

    public function getOrderItems(): iterable
    {
        return $this->orderItems;
    }
}
