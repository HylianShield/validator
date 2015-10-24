<?php
/**
 * Validate network URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url;

use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Context\Indication\Assertion;
use \HylianShield\Validator\Url\Network\ProtocolDefinition;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Network.
 */
class Network extends \HylianShield\Validator
{
    /**
     * The violation code when a non-string is validated as URL.
     *
     * @var int VIOLATION_STRING
     */
    const VIOLATION_STRING = 1;

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
     * A list of rules.
     *
     * @var \Closure[] $rules
     */
    private $rules = array();

    /**
     * A list of parsers.
     *
     * @var \Closure[] $parsers
     */
    private $parsers = array();

    /**
     * Initialize the validator.
     */
    public function __construct()
    {
        $this->reset();
        $this->configure($this->getDefinition());

        $this->validator = $this->createValidator(
            $this->rules,
            $this->parsers
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
     * Configure the rules and parsers.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return void
     */
    private function configure(ProtocolDefinitionInterface $definition)
    {
        // The initial parser.
        $this->addParser($this->createUrlStringParser());

        $this->addRule($this->createHostRule());
        $this->addRule(
            $this->createSchemesRule(
                $definition->getAllowedSchemes()
            )
        );

        if (!$definition->isEmptyPathAllowed()) {
            $this->addParser($this->createPathParser());
            $this->addRule($this->createPathRule());
        }

        if ($definition->isRequireUser()) {
            $this->addRule($this->createUserRule());
        }

        if ($definition->isRequirePassword()) {
            $this->addRule($this->createPasswordRule());
        }

        $this->addRule(
            $this->createPortRule(
                $definition->getAllowedPorts(),
                $definition->isRequirePort()
            )
        );

        if ($definition->hasQueryConfiguration()) {
            $this->configureQueryRules($definition);
        }
    }

    /**
     * Configure the rules and parsers for query parameters.
     *
     * @param ProtocolDefinitionInterface $definition
     * @return void
     */
    private function configureQueryRules(
        ProtocolDefinitionInterface $definition
    ) {
        $this->addParser($this->createQueryParser());

        if ($definition->hasAllowedParameters()) {
            $this->addRule(
                $this->createAllowedParametersRule(
                    $definition->getAllowedQueryParameters()
                )
            );
        }

        if ($definition->hasInvalidParameters()) {
            $this->addRule(
                $this->createInvalidParametersRule(
                    $definition->getInvalidQueryParameters()
                )
            );
        }

        if ($definition->hasRequiredParameters()) {
            $this->addRule(
                $this->createRequiredParametersRule(
                    $definition->getRequiredQueryParameters()
                )
            );
        }
    }

    /**
     * Reset the rules and parsers.
     *
     * @return void
     */
    private function reset()
    {
        $this->rules = array();
        $this->parsers = array();
    }

    /**
     * Add a rule to the list of rules.
     *
     * @param \Closure $rule
     * @return void
     */
    final protected function addRule(\Closure $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Add a parser to the list of parsers.
     *
     * @param \Closure $parser
     * @return void
     */
    final protected function addParser(\Closure $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * Create a validator based on the supplied rules and parsers.
     *
     * @param \Closure[] $rules
     * @param \Closure[] $parsers
     * @return \Closure
     */
    private function createValidator(array $rules, array $parsers)
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
            $rules,
            $parsers
        ) {
            if (!is_string($url)) {
                $context->addViolation(
                    'Url was not a string',
                    static::VIOLATION_STRING
                );
                return false;
            }

            $valid = true;

            // Apply additional parser rules.
            foreach ($parsers as $parser) {
                $url = $parser($url);
            }

            // Check validation rules.
            foreach ($rules as $rule) {
                if (!$rule($url, $context)) {
                    $valid = false;
                    break;
                }
            }

            return $valid;
        };
    }

    /**
     * Create a generic parser for the original URL string.
     *
     * @return \Closure
     */
    protected function createUrlStringParser()
    {
        return function ($url) {
            return parse_url($url);
        };
    }

    /**
     * Create a rule for the host in the URL.
     *
     * @return \Closure
     */
    protected function createHostRule()
    {
        return function (array $url, ContextInterface $context) {
            if (empty($url['host'])) {
                $context->addViolation(
                    'Missing host index',
                    static::VIOLATION_HOST
                );
                return false;
            }

            return true;
        };
    }

    /**
     * Create a rule for allowed schemes in the URL.
     *
     * @param array $schemes
     * @return \Closure
     */
    protected function createSchemesRule(array $schemes)
    {
        return function (array $url, ContextInterface $context) use ($schemes) {
            if (empty($url['scheme'])) {
                $context->addViolation(
                    'Missing URL scheme',
                    static::VIOLATION_MISSING_SCHEME
                );
                return false;
            }

            if (empty($schemes)) {
                $context->addIntention(
                    'Skipping scheme check, as none are explicitly required'
                );
                return true;
            }

            if (!in_array($url['scheme'], $schemes, true)) {
                $context->addViolation(
                    'Illegal scheme ":scheme" encountered. '
                    . 'Expected one of: :schemes',
                    static::VIOLATION_ILLEGAL_SCHEME,
                    array(
                        'scheme' => $url['scheme'],
                        'schemes' => implode(', ', $schemes)
                    )
                );

                return false;
            }

            return true;
        };
    }

    /**
     * Create a parser for the path in the URL.
     *
     * @return \Closure
     */
    protected function createPathParser()
    {
        return function (array $url) {
            $url['path'] = isset($url['path'])
                ? trim($url['path'], '/')
                : '';

            return $url;
        };
    }

    /**
     * Create a rule for the path in the URL.
     *
     * @return \Closure
     */
    protected function createPathRule()
    {
        return function (array $url, ContextInterface $context) {
            if (empty($url['path'])) {
                $context->addViolation(
                    'Missing path',
                    static::VIOLATION_EMPTY_PATH
                );
                return false;
            }

            return true;
        };
    }

    /**
     * Create a rule for the user in the URL.
     *
     * @return \Closure
     */
    protected function createUserRule()
    {
        return function (array $url, ContextInterface $context) {
            if (empty($url['user'])) {
                $context->addViolation(
                    'Missing username',
                    static::VIOLATION_EMPTY_USER
                );
                return false;
            }

            return true;
        };
    }

    /**
     * Create a rule for the password in the URL.
     *
     * @return \Closure
     */
    protected function createPasswordRule()
    {
        return function (array $url, ContextInterface $context) {
            if (empty($url['pass'])) {
                $context->addViolation(
                    'Missing password',
                    static::VIOLATION_EMPTY_PASSWORD
                );
                return false;
            }

            return true;
        };
    }

    /**
     * Create a rule for the allowed ports in the URL.
     *
     * @param array $ports
     * @param bool $required
     * @return \Closure
     * @throws \InvalidArgumentException when $required is not a boolean
     */
    protected function createPortRule(array $ports, $required)
    {
        if (!is_bool($required)) {
            throw new \InvalidArgumentException(
                'Required flag must be a boolean: ' . gettype($required)
            );
        }

        return function (
            array $url,
            ContextInterface $context
        ) use (
            $ports,
            $required
        ) {
            $availableAssertion = new Assertion(
                'Port is available',
                !empty($url['port'])
            );
            $context->addIndication($availableAssertion);

            if ($required === true) {
                $context->addIntention('Require port');

                if ($availableAssertion->getResult() === false) {
                    $context->addViolation(
                        'Missing port index',
                        static::VIOLATION_MISSING_PORT
                    );
                    return false;
                }
            }

            if ($availableAssertion->getResult() === false) {
                $context->addIntention('Port is empty. Skipping check.');
                return true;
            }

            if (!empty($ports)) {
                $context->addIntention('Check port against list');

                if (!in_array((int) $url['port'], $ports, true)) {
                    $context->addViolation(
                        'Illegal port :port supplied. Expected one of: :ports',
                        static::VIOLATION_ILLEGAL_PORT,
                        array(
                            'port' => $url['port'],
                            'ports' => implode(', ', $ports)
                        )
                    );
                    return false;
                }
            }

            return true;
        };
    }

    /**
     * Create a parser for the query string in the URL.
     *
     * @return \Closure
     */
    protected function createQueryParser()
    {
        return function (array $url) {
            if (isset($url['query'])) {
                parse_str($url['query'], $query);
                $url['query'] = $query;
            } else {
                $url['query'] = array();
            }

            $url['queryKeys'] = array_keys($url['query']);

            return $url;
        };
    }

    /**
     * Create a rule for allowed query parameters.
     *
     * @param array $allowed
     * @return \Closure
     */
    protected function createAllowedParametersRule(array $allowed)
    {
        return function (array $url, ContextInterface $context) use ($allowed) {
            $valid = true;

            foreach ($url['queryKeys'] as $key) {
                if (!in_array($key, $allowed, true)) {
                    $context->addViolation(
                        'Parameter :parameter is not in the list: :allowed',
                        static::VIOLATION_ALLOWED_PARAMETER,
                        array(
                            'parameter' => $key,
                            'allowed' => implode(', ', $allowed)
                        )
                    );
                    $valid = false;
                    break;
                }
            }

            return $valid;
        };
    }

    /**
     * Create a rule for invalid query parameters.
     *
     * @param array $invalid
     * @return \Closure
     */
    protected function createInvalidParametersRule(array $invalid)
    {
        return function (array $url, ContextInterface $context) use ($invalid) {
            $valid = true;

            foreach ($url['queryKeys'] as $key) {
                if (in_array($key, $invalid, true)) {
                    $context->addViolation(
                        'Invalid parameter: :parameter; Illegal :illegal',
                        static::VIOLATION_INVALID_PARAMETER,
                        array(
                            'parameter' => $key,
                            'illegal' => implode(', ', $invalid)
                        )
                    );
                    $valid = false;
                    break;
                }
            }

            return $valid;
        };
    }

    /**
     * Create a rule for required query parameters.
     *
     * @param array $required
     * @return \Closure
     */
    protected function createRequiredParametersRule(array $required)
    {
        return function (
            array $url,
            ContextInterface $context
        ) use (
            $required
        ) {
            $valid = true;

            foreach ($required as $requiredParameter) {
                if (!in_array($requiredParameter, $url['queryKeys'], true)) {
                    $context->addViolation(
                        'Missing required parameter: :parameter; '
                        . 'Supplied: :parameters; '
                        . 'Required: :required',
                        static::VIOLATION_REQUIRED_PARAMETER,
                        array(
                            'parameter' => $requiredParameter,
                            'parameters' => implode(', ', $url['queryKeys']),
                            'required' => implode(', ', $required)
                        )
                    );
                    $valid = false;
                    break;
                }
            }

            return $valid;
        };
    }
}
