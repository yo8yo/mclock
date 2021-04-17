<?php

namespace App\Validator;

use App\Repository\CheckInRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckInOnceValidator extends ConstraintValidator
{
    /**
     * @var CheckInRepository
     */
    private $checkInRepository;

    public function __construct(CheckInRepository $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\CheckInOnce */

        if (null === $value || '' === $value) {
            return;
        }

        $today =  \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:00") );
        $existingCheckin = $this->checkInRepository->findOneByUserAndDate($value, $today);

        if (!$existingCheckin) {
            return;
        }

        $this->context->buildViolation($constraint->message)
//            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
