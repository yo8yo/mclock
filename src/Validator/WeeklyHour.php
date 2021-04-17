<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class WeeklyHour extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Maximum work time for a week is "35" hours';
    public $max;

    public function __construct($options = null)
    {
        if (null !== $options && !\is_array($options)) {
            $options = [
                'max' => $options,
            ];
        } elseif (\is_array($options) && isset($options['value']) && !isset($options['max'])) {
            $options['max'] = $options['value'];
            unset($options['value']);
        }

        parent::__construct($options);

        if (null === $this->max) {
            throw new MissingOptionsException(sprintf('Option "max" must be given for constraint "%s".', __CLASS__), ['max']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
