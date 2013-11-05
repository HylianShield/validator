<?php
/**
 * Validate HTTPS URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Url\Network;

/**
 * Https.
 */
class Https extends \HylianShield\Validator\Url\Network
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network_https';

    /**
     * Variable description
     *
     * @var array $allowedSchemes
     */
    protected $allowedSchemes = array('https');

    /**
     * A list of allowed ports.
     *
     * @var array $allowedPorts
     */
    protected $allowedPorts = array(443);
}
