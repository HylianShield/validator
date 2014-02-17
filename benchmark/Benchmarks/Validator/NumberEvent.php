<?php
/**
 * Benchmark for Validator\Number.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Benchmarks\Validator;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\Number;

/**
 * NumberEvent.
 */
class NumberEvent extends AthleticEvent
{
    /**
     * The Number validator.
     *
     * @var \HylianShield\Validator\Number $defaultValidator
     */
    private $defaultValidator;

    /**
     * The Number validator with a minimum length.
     *
     * @var \HylianShield\Validator\Number $minValidator
     */
    private $minValidator;

    /**
     * The Number validator with a maximum length.
     *
     * @var \HylianShield\Validator\Number $maxValidator
     */
    private $maxValidator;

    /**
     * The Number validator with a minimum and maximum length.
     *
     * @var \HylianShield\Validator\Number $rangeValidator
     */
    private $rangeValidator;

    /**
     * Create the validator.
     *
     * @return void
     */
    public function setUp()
    {
        $this->defaultValidator = new Number;
        $this->minValidator = new Number(1);
        $this->maxValidator = new Number(null, 1);
        $this->rangeValidator = new Number(1, 1);
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
