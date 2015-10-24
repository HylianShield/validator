<?php
/**
 * A custom protocol validator based on a protocol definition.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network;

use \HylianShield\Validator\Url\Network;

/**
 * A custom protocol validator based on a protocol definition.
 */
class CustomProtocol extends Network
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network_customprotocol';

    /**
     * The definition of the protocol.
     *
     * @var ProtocolDefinitionInterface $definition
     */
    private $definition;

    /**
     * Create a new protocol validator using the supplied protocol definition.
     *
     * @param ProtocolDefinitionInterface $definition
     */
    public function __construct(ProtocolDefinitionInterface $definition)
    {
        $this->definition = $definition;
        parent::__construct();
    }

    /**
     * Getter for the definition property.
     *
     * @return ProtocolDefinitionInterface
     * @throws \LogicException when property definition is not set.
     */
    protected function getDefinition()
    {
        if (!isset($this->definition)) {
            throw new \LogicException('Missing property definition');
        }

        return $this->definition;
    }
}
