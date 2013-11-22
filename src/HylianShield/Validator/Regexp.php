<?php
/**
 * Validate regular expressions.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;

/**
 * Regexp.
 */
class Regexp extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'regexp';

    /**
     * The pattern used when validating.
     *
     * @var string $pattern
     */
    private $pattern;

    /**
     * Accept a pattern to match expressions.
     *
     * @param string $pattern
     * @throws \InvalidArgumentException when the pattern is not a string
     */
    public function __construct($pattern)
    {
        if (!is_string($pattern)) {
            throw new InvalidArgumentException(
                'Pattern must be a string: (' . gettype($pattern) . ') '
                . var_export($pattern, true)
            );
        }

        $this->pattern = $pattern;

        // Create a validator on the fly.
        $this->validator = function ($subject) use ($pattern) {
            return is_string($subject) && preg_match($pattern, $subject);
        };
    }

    /**
     * Return an indentifier.
     *
     * @return string
     */
    final public function __tostring()
    {
        return "{$this->type}:{$this->pattern}";
    }
}
