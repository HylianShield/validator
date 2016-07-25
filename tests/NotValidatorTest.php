<?php
namespace HylianShield\Tests\Validator;

use HylianShield\Validator\NotValidator;

class NotValidatorTest extends AbstractValidatorTestCase
{
    /**
     * Test the identifier for a NOT validator.
     *
     * @return void
     */
    public function testGetIdentifier()
    {
        $validator = new NotValidator(
            $this->createValidatorMock(static::VALIDATION_SUBJECT)
        );

        $this->assertRegExp('/^not\(<.+>\)$/', $validator->getIdentifier());
    }

    /**
     * Test that the validator inverts validation results.
     *
     * @return void
     */
    public function testInvertedValidation()
    {
        $validator = new NotValidator(
            $this->createValidatorMock(static::VALIDATION_SUBJECT)
        );

        $this->assertFalse($validator->validate(static::VALIDATION_SUBJECT));
        $this->assertTrue($validator->validate('Clearly not a valid value'));
    }
}
