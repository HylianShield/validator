<?php
/**
 * Interface for validator context objects.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context;

use \HylianShield\Validator\Context\Indication\IndicationInterface;

/**
 * Interface ContextInterface
 */
interface ContextInterface
{
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
     * Add an intention to the context.
     *
     * @param string $description
     * @return mixed
     */
    public function addIntention($description);

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
}
