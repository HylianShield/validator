<?php
/**
 * Validate array types.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Noë Snaterse.
 */

namespace HylianShield\Validator\CoreArray;

/**
 * CoreArray.
 */
class Numeric extends \HylianShield\Validator\CoreArray
{
    /**
     * isNumeric returns true is the array is a numeric array.
     * 
     * @param array $array the array to check.
     */
    public function isNumeric($array) {
        // First get all the keys
        $keys = array_keys($array);
        
        for ($i = 0; $i < count($keys); $i++) {
            if ($i !== $keys[$i]) {
                return false;
            }
        }
        
        return true;
    }
}