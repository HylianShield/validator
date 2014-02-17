<?php
/**
 * Benchmark for Validator\Float.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Benchmarks\Validator;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\Float;

/**
 * FloatEvent.
 */
class FloatEvent extends AthleticEvent
{
    /**
     * The Float validator.
     *
     * @var \HylianShield\Validator\Float $defaultValidator
     */
    private $defaultValidator;

    /**
     * The Float validator with a minimum length.
     *
     * @var \HylianShield\Validator\Float $minValidator
     */
    private $minValidator;

    /**
     * The Float validator with a maximum length.
     *
     * @var \HylianShield\Validator\Float $maxValidator
     */
    private $maxValidator;

    /**
     * The Float validator with a minimum and maximum length.
     *
     * @var \HylianShield\Validator\Float $rangeValidator
     */
    private $rangeValidator;

    /**
     * Create the validator.
     *
     * @return void
     */
    public function setUp()
    {
        $this->defaultValidator = new Float;
        $this->minValidator = new Float(1);
        $this->maxValidator = new Float(null, 1);
        $this->rangeValidator = new Float(1, 1);
    }

    /**
     * @iterations 1000
     */
    public function defaultValidator()
    {
        $this->defaultValidator->validate(1);
    }

    /**
     * @iterations 1000
     */
    public function minLength()
    {
        $this->minValidator->validate(1);
    }

    /**
     * @iterations 1000
     */
    public function maxLength()
    {
        $this->maxValidator->validate(1);
    }

    /**
     * @iterations 1000
     */
    public function rangeValidator()
    {
        $this->rangeValidator->validate(1);
    }
}
