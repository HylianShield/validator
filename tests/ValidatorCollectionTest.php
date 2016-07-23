<?php
namespace HylianShield\Tests\Validator;

use HylianShield\Validator\ValidatorCollection;
use HylianShield\Validator\ValidatorCollectionInterface;
use HylianShield\Validator\ValidatorInterface;
use PHPUnit_Framework_MockObject_MockObject;

class ValidatorCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The validation subject.
     *
     * @var string
     */
    const VALIDATION_SUBJECT = 'Foo';

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

    /**
     * Test the constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(
            ValidatorCollectionInterface::class,
            new ValidatorCollection()
        );
    }

    /**
     * Test adding a validator to the collection.
     *
     * @return ValidatorCollectionInterface
     */
    public function testValidation(): ValidatorCollectionInterface
    {
        $collection = new ValidatorCollection();
        $validator  = $this->createValidatorMock(static::VALIDATION_SUBJECT);

        $this->assertEquals('()', $collection->getIdentifier());
        $this->assertFalse($collection->validate(static::VALIDATION_SUBJECT));

        $collection->addValidator($validator);
        $this->assertEquals(
            sprintf('(<%s>)', static::VALIDATION_SUBJECT),
            $collection->getIdentifier()
        );
        $this->assertTrue($collection->validate(static::VALIDATION_SUBJECT));

        $collection->removeValidator($validator);
        $this->assertEquals('()', $collection->getIdentifier());
        $this->assertFalse($collection->validate(static::VALIDATION_SUBJECT));

        return $collection;
    }

    /**
     * Test the identifier for a collection with a multitude of validators.
     *
     * @return void
     */
    public function testCombinedIdentifier()
    {
        $collection = new ValidatorCollection();
        $collection->addValidator(
            $this->createValidatorMock('Bar')
        );
        $collection->addValidator(
            $this->createValidatorMock('Baz')
        );
        $this->assertEquals('(<Bar>, <Baz>)', $collection->getIdentifier());
    }
}
