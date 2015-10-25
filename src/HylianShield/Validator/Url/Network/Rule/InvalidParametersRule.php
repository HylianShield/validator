<?php
/**
 * Rule that prevents specific query parameters in a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Rule that prevents specific query parameters in a URL.
 */
class InvalidParametersRule implements RuleInterface
{
    /**
     * A list of invalid query parameters.
     *
     * @var array $invalidParameters
     */
    private $invalidParameters = array();

    /**
     * InvalidParametersRule constructor.
     * @param array $invalidParameters
     */
    public function __construct(array $invalidParameters)
    {
        $this->invalidParameters = $invalidParameters;
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
        return new static($definition->getInvalidParameters());
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
            if (in_array($key, $this->invalidParameters, true)) {
                $context->addViolation(
                    'Invalid parameter: :parameter; Illegal :illegal',
                    Network::VIOLATION_INVALID_PARAMETER,
                    array(
                        'parameter' => $key,
                        'illegal' => implode(', ', $this->invalidParameters)
                    )
                );
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
