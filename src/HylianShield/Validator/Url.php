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
class Url extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'url';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator;

    /**
     * Check the validity of URLs.
     *
     * @param integer $minLength the minimum length of the value
     * @param integer $maxLength the maximum length of the value
     */
    public function __construct($minLength = 0, $maxLength = 0)
    {
        $this->validator = function ($url) {
            return parse_url($url) !== false;
        };

        parent::__construct($minLength, $maxLength);
    }
}
