<?php
/**
 * Test for \HylianShield\Validator\Date\Mysql.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator\Date;

use \HylianShield\Validator\Date\Mysql;

/**
 * MysqlTest.
 */
class MysqlTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Date\Mysql';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('0000-00-00', true),
        array('AB12-00-00', false),
        array('2013-12-12', true),
        array('2012-12-12-12', false)
    );
}
