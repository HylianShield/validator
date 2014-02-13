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
     * The type.
     * 
     * @var string $type
     */
    protected $type = 'array_numeric';
    
    /**
     * Constructs Numeric array validators.
     */
    public function __contruct() 
    {
        $this->validator = function ($array) {
            // First check if $array is an actual array.
            if (!is_array($array)) {
                return false;
            }
            
            // Then get all the keys
            $keys = array_keys($array);
        
            // And check if they all are numeric.
            for ($i = 0; $i < count($keys); $i++) {
                if ($i !== $keys[$i]) {
                    return false;
                }
            }
        
            return true;
        };
    }
}