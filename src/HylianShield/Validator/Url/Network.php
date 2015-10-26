<?php
/**
 * Validate network URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Url\Network\InstructionSet;
use \HylianShield\Validator\Url\Network\InstructionSetInterface;
use \HylianShield\Validator\Url\Network\Parser\ParserException;
use \HylianShield\Validator\Url\Network\ProtocolDefinition;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Network.
 */
class Network extends \HylianShield\Validator
{
    /**
     * The violation code when a value was supplied to a parser, which could
     * not be properly processed.
     *
     * @var int VIOLATION_PARSER
     */
    const VIOLATION_PARSER = 1;

    /**
     * The violation code when the host index is missing.
     *
     * @var int VIOLATION_HOST
     */
    const VIOLATION_HOST = 2;

    /**
     * The violation code when the scheme index is missing.
     *
     * @var int VIOLATION_MISSING_SCHEME
     */
    const VIOLATION_MISSING_SCHEME = 4;

    /**
     * The violation code when the scheme is illegal.
     *
     * @var int VIOLATION_ILLEGAL_SCHEME
     */
    const VIOLATION_ILLEGAL_SCHEME = 8;

    /**
     * The violation code when the path is empty.
     *
     * @var int VIOLATION_EMPTY_PATH
     */
    const VIOLATION_EMPTY_PATH = 16;

    /**
     * The violation code when the user is empty.
     *
     * @var int VIOLATION_EMPTY_USER
     */
    const VIOLATION_EMPTY_USER = 32;

    /**
     * The violation code when the password is empty.
     *
     * @var int VIOLATION_EMPTY_PASSWORD
     */
    const VIOLATION_EMPTY_PASSWORD = 64;

    /**
     * The violation code when the port is missing.
     *
     * @var int VIOLATION_MISSING_PORT
     */
    const VIOLATION_MISSING_PORT = 128;

    /**
     * The violation code when the port is illegal.
     *
     * @var int VIOLATION_ILLEGAL_PORT
     */
    const VIOLATION_ILLEGAL_PORT = 256;

    /**
     * The violation code when a parameter was not allowed.
     *
     * @var int VIOLATION_ALLOWED_PARAMETER
     */
    const VIOLATION_ALLOWED_PARAMETER = 512;

    /**
     * The violation code when a parameter was blacklisted.
     *
     * @var int VIOLATION_INVALID_PARAMETER
     */
    const VIOLATION_INVALID_PARAMETER = 1024;

    /**
     * The violation when a required parameter was missing.
     *
     * @var int VIOLATION_REQUIRED_PARAMETER
     */
    const VIOLATION_REQUIRED_PARAMETER = 2048;

    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network';

    /**
     * Initialize the validator.
     */
    public function __construct()
    {
        $this->validator = $this->createValidator(
            InstructionSet::fromDefinition(
                $this->getDefinition()
            )
        );
    }

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
        }

        return $definition;
    }

    /**
     * Create a validator based on the supplied rules and parsers.
     *
     * @param InstructionSetInterface $instructions
     * @return \Closure
     */
    private function createValidator(InstructionSetInterface $instructions)
    {
        /**
         * Check whether the supplied URL is considered valid.
         *
         * @param mixed $url
         * @param ContextInterface $context
         * @return bool
         */
        return function (
            $url,
            ContextInterface $context
        ) use (
            $instructions
        ) {
            try {
                $url = $instructions->parse($url);
            } catch (ParserException $e) {
                $context->addViolation(
                    'Could not parse supplied URL',
                    Network::VIOLATION_PARSER
                );
                return false;
            }

            return $instructions->test($url, $context);
        };
    }
}
