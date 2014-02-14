<?php
/**
 * Benchmark for Validator\String.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace Benchmarks\Validator\String\Utf8;

use \AthLetic\AthleticEvent;
use \HylianShield\Validator\String\Utf8\Mes3A;

/**
 * Mes3AEvent.
 */
class Mes3AEvent extends AthleticEvent
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
        // Set the regex encoding to UTF-8.
        mb_regex_encoding('UTF-8');

        $this->defaultValidator = new Mes3A;
        $this->minValidator = new Mes3A(1);
        $this->maxValidator = new Mes3A(null, 1);
        $this->rangeValidator = new Mes3A(1, 1);
    }

    /**
     * @iterations 100
     */
    public function defaultValidator()
    {
        $this->defaultValidator->validate("fiets");
    }

    /**
     * @iterations 100
     */
    public function minLength()
    {
        $this->minValidator->validate("fiets");
    }

    /**
     * @iterations 100
     */
    public function maxLength()
    {
        $this->maxValidator->validate("fiets");
    }

    /**
     * @iterations 100
     */
    public function rangeValidator()
    {
        $this->rangeValidator->validate("fiets");
    }
}
