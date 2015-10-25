<?php
/**
 * Rule that requires the existence of pre-configured parameters in a URL query.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Rule that requires the existence of pre-configured parameters in a URL query.
 */
class RequiredParametersRule implements RuleInterface
{
    /**
     * A list of required URL parameters.
     *
     * @var array $requiredParameters
     */
    private $requiredParameters = array();

    /**
     * Initialize a new required parameters rule.
     *
     * @param array $requiredParameters
     */
    public function __construct(array $requiredParameters)
    {
        $this->requiredParameters = $requiredParameters;
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
        return new static($definition->getRequiredQueryParameters());
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

        foreach ($this->requiredParameters as $requiredParameter) {
            if (!in_array($requiredParameter, $url['queryKeys'], true)) {
                $context->addViolation(
                    'Missing required parameter: :parameter; '
                    . 'Supplied: :parameters; '
                    . 'Required: :required',
                    Network::VIOLATION_REQUIRED_PARAMETER,
                    array(
                        'parameter' => $requiredParameter,
                        'parameters' => implode(', ', $url['queryKeys']),
                        'required' => implode(', ', $this->requiredParameters)
                    )
                );
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
