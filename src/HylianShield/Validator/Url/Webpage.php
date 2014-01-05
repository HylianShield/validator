<?php
/**
 * Validate webpage URLs.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Url;

use \HylianShield\Validator\LogicalOr;
use \HylianShield\Validator\Url\Network\Http;
use \HylianShield\Validator\Url\Network\Https;

/**
 * Webpage.
 */
class Webpage extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url_webpage';

    /**
     * Create a validator for webpages.
     */
    public function __construct()
    {
        $this->validator = new LogicalOr(new Http, new Https);
    }
}
