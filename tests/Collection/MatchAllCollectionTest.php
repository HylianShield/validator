<?php
namespace HylianShield\Tests\Validator\Collection;

use HylianShield\Validator\Collection\AbstractValidatorCollection;
use HylianShield\Validator\Collection\MatchAllCollection;

class MatchAllCollectionTest extends AbstractValidatorCollectionTest
{
    /**
     * @return AbstractValidatorCollection
     */
    protected function createCollection(): AbstractValidatorCollection
    {
        return new MatchAllCollection();
    }

    /**
     * Test the validate method.
     *
     * @param AbstractValidatorCollection $collection
     *
     * @return MatchAllCollection
     * @dataProvider collectionProvider
     */
    public function testValidate(
        AbstractValidatorCollection $collection
    ): MatchAllCollection {
        $this->assertFalse($collection->validate($this->getValidationSubject()));

        $collection->addValidator(
            $this->createValidatorMock('Foo')
        );

        $collection->addValidator(
            $this->createValidatorMock('Bar')
        );

        $this->assertFalse($collection->validate('Foo'));
        $this->assertFalse($collection->validate('Bar'));

        return $collection;
    }
}
