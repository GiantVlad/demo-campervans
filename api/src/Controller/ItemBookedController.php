<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\DatePeriodFromRequestTrait;
use App\Controller\Traits\ItemAvailabilityValidationTrait;
use App\Repository\ItemAvailabilityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ItemBookedController extends AbstractController
{
    use DatePeriodFromRequestTrait, ItemAvailabilityValidationTrait;

    /**
     * @throws Exception|NonUniqueResultException|\Exception
     */
    public function __invoke(Request $request, ItemAvailabilityRepository $itemAvailabilityRepository): JsonResponse
    {
        $stationId = (int) $request->query->get('station');

        $errors = $this->validate($request);

        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $period = $this->getPeriod($request);

        $items = $itemAvailabilityRepository->getBookedItemsOnStations($period, $stationId);

        return $this->json($items);
    }
}
