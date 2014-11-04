<?php
/**
 * Create an abstract for validators.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield;

use \LogicException;
use \HylianShield\Validator\Context\Context;
use \HylianShield\Validator\Context\ContextInterface;

/**
 * Validator.
 */
abstract class Validator implements \HylianShield\ValidatorInterface
{
    /**
     * The type of the validator.
     *
     * @var string $type
     */
    protected $type;

    /**
     * A validation function which should always return either true or false and
     * accept a single value to check against.
     *
     * @var callable $validator
     */
    protected $validator;

    /**
     * Temporary storage of the value to be validated.
     *
     * @var string $lastValue
     */
    private $lastValue;

    /**
     * Temporary storage of the validation result.
     *
     * @var string $lastResult
     */
    protected $lastResult;

    /**
     * Set a message to be retrieved if a value doesn't pass the validator.
     *
     * @var string $lastMessage
     */
    private $lastMessage = null;

    /**
     * The context used during the last failed validation.
     *
     * @var ContextInterface|null $lastContext
     */
    private $lastContext = null;

    /**
     * Convenience method for creating a context.
     *
     * @return Context
     */
    public static function createContext()
    {
        return new Context();
    }

    /**
     * Validate the supplied value against the current validator.
     *
     * @param mixed $value
     * @param ContextInterface $context
     * @return boolean
     * @throws \LogicException when $this->validator is not callable
     */
    public function validate($value, ContextInterface $context = null)
    {
        if (!isset($context)) {
            $context = $this::createContext();
        }

        $this->lastValue = $value;
        $this->lastMessage = null;
        $this->lastContext = null;

        $validatorIsCallable = is_callable($this->validator);
        $context->addAssertion('Validator is callable', $validatorIsCallable);

        if (!$validatorIsCallable) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Validator should be callable!');
            // @codeCoverageIgnoreEnd
        }

        // Check if the validator validates.
        if (is_string($this->validator)) {
            $context->addIntention(
                'Leaving out context for simplistic validator.'
            );

            $this->lastResult = (bool) call_user_func(
                $this->validator,
                $this->lastValue
            );
        } else {
            $context->addIntention(
                'Passing context to registered validator.'
            );

            $this->lastResult = (bool) call_user_func(
                $this->validator,
                $this->lastValue,
                $context
            );
        }

        $context->addAssertion('Validation was successful', $this->lastResult);

        if ($this->lastResult === false) {
            $this->lastContext = $context;
        }

        return $this->lastResult;
    }

    /**
     * Get the message explaining the fail.
     *
     * @todo Add message for objects and arrays
     * @return string|null
     */
    final public function getMessage() {
        // Create a message.
        if ($this->lastResult === false && !isset($this->lastMessage)) {
            if (is_scalar($this->lastValue)) {
                $this->lastMessage = 'Invalid value supplied: (' . gettype($this->lastValue) . ') '
                    . var_export($this->lastValue, true) . "; Expected: {$this}";
            } else {
                $this->lastMessage = "Invalid value supplied; Expected: {$this}";
            }

            // If we have a context, use that to add some additional
            // information to our message.
            if (isset($this->lastContext)) {
                $violations = array();
                $index = 1;

                foreach ($this->lastContext->getViolations() as $violation) {
                    $violations[] = "#{$index} {$violation}";
                    $index++;
                }

                if (count($violations) > 0) {
                    $this->lastMessage .= PHP_EOL
                        . 'Violations:'. PHP_EOL
                        . implode(PHP_EOL, $violations);
                }
            }
        }

        return $this->lastMessage;
    }

    /**
     * Called when a class is directly called as if it was a function.
     *
     * @param mixed $value
     * @return boolean
     */
    final public function __invoke($value)
    {
        return $this->validate($value);
    }

    /**
     * Return the type of the current validator.
     *
     * @return string
     * @deprecated Now uses getType for method name consistency.
     */
    final public function type()
    {
        trigger_error('Method deprecated. Use getType instead.', E_USER_DEPRECATED);
        return $this->getType();
    }

    /**
     * Return the type of the current validator.
     *
     * @return string $this->type
     * @throws \LogicException when $this->type is not a string
     */
    final public function getType()
    {
        if (!is_string($this->type)) {
            // @codeCoverageIgnoreStart
            throw new LogicException(
                'Property type should be of data type string!'
            );
            // @codeCoverageIgnoreEnd
        }

        return $this->type;
    }

    /**
     * Return an indentifier.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getType();
    }
}
