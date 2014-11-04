<?php
/**
 * Validate numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use \HylianShield\Validator\Float;
use \HylianShield\Validator\Integer;

/**
 * Number.
 * We extend Float, since number needs to use the same precision as the most
 * precise of the internal validators.
 */
class Number extends \HylianShield\Validator\Float
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'number';

    /**
     * Create the validator
     */
    protected function createValidator()
    {
        // Set a custom validator.
        return new LogicalOr(new Integer, new Float);
    }
}
