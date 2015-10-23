<?php
/**
 * Validate HTTPS URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network;

/**
 * Https.
 */
class Https extends \HylianShield\Validator\Url\Network
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network_https';

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
            $definition->setAllowedSchemes(array('https'));
            $definition->setAllowedPorts(array(443));
        }

        return $definition;
    }
}
