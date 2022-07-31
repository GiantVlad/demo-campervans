<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

trait ItemAvailabilityValidationTrait
{
    /**
     * @throws \Exception
     */
    private function validate(Request $request): ConstraintViolationListInterface
    {
        $stationId = (int) $request->query->get('station');
        $dateFrom = (string) $request->query->get('date_from');
        $dateTo = (string) $request->query->get('date_to');

        $validator = Validation::createValidator();
        $constraint = new Assert\Collection([
            'dateFrom' => new Assert\Date(),
            'dateTo' => [
                new Assert\Date(),
                new Assert\GreaterThanOrEqual($dateFrom)
            ],
            'station_id' => new Assert\Positive(),
        ]);
        $groups = new GroupSequence(['Default']);
        $input = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'station_id' => $stationId,
        ];

        return $validator->validate($input, $constraint, $groups);
    }
}