<?php
/**
 * Protocol port rule.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Context\Indication\Assertion;
use \HylianShield\Validator\Url\Network;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Protocol port rule.
 */
class PortRule implements RuleInterface
{
    /**
     * The ports that are allowed in the URL.
     *
     * @var array $ports
     */
    private $ports = array();

    /**
     * Whether a port is required in the URL.
     *
     * @var bool $required
     */
    private $required = false;

    /**
     * PortRule constructor.
     *
     * @param array $ports
     * @param bool $required
     * @throws \InvalidArgumentException when $required is not a boolean
     */
    public function __construct(array $ports, $required)
    {
        if (!is_bool($required)) {
            throw new \InvalidArgumentException(
                'Invalid required flag supplied: ' . gettype($required)
            );
        }

        $this->ports = $ports;
        $this->required = $required;
    }

    /**
     * Create the concrete rule based on the supplied protocol definition.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return static
     */
    public static function fromDefinition(
        ProtocolDefinitionInterface $definition
    ) {
        return new static(
            $definition->getAllowedPorts(),
            $definition->isRequirePort()
        );
    }

    /**
     * Test the supplied URL components against the concrete rule.
     *
     * @param array $url
     * @param ContextInterface $context
     * @return bool
     */
    public function test(array $url, ContextInterface $context)
    {
        $availableAssertion = new Assertion(
            'Port is available',
            !empty($url['port'])
        );
        $context->addIndication($availableAssertion);

        if ($this->required) {
            $context->addIntention('Require port');

            if ($availableAssertion->getResult() === false) {
                $context->addViolation(
                    'Missing port index',
                    Network::VIOLATION_MISSING_PORT
                );
                return false;
            }
        }

        if ($availableAssertion->getResult() === false) {
            $context->addIntention('Port is empty. Skipping check.');
            return true;
        }

        if (!empty($this->ports)) {
            $context->addIntention('Check port against list');

            if (!in_array((int) $url['port'], $this->ports, true)) {
                $context->addViolation(
                    'Illegal port :port supplied. Expected one of: :ports',
                    Network::VIOLATION_ILLEGAL_PORT,
                    array(
                        'port' => $url['port'],
                        'ports' => implode(', ', $this->ports)
                    )
                );
                return false;
            }
        }

        return true;
    }
}
