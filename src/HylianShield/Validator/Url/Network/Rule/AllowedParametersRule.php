<?php
/**
 * A rule that lists allowed query parameters.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * A rule that lists allowed query parameters.
 */
class AllowedParametersRule implements RuleInterface
{
    /**
     * A list of allowed parameters.
     *
     * @var array $allowedParameters
     */
    private $allowedParameters = array();

    /**
     * Initialize the allowed parameters rule.
     *
     * @param array $allowedParameters
     */
    public function __construct(array $allowedParameters)
    {
        $this->allowedParameters = $allowedParameters;
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
        return new static($definition->getAllowedQueryParameters());
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
        $valid = true;

        foreach ($url['queryKeys'] as $key) {
            if (!in_array($key, $this->allowedParameters, true)) {
                $context->addViolation(
                    'Parameter :parameter is not in the list: :allowed',
                    Network::VIOLATION_ALLOWED_PARAMETER,
                    array(
                        'parameter' => $key,
                        'allowed' => implode(', ', $this->allowedParameters)
                    )
                );
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
