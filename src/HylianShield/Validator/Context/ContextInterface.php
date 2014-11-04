<?php
/**
 * Interface for validator context objects.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context;

use \HylianShield\Validator\Context\Indication\AssertionInterface;
use \HylianShield\Validator\Context\Indication\IndicationInterface;
use \HylianShield\Validator\Context\Indication\IntentionInterface;
use \HylianShield\Validator\Context\Indication\ViolationInterface;

/**
 * Interface ContextInterface
 */
interface ContextInterface
{
    /**
     * Interface implemented by assertions.
     *
     * @var string ASSERTION_INTERFACE
     */
    const ASSERTION_INTERFACE = '\HylianShield\Validator\Context\Indication\AssertionInterface';

    /**
     * Interface implemented by intentions.
     *
     * @var string INTENTION_INTERFACE
     */
    const INTENTION_INTERFACE = '\HylianShield\Validator\Context\Indication\IntentionInterface';

    /**
     * Interface implemented by violations.
     *
     * @var string VIOLATION_INTERFACE
     */
    const VIOLATION_INTERFACE = '\HylianShield\Validator\Context\Indication\ViolationInterface';

    /**
     * Add a context indication to the current context.
     *
     * @param IndicationInterface $indication
     * @return mixed
     */
    public function addIndication(IndicationInterface $indication);

    /**
     * Add an assertion to the context.
     *
     * @param mixed $expression
     * @param string $description
     * @return mixed
     */
    public function addAssertion($expression, $description);

    /**
     * Get the assertions that are registered in the current context.
     *
     * @return AssertionInterface[]
     */
    public function getAssertions();

    /**
     * Add an intention to the context.
     *
     * @param string $description
     * @return mixed
     */
    public function addIntention($description);

    /**
     * Get the Intentions that are registered in the current context.
     *
     * @return IntentionInterface[]
     */
    public function getIntentions();

    /**
     * Add a constraint violation to the context.
     *
     * @param string $description
     * @param integer $violationCode
     * @param array $violationContext
     * @return mixed
     */
    public function addViolation(
        $description,
        $violationCode,
        array $violationContext = array()
    );

    /**
     * Get the Violations that are registered in the current context.
     *
     * @return ViolationInterface[]
     */
    public function getViolations();

    /**
     * Return a string representation of the context.
     *
     * @return string
     */
    public function __toString();
}
