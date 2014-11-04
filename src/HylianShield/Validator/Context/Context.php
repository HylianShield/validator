<?php
/**
 * Context for validator constraint violations.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context;

use \HylianShield\Validator\Context\Indication\Assertion;
use \HylianShield\Validator\Context\Indication\AssertionInterface;
use \HylianShield\Validator\Context\Indication\Intention;
use \HylianShield\Validator\Context\Indication\IndicationInterface;
use \HylianShield\Validator\Context\Indication\IntentionInterface;
use \HylianShield\Validator\Context\Indication\Violation;
use \HylianShield\Validator\Context\Indication\ViolationInterface;

/**
 * Validator context for constraint violations.
 */
class Context implements ContextInterface
{
    /**
     * A list of registered context indications.
     *
     * @var array $indications
     */
    protected $indications = array();

    /**
     * Add a context indication to the current context.
     *
     * @param IndicationInterface $indication
     * @return Context
     */
    public function addIndication(IndicationInterface $indication)
    {
        array_push($this->indications, $indication);

        return $this;
    }

    /**
     * Add an assertion to the context.
     *
     * @param string $description
     * @param mixed $expression
     * @return Context
     */
    public function addAssertion($description, $expression)
    {
        $this->addIndication(
            new Assertion($description, !empty($expression))
        );

        return $this;
    }

    /**
     * Add an intention to the context.
     *
     * @param string $description
     * @return Context
     */
    public function addIntention($description)
    {
        $this->addIndication(
            new Intention($description)
        );

        return $this;
    }

    /**
     * Add a constraint violation to the context.
     *
     * @param string $description
     * @param integer $violationCode
     * @param array $violationContext
     * @return Context
     */
    public function addViolation(
        $description,
        $violationCode,
        array $violationContext = array()
    ) {
        $this->addIndication(
            new Violation($description, $violationCode, $violationContext)
        );

        return $this;
    }

    /**
     * Get the assertions that are registered in the current context.
     *
     * @return AssertionInterface[]
     */
    public function getAssertions()
    {
        return $this->getIndicationsByInterface(
            $this::ASSERTION_INTERFACE
        );
    }

    /**
     * Get the Intentions that are registered in the current context.
     *
     * @return IntentionInterface[]
     */
    public function getIntentions()
    {
        return $this->getIndicationsByInterface(
            $this::INTENTION_INTERFACE
        );
    }

    /**
     * Get the Violations that are registered in the current context.
     *
     * @return ViolationInterface[]
     */
    public function getViolations()
    {
        return $this->getIndicationsByInterface(
            $this::VIOLATION_INTERFACE
        );
    }

    /**
     * Get indications that are a subclass of the supplied interface.
     *
     * @param string $interface
     * @return array
     */
    protected function getIndicationsByInterface($interface)
    {
        return array_filter(
            $this->indications,
            function (IndicationInterface $indication) use ($interface) {
                return $indication instanceof $interface;
            }
        );
    }
}
