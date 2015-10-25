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
interface ProtocolDefinitionInterface
{
    /**
     * Getter for the allowedSchemes property.
     *
     * @return array
     * @throws \LogicException when property allowedSchemes is not set.
     */
    public function getAllowedSchemes();

    /**
     * Getter for the allowedPorts property.
     *
     * @return array
     * @throws \LogicException when property allowedPorts is not set.
     */
    public function getAllowedPorts();

    /**
     * Getter for the requirePort property.
     *
     * @return boolean
     * @throws \LogicException when property requirePort is not set.
     */
    public function isRequirePort();

    /**
     * Getter for the emptyPathAllowed property.
     *
     * @return boolean
     * @throws \LogicException when property emptyPathAllowed is not set.
     */
    public function isEmptyPathAllowed();

    /**
     * Getter for the requireUser property.
     *
     * @return boolean
     * @throws \LogicException when property requireUser is not set.
     */
    public function isRequireUser();

    /**
     * Getter for the requirePassword property.
     *
     * @return boolean
     * @throws \LogicException when property requirePassword is not set.
     */
    public function isRequirePassword();

    /**
     * Getter for the allowedParameters property.
     *
     * @return array
     * @throws \LogicException when property allowedParameters is not set.
     */
    public function getAllowedParameters();

    /**
     * Whether the definition holds allowed parameters.
     *
     * @return bool
     */
    public function hasAllowedParameters();

    /**
     * Getter for the invalidParameters property.
     *
     * @return array
     * @throws \LogicException when property invalidParameters is not set.
     */
    public function getInvalidParameters();

    /**
     * Whether the definition holds invalid parameters.
     *
     * @return bool
     */
    public function hasInvalidParameters();

    /**
     * Getter for the requiredParameters property.
     *
     * @return array
     * @throws \LogicException when property requiredParameters is not set.
     */
    public function getRequiredParameters();

    /**
     * Whether the definition holds required parameters.
     *
     * @return bool
     */
    public function hasRequiredParameters();

    /**
     * Get whether or not the query parameters hold configuration.
     *
     * @return bool
     */
    public function hasQueryConfiguration();
}
