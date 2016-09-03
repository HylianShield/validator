<?php
namespace HylianShield\Tests\Validator;

use HylianShield\Validator\ValidatorInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

abstract class AbstractValidatorTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @return string
     */
    protected function getValidationSubject(): string
    {
        return 'Foo';
    }

    /**
     * Create a validator for the given subject.
     *
     * @param string $subject
     *
     * @return ValidatorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createValidatorMock(string $subject): ValidatorInterface
    {
        $validator = $this->createMock(ValidatorInterface::class);

        $validator
            ->expects($this->any())
            ->method('validate')
            ->willReturnCallback(
                function ($input) use ($subject) {
                    return $input === $subject;
                }
            );

        $validator
            ->expects($this->any())
            ->method('getIdentifier')
            ->willReturn($subject);

        return $validator;
    }
}
