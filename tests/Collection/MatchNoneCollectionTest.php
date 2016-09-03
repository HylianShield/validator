<?php
namespace HylianShield\Tests\Validator\Collection;

use HylianShield\Validator\Collection\AbstractValidatorCollection;
use HylianShield\Validator\Collection\MatchNoneCollection;

class MatchNoneCollectionTest extends AbstractValidatorCollectionTest
{
    /**
     * @return AbstractValidatorCollection
     */
    protected function createCollection(): AbstractValidatorCollection
    {
        return new MatchNoneCollection();
    }

    /**
     * Test the validate method.
     *
     * @param AbstractValidatorCollection $collection
     *
     * @return void
     * @dataProvider collectionProvider
     */
    public function testValidate(AbstractValidatorCollection $collection)
    {
        $this->assertInstanceOf(MatchNoneCollection::class, $collection);
        $this->assertTrue($collection->validate($this->getValidationSubject()));

        $collection->addValidator($this->createValidatorMock('Foo'));
        $collection->addValidator($this->createValidatorMock('Bar'));

        $this->assertFalse($collection->validate('Foo'));
        $this->assertTrue($collection->validate('Baz'));
    }
}
