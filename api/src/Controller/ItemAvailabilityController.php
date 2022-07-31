<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\DatePeriodFromRequestTrait;
use App\Repository\ItemAvailabilityRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ItemAvailabilityController extends AbstractController
{
    use DatePeriodFromRequestTrait;

    /**
     * @throws Exception|\Exception
     */
    public function __invoke(Request $request, ItemAvailabilityRepository $itemAvailabilityRepository): JsonResponse
    {
        $stationId = (int) $request->query->get('station');
        $period = $this->getPeriod($request);
        $items = $itemAvailabilityRepository->getItemsOnStations($period, $stationId);

        return $this->json($items);
    }
}
