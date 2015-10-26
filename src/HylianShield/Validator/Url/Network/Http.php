<?php
/**
 * Validate HTTP URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network;

/**
 * Http.
 */
class Http extends \HylianShield\Validator\Url\Network
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network_http';

    /**
     * Get the definition of the network protocol.
     *
     * @return ProtocolDefinitionInterface
     */
    protected function getDefinition()
    {
        static $definition;

        if (!isset($definition)) {
            $definition = new ProtocolDefinition();
            $definition->setAllowedSchemes(array('http'));
            $definition->setAllowedPorts(array(80));
        }

        return $definition;
    }
}
