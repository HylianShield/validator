<?php
/**
 * Test for \HylianShield\Validator\Date\Mysql.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Date;



/**
 * MysqlTest.
 */
class MysqlTest extends \HylianShield\Tests\Validator\TestBase
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
