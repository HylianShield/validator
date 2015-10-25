<?php
/**
 * Network URL parser interface.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Parser;

/**
 * Network URL parser interface.
 */
interface ParserInterface
{
    /**
     * Parse a given value into an array structure with URL components.
     *
     * @param mixed $value
     * @return array
     * @throws ParserException when the parser fails to process the supplied
     *   input.
     */
    public function parse($value);
}
