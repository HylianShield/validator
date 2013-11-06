<?php
/**
 * Validate a conditional list in a logical AND fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;
use \LogicException;

/**
 * LogicalOr.
 */
class LogicalAnd extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'and';

    /**
     * List of classnames for \HylianShield\ValidatorAbstract descendants.
     *
     * @var array $validators
     */
    protected $validators = array();

    /**
     * Initialize the validator.
     *
     * @param \HylianShield\ValidatorAbstract $1 optional etc...
     * @throws \InvalidArgumentException if one of the validators is not an instance
     *   of \HylianShield\ValidatorAbstract
     * @throws \LogicException if less than 2 validators appear to be present
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
                if (!($instance) instanceof \HylianShield\ValidatorAbstract) {
                    throw new InvalidArgumentException(
                        'Supplied argument is not a valid instance: ('
                        . gettype($instance) . ') ' . var_export($instance, true)
                    );
                }

                return true;
            }
        );

        // Create a custom validator that returns true on the first match.
        // Since it is AND, all the validators should return true.
        $this->validator = function ($value) use ($validators) {
            foreach ($validators as $validator) {
                if (!$validator($value)) {
                    return false;
                }
            }

            return true;
        };
    }
}
