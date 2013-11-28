<?php
/**
 * Validate HTTP URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Url\Network;

/**
 * Http.
 */
class Http extends \HylianShield\Validator\Url\Network
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_network_http';

    /**
     * Variable description
     *
     * @var array $allowedSchemes
     */
    protected $allowedSchemes = array('http');

    /**
     * A list of allowed ports.
     *
     * @var array $allowedPorts
     */
    protected $allowedPorts = array(80);
}
