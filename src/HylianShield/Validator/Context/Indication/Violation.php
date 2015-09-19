<?php
/**
 * A constraint violation of a validation process.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

use \InvalidArgumentException;
use \LogicException;

/**
 * A constraint violation of a validation process.
 */
class Violation extends InterpolatableIndicationAbstract implements
    ViolationInterface
{
    /**
     * The violation code.
     *
     * @var integer $code
     */
    protected $code;

    /**
     * A list of violation context parameters and their values.
     *
     * @var array $context
     */
    protected $context;

    /**
     * Initialize a new constraint violation.
     *
     * @param string $description
     * @param integer $code
     * @param array $context
     */
    public function __construct($description, $code, array $context = array())
    {
        $this->setDescription($description);
        $this->setCode($code);
        $this->setContext($context);
    }

    /**
     * Return a string representation of the current assertion.
     *
     * @return string
     */
    public function __toString()
    {
        return 'Violation - '
            . $this->interpolate($this->getDescription())
            . " - Violation code #{$this->getCode()}";
    }

    /**
     * Set the code of the violation.
     *
     * @param integer $code
     * @return Violation
     * @throws \InvalidArgumentException when $code is not an integer.
     */
    protected function setCode($code)
    {
        if (!is_integer($code)) {
            throw new InvalidArgumentException(
                'Invalid code supplied: ' . gettype($code)
            );
        }

        $this->code = $code;

        return $this;
    }

    /**
     * Get the violation code.
     *
     * @return integer
     * @throws \LogicException when code is not set.
     */
    public function getCode()
    {
        if (!isset($this->code)) {
            throw new \LogicException(
                'Missing property code.'
            );
        }

        return $this->code;
    }

    /**
     * Setter for context.
     *
     * @param array $context
     * @return Violation
     */
    protected function setContext(array $context = array())
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get the context parameters of the violation.
     *
     * @return array
     * @throws \LogicException when the context property is not set.
     */
    public function getContext()
    {
        if (!isset($this->context)) {
            throw new LogicException(
                'Missing property context.'
            );
        }

        return $this->context;
    }

    /**
     * Return a list of interpolation key and values.
     *
     * @return array
     */
    protected function getInterpolations()
    {
        return $this->getContext();
    }
}
