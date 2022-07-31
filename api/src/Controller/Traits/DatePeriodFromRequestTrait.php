<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Symfony\Component\HttpFoundation\Request;

trait DatePeriodFromRequestTrait
{
    /**
     * @throws \Exception
     */
    private function getPeriod(Request $request): \DatePeriod
    {
        $dateFrom = (string) $request->query->get('date_from');
        $dateTo = (string) $request->query->get('date_to');
        $dateFrom = new \DateTimeImmutable($dateFrom);
        $dateTo = new \DateTimeImmutable('+1 day' . $dateTo);
        $interval = new \DateInterval('P1D');

        return new \DatePeriod($dateFrom, $interval , $dateTo);
    }
}