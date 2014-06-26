<?php
/**
 * Validate email addresses.
 *
 * @package HylianShield
 * @subpackage Validator
 * @see http://php.net/manual/en/filter.filters.validate.php
 */

namespace HylianShield\Validator;

/**
 * Validate email addresses.
 * It will not accept UTF-8 characters outside the ASCII range.
 * @see https://github.com/HylianShield/validator/issues/7
 *
 * Example: $validator = new \HylianShield\Validator\Email();
 * $validator->validate('navi@hylianshield.org');
 */
class Email extends \HylianShield\Validator\Filter
{
    /**
     * The type of the validator.
     *
     * @var string $type
     */
    protected $type = 'email';

    /**
     * The email validation filter.
     *
     * @var integer FILTER
     * @see http://php.net/manual/en/filter.filters.validate.php
     */
    const FILTER = FILTER_VALIDATE_EMAIL;
}
