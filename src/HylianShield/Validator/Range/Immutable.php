<?php
/**
 * Validate immutable value ranges.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Range;

/**
 * Immutable.
 */
abstract class Immutable extends \HylianShield\Validator\Range
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'range_immutable';

    /**
     * Check the properties of the validator to ensure a perfect implementation.
     */
    final public function __construct()
    {
        $this->initialize();
    }
}
