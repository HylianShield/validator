<?php
/**
 * Abstract implementation for network protocol rules.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Abstract implementation for network protocol rules.
 */
abstract class RuleAbstract implements RuleInterface
{
    /**
     * Create the concrete rule based on the supplied protocol definition.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return static
     */
    public static function fromDefinition(
        ProtocolDefinitionInterface $definition
    ) {
        return new static();
    }
}
