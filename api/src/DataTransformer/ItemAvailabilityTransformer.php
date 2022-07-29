<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\ItemAvailabilityDto;
use App\Entity\OrderItem;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ItemAvailabilityTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     * @param object $object
     *
     * @return object
     * @throws \Exception
     *
     */
    public function transform($object, string $to, array $context = [])
    {
        /** @var ItemAvailabilityDto $item */
        $item = $context[AbstractNormalizer::OBJECT_TO_POPULATE];
        $item->station = $object['station_id'];
        $item->date = new \DateTimeImmutable($object['date']);
        $item->itemType = $object['item_type_id'];
        $item->amount = $object['amount'];

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data['item_type_id'] ?? $data['date'] ?? $data['amount'] ?? $data['station_id'] ?? false) {
            return false;
        }

        return OrderItem::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
