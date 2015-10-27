<?php
/**
 * Rule for the scheme section of a URL.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network\Rule;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Rule for the scheme section of a URL.
 */
class SchemeRule implements RuleInterface
{
    /**
     * A list of allowed schemes.
     *
     * @var array $allowedSchemes
     */
    private $allowedSchemes = array();

    /**
     * Initialize a scheme rule.
     *
     * @param array $allowedSchemes
     */
    public function __construct(array $allowedSchemes)
    {
        $this->allowedSchemes = $allowedSchemes;
    }

    /**
     * Create a scheme rule using the supplied definition.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return static
     */
    public static function fromDefinition(
        ProtocolDefinitionInterface $definition
    ) {
        return new static($definition->getAllowedSchemes());
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
        if (empty($url['scheme'])) {
            $context->addViolation(
                'Missing URL scheme',
                Network::VIOLATION_MISSING_SCHEME
            );
            return false;
        }

        if (empty($this->allowedSchemes)) {
            $context->addIntention(
                'Skipping scheme check, as none are explicitly required'
            );
            return true;
        }

        if (!in_array($url['scheme'], $this->allowedSchemes, true)) {
            $context->addViolation(
                'Illegal scheme ":scheme" encountered. '
                . 'Expected one of: :schemes',
                Network::VIOLATION_ILLEGAL_SCHEME,
                array(
                    'scheme' => $url['scheme'],
                    'schemes' => implode(', ', $this->allowedSchemes)
                )
            );

            return false;
        }

        return true;
    }
}
