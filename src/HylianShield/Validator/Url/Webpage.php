<?php
/**
 * Validate webpage URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Url;

/**
 * Webpage.
 */
class Webpage extends \HylianShield\Validator\LogicalXor
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_webpage';

    /**
     * A list of validators.
     *
     * @var array $validators
     */
    protected $validators = array(
        '\HylianShield\Validator\Url\Network\Http',
        '\HylianShield\Validator\Url\Network\Https'
    );
}
