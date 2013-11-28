<?php
/**
 * Validate class existence.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\CoreClass;

use \InvalidArgumentException;
use \HylianShield\Validator\Boolean;

/**
 * Exists.
 */
class Exists extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'class_exists';

    /**
     * Create a validator that checks if a class exists.
     *
     * @param boolean $useAutoloader whether to use the autoloader
     * @throws \InvalidArgumentException when the supplied argument is not a boolean
     */
    public function __construct($useAutoloader = true)
    {
        $boolean = new Boolean;
        if (!$boolean($useAutoloader)) {
            throw new InvalidArgumentException(
                'Supplied argument is not a boolean: ' . gettype($useAutoloader)
                . ') ' . var_export($useAutoloader, true)
            );
        }

        // Add a wrapper around class exists, so we can tell when to use the autoloader.
        $this->validator = function ($class) use ($useAutoloader) {
            return class_exists($class, $useAutoloader);
        };
    }
}
