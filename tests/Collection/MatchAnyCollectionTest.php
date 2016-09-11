<?php
namespace HylianShield\Tests\Validator\Collection;

use HylianShield\Validator\Collection\AbstractValidatorCollection;
use HylianShield\Validator\Collection\MatchAnyCollection;

class MatchAnyCollectionTest extends AbstractValidatorCollectionTest
{
    /**
     * @return AbstractValidatorCollection
     */
    protected function createCollection(): AbstractValidatorCollection
    {
        return new MatchAnyCollection();
    }

    /**
     * Test the validate method.
     *
     * @param AbstractValidatorCollection $collection
     *
     * @dataProvider collectionProvider
     * @return MatchAnyCollection
     */
    public function testValidate(
        AbstractValidatorCollection $collection
    ): MatchAnyCollection {
        $this->assertFalse($collection->validate($this->getValidationSubject()));

        $foo = $this->createValidatorMock('Foo');
        $foo
            ->expects($this->once())
            ->method('validate')
            ->with('Bar')
            ->willReturn(false);
        $collection->addValidator($foo);

        $bar = $this->createValidatorMock('Bar');
        $bar
            ->expects($this->once())
            ->method('validate')
            ->with('Bar')
            ->willReturn(true);
        $collection->addValidator($bar);

        $baz = $this->createValidatorMock('Baz');
        $baz
            ->expects($this->never())
            ->method('validate');
        $collection->addValidator($baz);

        $this->assertTrue($collection->validate('Bar'));

        return $collection;
    }
}
