<?php
/**
 * The definition of a network protocol.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Url\Network;

/**
 * The definition of a network protocol.
 */
class ProtocolDefinition implements ProtocolDefinitionInterface
{
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
     * Getter for the allowedSchemes property.
     *
     * @return array
     * @throws \LogicException when property allowedSchemes is not set.
     */
    public function getAllowedSchemes()
    {
        if (!isset($this->allowedSchemes)) {
            throw new \LogicException('Missing property allowedSchemes');
        }

        return $this->allowedSchemes;
    }

    /**
     * Setter for the allowedSchemes property.
     *
     * @param array $allowedSchemes
     * @return static
     */
    public function setAllowedSchemes(array $allowedSchemes)
    {
        $this->allowedSchemes = $allowedSchemes;

        return $this;
    }

    /**
     * Getter for the allowedPorts property.
     *
     * @return array
     * @throws \LogicException when property allowedPorts is not set.
     */
    public function getAllowedPorts()
    {
        if (!isset($this->allowedPorts)) {
            throw new \LogicException('Missing property allowedPorts');
        }

        return $this->allowedPorts;
    }

    /**
     * Setter for the allowedPorts property.
     *
     * @param array $allowedPorts
     * @return static
     */
    public function setAllowedPorts(array $allowedPorts)
    {
        $this->allowedPorts = $allowedPorts;

        return $this;
    }

    /**
     * Getter for the requirePort property.
     *
     * @return boolean
     * @throws \LogicException when property requirePort is not set.
     */
    public function isRequirePort()
    {
        if (!isset($this->requirePort)) {
            throw new \LogicException('Missing property requirePort');
        }

        return $this->requirePort;
    }

    /**
     * Setter for the requirePort property.
     *
     * @param boolean $requirePort
     * @return static
     * @throws \InvalidArgumentException when $requirePort is not of type boolean.
     */
    public function setRequirePort($requirePort)
    {
        if (!is_bool($requirePort)) {
            throw new \InvalidArgumentException(
                'Invalid requirePort supplied: '.var_export($requirePort, true)
            );
        }
        $this->requirePort = $requirePort;

        return $this;
    }

    /**
     * Getter for the emptyPathAllowed property.
     *
     * @return boolean
     * @throws \LogicException when property emptyPathAllowed is not set.
     */
    public function isEmptyPathAllowed()
    {
        if (!isset($this->emptyPathAllowed)) {
            throw new \LogicException('Missing property emptyPathAllowed');
        }

        return $this->emptyPathAllowed;
    }

    /**
     * Setter for the emptyPathAllowed property.
     *
     * @param boolean $emptyPathAllowed
     * @return static
     * @throws \InvalidArgumentException when $emptyPathAllowed is not of type boolean.
     */
    public function setEmptyPathAllowed($emptyPathAllowed)
    {
        if (!is_bool($emptyPathAllowed)) {
            throw new \InvalidArgumentException(
                'Invalid emptyPathAllowed supplied: '.var_export(
                    $emptyPathAllowed,
                    true
                )
            );
        }
        $this->emptyPathAllowed = $emptyPathAllowed;

        return $this;
    }

    /**
     * Getter for the requireUser property.
     *
     * @return boolean
     * @throws \LogicException when property requireUser is not set.
     */
    public function isRequireUser()
    {
        if (!isset($this->requireUser)) {
            throw new \LogicException('Missing property requireUser');
        }

        return $this->requireUser;
    }

    /**
     * Setter for the requireUser property.
     *
     * @param boolean $requireUser
     * @return static
     * @throws \InvalidArgumentException when $requireUser is not of type boolean.
     */
    public function setRequireUser($requireUser)
    {
        if (!is_bool($requireUser)) {
            throw new \InvalidArgumentException(
                'Invalid requireUser supplied: '.var_export($requireUser, true)
            );
        }
        $this->requireUser = $requireUser;

        return $this;
    }

    /**
     * Getter for the requirePassword property.
     *
     * @return boolean
     * @throws \LogicException when property requirePassword is not set.
     */
    public function isRequirePassword()
    {
        if (!isset($this->requirePassword)) {
            throw new \LogicException('Missing property requirePassword');
        }

        return $this->requirePassword;
    }

    /**
     * Setter for the requirePassword property.
     *
     * @param boolean $requirePassword
     * @return static
     * @throws \InvalidArgumentException when $requirePassword is not of type boolean.
     */
    public function setRequirePassword($requirePassword)
    {
        if (!is_bool($requirePassword)) {
            throw new \InvalidArgumentException(
                'Invalid requirePassword supplied: '.var_export(
                    $requirePassword,
                    true
                )
            );
        }
        $this->requirePassword = $requirePassword;

        return $this;
    }

    /**
     * Getter for the allowedQueryParameters property.
     *
     * @return array
     * @throws \LogicException when property allowedQueryParameters is not set.
     */
    public function getAllowedQueryParameters()
    {
        if (!isset($this->allowedQueryParameters)) {
            throw new \LogicException(
                'Missing property allowedQueryParameters'
            );
        }

        return $this->allowedQueryParameters;
    }

    /**
     * Whether the definition holds allowed parameters.
     *
     * @return bool
     */
    public function hasAllowedParameters()
    {
        return (bool) $this->allowedQueryParameters;
    }

    /**
     * Setter for the allowedQueryParameters property.
     *
     * @param array $allowedQueryParameters
     * @return static
     */
    public function setAllowedQueryParameters(array $allowedQueryParameters)
    {
        $this->allowedQueryParameters = $allowedQueryParameters;

        return $this;
    }

    /**
     * Getter for the invalidQueryParameters property.
     *
     * @return array
     * @throws \LogicException when property invalidQueryParameters is not set.
     */
    public function getInvalidQueryParameters()
    {
        if (!isset($this->invalidQueryParameters)) {
            throw new \LogicException(
                'Missing property invalidQueryParameters'
            );
        }

        return $this->invalidQueryParameters;
    }

    /**
     * Whether the definition holds invalid parameters.
     *
     * @return bool
     */
    public function hasInvalidParameters()
    {
        return (bool) $this->invalidQueryParameters;
    }

    /**
     * Setter for the invalidQueryParameters property.
     *
     * @param array $invalidQueryParameters
     * @return static
     */
    public function setInvalidQueryParameters(array $invalidQueryParameters)
    {
        $this->invalidQueryParameters = $invalidQueryParameters;

        return $this;
    }

    /**
     * Getter for the requiredQueryParameters property.
     *
     * @return array
     * @throws \LogicException when property requiredQueryParameters is not set.
     */
    public function getRequiredQueryParameters()
    {
        if (!isset($this->requiredQueryParameters)) {
            throw new \LogicException(
                'Missing property requiredQueryParameters'
            );
        }

        return $this->requiredQueryParameters;
    }

    /**
     * Whether the definition holds required parameters.
     *
     * @return bool
     */
    public function hasRequiredParameters()
    {
        return (bool) $this->requiredQueryParameters;
    }

    /**
     * Setter for the requiredQueryParameters property.
     *
     * @param array $requiredQueryParameters
     * @return static
     */
    public function setRequiredQueryParameters(array $requiredQueryParameters)
    {
        $this->requiredQueryParameters = $requiredQueryParameters;

        return $this;
    }

    /**
     * Get whether or not the query parameters hold configuration.
     *
     * @return bool
     */
    public function hasQueryConfiguration()
    {
        return (
            $this->allowedQueryParameters
            || $this->invalidQueryParameters
            || $this->requiredQueryParameters
        );
    }
}
