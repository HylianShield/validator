<?php
/**
 * Validate URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * Url.
 */
class Url extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url';

    /**
     * Check the validity of URLs.
     */
    public function __construct()
    {
        $this->validator = function ($url) {
            return parse_url($url) !== false;
        };
    }
}
