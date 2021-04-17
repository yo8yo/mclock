<?php

namespace App\Validator;

use App\Entity\CheckIn;
use App\Entity\User;
use App\Repository\CheckInRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class WeeklyHourValidator extends ConstraintValidator
{
    /**
     * @var CheckInRepository
     */
    private $checkInRepository;

    public function __construct(CheckInRepository $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof WeeklyHour) {
            throw new UnexpectedTypeException($constraint, WeeklyHour::class);
        }

        if (null === $entity || !$entity instanceof CheckIn) {
            return;
        }

        $monday = date("Y-m-d", strtotime('monday this week'));
        $countHours = $this->checkInRepository->countWeeklyHour($entity->getUser(), $monday);
        $countHours += $entity->getDuration();

        if ($constraint->max > $countHours) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
