<?php
/**
 * Validate negative integers.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Integer;

use \HylianShield\Validator\Integer;

/**
 * Negative.
 */
class Negative extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer_negative';

    /**
     * The boundary for a negative integer.
     *
     * @var integer BOUNDARY
     */
    const BOUNDARY = -1;

    /**
     * Create a validator for a negative integer.
     */
    public function __construct()
    {
        $this->validator = new Integer(null, $this::BOUNDARY);
    }
}
