<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;

#[ApiResource]
#[ORM\Entity]
#[ORM\Table(name: 'items')]
class Item
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ItemType::class, inversedBy: 'items')]
    #[Assert\NotBlank]
    public ItemType $type;

    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Unique]
    public Uuid $uuid;

    public function __construct()
    {
        $this->type = new ItemType();
        $this->uuid = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ItemType
    {
        return $this->type;
    }

    public function setType(ItemType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
