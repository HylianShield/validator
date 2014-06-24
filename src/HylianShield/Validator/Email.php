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
