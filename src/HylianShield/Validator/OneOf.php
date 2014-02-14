<?php
/**
 * Validate values against a set of options.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;
use \LogicException;

/**
 * OneOf.
 */
class OneOf extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'oneof';

    /**
     * A visual representation of the set that will be tested.
     *
     * @var string $collectionIdentifier
     */
    private $collectionIdentifier;

    /**
     * Accept a variable list of arguments. The validator will pass if one of the
     * supplied values matches the tested value.
     * Only scalar values are allowed.
     *
     * @throws \InvalidArgumentException if one of the values is not scalar.
     * @throws \LogicException if no values were supplied
     */
    public function __construct()
    {
        // Walk through all arguments and test if they are scalar.
        $values = array();
        $ids = array();

        foreach (func_get_args() as $arg) {
            if (!is_scalar($arg)) {
                throw new InvalidArgumentException(
                    'Only scalar values are allowed!'
                );
            }

            $values[] = $arg;
            $ids[] = '(' . gettype($arg) . ') ' . var_export($arg, true);
        }

        // We can't have nothing to test.
        if (count($values) < 1) {
            throw new LogicException('Cannot perform a test on an empty set.');
        }

        // Register the collection identifier.
        $this->collectionIdentifier = implode(', ', $ids);
        unset($ids);

        // Create a new validator that will test all supplied values explicitly.
        $this->validator = function ($subject) use ($values) {
	    return in_array($subject, $values, true);
        };
    }

    /**
     * Return an identifier.
     *
     * @return string
     */
    final public function __tostring()
    {
        return "{$this->type}({$this->collectionIdentifier})";
    }
}
