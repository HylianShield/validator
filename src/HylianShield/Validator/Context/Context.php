<?php
/**
 * Context for validator constraint violations.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context;

use \HylianShield\Validator\Context\Indication\Assertion;
use \HylianShield\Validator\Context\Indication\Intention;
use \HylianShield\Validator\Context\Indication\IndicationInterface;
use \HylianShield\Validator\Context\Indication\Violation;

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
     * @param mixed $expression
     * @param string $description
     * @return Context
     */
    public function addAssertion($expression, $description)
    {
        $this->addIndication(
            new Assertion(!empty($expression), $description)
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
}
