<?php

namespace App\Controller;

use App\Repository\ItemAvailabilityRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ItemAvailabilityController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, ItemAvailabilityRepository $itemAvailabilityRepository): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $stationId = $request->query->get('station');
        $dateFrom = $request->query->get('date_from');
        $dateTo = $request->query->get('date_to');
        $dateFrom = new \DateTimeImmutable($dateFrom);
        $dateTo = new \DateTimeImmutable('+1 day' . $dateTo);
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($dateFrom, $interval , $dateTo);
        $items = $itemAvailabilityRepository->getItemsOnStations($period, $stationId, $page);

        return $this->json($items);
    }
}
