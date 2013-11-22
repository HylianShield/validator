<?php
/**
 * Validate a conditional list in a logical XOR fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;
use \LogicException;

/**
 * LogicalXor.
 */
class LogicalXor extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'xor';

    /**
     * List of classnames for \HylianShield\Validator descendants.
     *
     * @var array $validators
     */
    protected $validators = array();

    /**
     * Initialize the validator.
     *
     * @param \HylianShield\Validator $1 optional
     * @param \HylianShield\Validator $2 optional
     * @throws \InvalidArgumentException if one of the validators is not an instance
     *   of \HylianShield\Validator
     * @throws \LogicException if anything but exactly 2 validators appear to be present
     */
    final public function __construct()
    {
        // Gather all validators and check if they are valid validators.
        $validators = array_filter(
            array_merge(
                // Start with the validators supplied by any class that extends us.
                array_map(
                    function ($class) {
                        if (!is_string($class) || !class_exists($class, true)) {
                            throw new LogicException(
                                'Invalid class supplied: (' . gettype($class)
                                . ') ' . var_export($class, true)
                            );
                        }

                        return new $class;
                    },
                    $this->validators
                ),
                // Add in the instances that have been supplied to our construct.
                func_get_args()
            ),
            // Now test them all against being an instance of our validator abstract.
            function ($instance) {
                if (!($instance) instanceof \HylianShield\Validator) {
                    throw new InvalidArgumentException(
                        'Supplied argument is not a valid instance: ('
                        . gettype($instance) . ') ' . var_export($instance, true)
                    );
                }

                return true;
            }
        );

        if (count($validators) !== 2) {
            throw new LogicException(
                'Cannot perform a logical XOR with anything but two validators.'
            );
        }

        // Create a custom validator.
        // Since it is XOR, only one match should happen.
        $this->validator = function ($value) use ($validators) {
            // Create a test where only the passing validators will remain.
            $test = array_filter(
                $validators,
                function ($validator) use ($value) {
                    return $validator($value);
                }
            );

            // The result of this test must be exactly 1 to be a valid XOR gate.
            return count($test) === 1;
        };
    }
}
