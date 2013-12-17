<?php
/**
 * Validate class methods.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\CoreClass;

use \InvalidArgumentException;
use \HylianShield\Validator\LogicalNot;
use \HylianShield\Validator\LogicalAnd;
use \HylianShield\Validator\LogicalXor;
use \HylianShield\Validator\Object;
use \HylianShield\Validator\String;
use \HylianShield\Validator\CoreArray;
use \HylianShield\Validator\CoreClass;
use \HylianShield\Validator\CoreClass\Exists;
use \HylianShield\Validator\CoreClass\Instance;

/**
 * Method.
 */
class Method extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'class_method';

    /**
     * Accept a class to test the existence of methods.
     *
     * @param string|object $class
     * @throws \InvalidArgumentException when the $class does not exist
     */
    public function __construct($class)
    {
        $validClass = new LogicalXor(
            new LogicalAnd(
                new Object,
                new LogicalNot(new CoreArray),
                new LogicalNot(new Instance('\Function'))
            ),
            new LogicalAnd(
                new String,
                new Exists
            )
        );

        if (!$validClass($class)) {
            throw new InvalidArgumentException(
                'Pattern must be a valid class: (' . gettype($class) . ') '
                . var_export($class, true)
            );
        }

        // Create a validator on the fly.
        $this->validator = function ($method) use ($class) {
            return is_string($method) && method_exists($class, $method);
        };
    }
}
