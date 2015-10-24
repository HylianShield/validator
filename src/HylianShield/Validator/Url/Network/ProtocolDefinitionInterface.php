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
     * Getter for the allowedQueryParameters property.
     *
     * @return array
     * @throws \LogicException when property allowedQueryParameters is not set.
     */
    public function getAllowedQueryParameters();

    /**
     * Whether the definition holds allowed parameters.
     *
     * @return bool
     */
    public function hasAllowedParameters();

    /**
     * Getter for the invalidQueryParameters property.
     *
     * @return array
     * @throws \LogicException when property invalidQueryParameters is not set.
     */
    public function getInvalidQueryParameters();

    /**
     * Whether the definition holds invalid parameters.
     *
     * @return bool
     */
    public function hasInvalidParameters();

    /**
     * Getter for the requiredQueryParameters property.
     *
     * @return array
     * @throws \LogicException when property requiredQueryParameters is not set.
     */
    public function getRequiredQueryParameters();

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
