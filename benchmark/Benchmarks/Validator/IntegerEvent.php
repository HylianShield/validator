<?php
/**
 * Benchmark for Validator\Integer.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Benchmarks\Validator;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\Integer;

/**
 * IntegerEvent.
 */
class IntegerEvent extends AthleticEvent
{
    /**
     * The Integer validator.
     *
     * @var \HylianShield\Validator\Integer $defaultValidator
     */
    private $defaultValidator;

    /**
     * The Integer validator with a minimum length.
     *
     * @var \HylianShield\Validator\Integer $minValidator
     */
    private $minValidator;

    /**
     * The Integer validator with a maximum length.
     *
     * @var \HylianShield\Validator\Integer $maxValidator
     */
    private $maxValidator;

    /**
     * The Integer validator with a minimum and maximum length.
     *
     * @var \HylianShield\Validator\Integer $rangeValidator
     */
    private $rangeValidator;

    /**
     * Create the validator.
     *
     * @return void
     */
    public function setUp()
    {
        $this->defaultValidator = new Integer;
        $this->minValidator = new Integer(1);
        $this->maxValidator = new Integer(null, 1);
        $this->rangeValidator = new Integer(1, 1);
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
