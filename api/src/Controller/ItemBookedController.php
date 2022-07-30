<?php

declare(strict_types=1);

namespace App\Controller;

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
    /**
     * @throws Exception|NonUniqueResultException
     */
    public function __invoke(Request $request, ItemAvailabilityRepository $itemAvailabilityRepository): JsonResponse
    {
        $stationId = (int) $request->query->get('station');
        $dateFrom = (string) $request->query->get('date_from');
        $dateTo = (string) $request->query->get('date_to');
        $dateFrom = new \DateTimeImmutable($dateFrom);
        $dateTo = new \DateTimeImmutable('+1 day' . $dateTo);
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($dateFrom, $interval , $dateTo);
        $items = $itemAvailabilityRepository->getBookedItemsOnStations($period, $stationId);

        return $this->json($items);
    }
}
