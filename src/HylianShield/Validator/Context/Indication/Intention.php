<?php
/**
 * Intention of a validation process.
 *
 * @package HylianShield
 * @subpackage Validator
 */
namespace HylianShield\Validator\Context\Indication;

/**
 * Intention of a validation process.
 */
class Intention extends IndicationAbstract implements IntentionInterface
{
    /**
     * Initialize a new intention.
     *
     * @param string $description
     */
    public function __construct($description)
    {
        $this->setDescription($description);
    }

    /**
     * Return a string representation of the current assertion.
     *
     * @return string
     */
    public function __toString()
    {
        return "Intention - {$this->getDescription()}";
    }
}
