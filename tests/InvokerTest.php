<?php
namespace HylianShield\Tests\Validator;

use HylianShield\Validator\Invoker;

class InvokerTest extends AbstractValidatorTestCase
{
    /**
     * Test the functionality of the invoker.
     *
     * @return void
     */
    public function testInvoker()
    {
        $invoker = new Invoker($this->createValidatorMock('foo'));

        $this->assertTrue($invoker('foo'));
        $this->assertFalse($invoker('bar'));
    }
}
