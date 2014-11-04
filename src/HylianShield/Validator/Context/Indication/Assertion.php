<?php
/**
 * An assertion created during a validation.
 *
 * @package HylianShield
 * @subpackage Validator
 */
namespace HylianShield\Validator\Context\Indication;

use \InvalidArgumentException;
use \LogicException;

/**
 * An assertion created during a validation.
 */
class Assertion extends IndicationAbstract implements AssertionInterface
{
    /**
     * The result of the assertion.
     *
     * @var boolean $result
     */
    protected $result;

    /**
     * Create a new assertion.
     *
     * @param string $description
     * @param boolean $result
     */
    public function __construct($description, $result)
    {
        $this->setDescription($description);
        $this->setResult($result);
    }

    /**
     * Set the result of the assertion.
     *
     * @param boolean $result
     * @return Assertion
     * @throws \InvalidArgumentException when $result is not a boolean.
     */
    protected function setResult($result)
    {
        if (!is_bool($result)) {
            throw new InvalidArgumentException(
                'Invalid assertion result: ' . gettype($result)
            );
        }

        $this->result = $result;

        return $this;
    }

    /**
     * Get the result of the assertion.
     *
     * @return bool
     * @throws \LogicException when the result property is not set.
     */
    public function getResult()
    {
        if (!isset($this->result)) {
            throw new LogicException(
                'Missing property result.'
            );
        }

        return $this->result;
    }
}
