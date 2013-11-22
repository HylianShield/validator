<?php
/**
 * Validate classes.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \HylianShield\Validator\LogicalNot;
use \HylianShield\Validator\LogicalAnd;
use \HylianShield\Validator\LogicalXor;
use \HylianShield\Validator\Object;
use \HylianShield\Validator\String;
use \HylianShield\Validator\CoreArray;
use \HylianShield\Validator\CoreClass\Exists;
use \HylianShield\Validator\CoreClass\Instance;


/**
 * CoreClass.
 */
class CoreClass extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'class';

    /**
     * Create a validator to test the existence of classes.
     */
    public function __construct()
    {
        $this->validator = new LogicalXor(
            new LogicalAnd(
                new Object,
                new LogicalNot(new CoreArray),
                new LogicalNot(new Instance('\Function'))
            ),
            new LogicalAnd(
                new String,
                new Exists
            )
        );
    }
}
