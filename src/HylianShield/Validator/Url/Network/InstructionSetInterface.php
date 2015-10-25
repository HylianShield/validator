<?php
/**
 *
 */
namespace HylianShield\Validator\Url\Network;

use \HylianShield\Validator\Url\Network\Parser\ParserInterface;
use \HylianShield\Validator\Url\Network\Rule\RuleInterface;


/**
 * An instruction set for network validators.
 */
interface InstructionSetInterface extends ParserInterface, RuleInterface
{
    /**
     * Getter for the rules property.
     *
     * @return RuleInterface[]
     * @throws \LogicException when property rules is not set.
     */
    public function getRules();

    /**
     * Getter for the parsers property.
     *
     * @return ParserInterface[]
     * @throws \LogicException when property parsers is not set.
     */
    public function getParsers();
}
