<?php
/**
 * Benchmark for Validator\String.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Benchmarks\Validator;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\String;

/**
 * StringEvent.
 */
class StringEvent extends AthleticEvent
{
    /**
     * The String validator.
     *
     * @var \HylianShield\Validator\String $defaultValidator
     */
    private $defaultValidator;

    /**
     * The String validator with a minimum length.
     *
     * @var \HylianShield\Validator\String $minValidator
     */
    private $minValidator;

    /**
     * The String validator with a maximum length.
     *
     * @var \HylianShield\Validator\String $maxValidator
     */
    private $maxValidator;

    /**
     * The String validator with a minimum and maximum length.
     *
     * @var \HylianShield\Validator\String $rangeValidator
     */
    private $rangeValidator;

    /**
     * Create the validator.
     *
     * @return void
     */
    public function setUp()
    {
        $this->defaultValidator = new String;
        $this->minValidator = new String(1);
        $this->maxValidator = new String(null, 1);
        $this->rangeValidator = new String(1, 1);
    }

    /**
     * @iterations 1000
     */
    public function defaultValidator()
    {
        $this->defaultValidator->validate("fiets");
    }

    /**
     * @iterations 1000
     */
    public function minLength()
    {
        $this->minValidator->validate("fiets");
    }

    /**
     * @iterations 1000
     */
    public function maxLength()
    {
        $this->maxValidator->validate("fiets");
    }

    /**
     * @iterations 1000
     */
    public function rangeValidator()
    {
        $this->rangeValidator->validate("fiets");
    }
}
