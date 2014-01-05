<?php
/**
 * Validate network URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Url;

/**
 * Network.
 */
class Network extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network';

    /**
     * Variable description
     *
     * @var array $allowedSchemes
     */
    protected $allowedSchemes = array();

    /**
     * A list of allowed ports.
     *
     * @var array $allowedPorts
     */
    protected $allowedPorts = array();

    /**
     * Require a port to be given. By default a port can be left out in a URL.
     *
     * @var boolean $requirePort
     */
    protected $requirePort = false;

    /**
     * Whether an empty path is allowed. A path should still be present.
     *
     * @var boolean $emptyPathAllowed
     */
    protected $emptyPathAllowed = true;

    /**
     * Whether we require a user.
     *
     * @var boolean $requiresUser
     */
    protected $requireUser = false;

    /**
     * Whether we require a password.
     *
     * @var boolean $requirePassword
     */
    protected $requirePassword = false;

    /**
     * A list of allowed query parameters.
     *
     * @var array $allowedQueryParameters
     */
    protected $allowedQueryParameters = array();

    /**
     * A list of invalid query parameters.
     *
     * @var array $invalidQueryParameters
     */
    protected $invalidQueryParameters = array();

    /**
     * A list of required query parameters.
     *
     * @var array $requiredQueryParameters
     */
    protected $requiredQueryParameters = array();

    /**
     * Initialize the validator.
     */
    final public function __construct()
    {
        // These references are so we can safely introduce the selected properties
        // in the scope of the validator in PHP <= 5.3.

        $schemes =& $this->allowedSchemes;
        $ports =& $this->allowedPorts;
        $allowedParameters =& $this->allowedQueryParameters;
        $requiredParameters =& $this->requiredQueryParameters;
        $invalidParameters =& $this->invalidQueryParameters;

        $emptyPathAllowed =& $this->emptyPathAllowed;
        $requireUser =& $this->requireUser;
        $requirePassword =& $this->requirePassword;
        $requirePort =& $this->requirePort;

        $this->validator = function ($url) use (
            $schemes,
            $emptyPathAllowed,
            $requireUser,
            $requirePassword,
            $requirePort,
            $ports,
            $allowedParameters,
            $requiredParameters,
            $invalidParameters
        ) {
            $parsed = parse_url($url);
            
            // The URL is seriously malformed. Nothing more we can do.
            if (empty($parsed)) {
                // @codeCoverageIgnoreStart
                return false;
                // @codeCoverageIgnoreEnd
            }

            // We always need a host.
            if (empty($parsed['host'])) {
                return false;
            }

            // There must be a scheme present.
            if (empty($parsed['scheme'])) {
                return false;
            }

            // Additionally, if we only allow a range of schemes, test for that.
            if (!empty($schemes)&& !in_array($parsed['scheme'], $schemes)) {
                return false;
            }

            // If an empty path is disallowed, that will be checked later on.
            $path = isset($parsed['path'])
                ? trim($parsed['path'], '/')
                : '';

            // @codeCoverageIgnoreStart
            // @todo Extend the corresponding tests when there are
            // actually implementations using this.
            // Currently, this logic will never be triggered.

            // We don't allow empty paths.
            if (!$emptyPathAllowed && empty($path)) {
                return false;
            }

            // Check if we meet the user requirement.
            if ($requireUser && empty($parsed['user'])) {
                return false;
            }

            // Check if we meet the password requirement.
            if ($requirePassword && empty($parsed['pass'])) {
                return false;
            }

            // Check if our port meets the requirements.
            if ($requirePort && empty($parsed['port'])) {
                return false;
            }

            // Check if the port meets our supplied range.
            if (!empty($parsed['port'])
                && !empty($ports)
                && !in_array((int) $parsed['port'], $ports)
            ) {
                return false;
            }

            // @codeCoverageIgnoreEnd

            // Test the query for invalid parameters.
            if (!empty($parsed['query'])) {
                parse_str($parsed['query'], $query);
                $queryKeys = array_keys($query);

                // @codeCoverageIgnoreStart
                // @todo Extend the corresponding tests when there are
                // actually implementations using this.
                // Currently, this logic will never be triggered.

                // Check if any of the parameters is not allowed.
                if (!empty($allowedParameters)) {
                    foreach ($queryKeys as $key) {
                        // Well, this particular one was not allowed.
                        if (!in_array($key, $allowedParameters)) {
                            return false;
                        }
                    }
                }

                // Check if one of them matches the invalid list.
                if (!empty($invalidParameters)) {
                    foreach ($queryKeys as $key) {
                        // Well, this particular one was not allowed.
                        if (in_array($key, $invalidParameters)) {
                            return false;
                        }
                    }
                }

                // Check if all required keys are present.
                if (!empty($requiredParameters)) {
                    foreach ($requiredParameters as $required) {
                        // Well, this one wasn't present.
                        if (!in_array($required, $queryKeys)) {
                            return false;
                        }
                    }
                }

                // @codeCoverageIgnoreEnd
            } elseif (!empty($requiredParameters)) {
                // @codeCoverageIgnoreStart
                return false;
                // @codeCoverageIgnoreEnd
            }

            return true;
        };
    }
}
