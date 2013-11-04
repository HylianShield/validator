<?php
/**
 * Validate MySQL dates.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Date;

/**
 * Mysql.
 */
class Mysql extends \HylianShield\Validator\Regexp
{
    /**
     * The type.
     *
     * @var integer $type
     */
    protected $type = 'date_mysql';

    /**
     * The pattern used when validating.
     *
     * @var string $pattern
     */
    private $pattern = '/^\d{4}\-\d{2}\-\d{2}$/';

    /**
     * Initialize the validator.
     */
    final public function __construct()
    {
        parent::__construct($this->pattern);
    }
}
