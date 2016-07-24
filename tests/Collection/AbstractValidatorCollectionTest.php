<?php
namespace HylianShield\Tests\Validator\Collection;

use HylianShield\Tests\Validator\AbstractValidatorTestCase;
use HylianShield\Validator\Collection\AbstractValidatorCollection;

class AbstractValidatorCollectionTest extends AbstractValidatorTestCase
{
    /**
     * Create a collection.
     *
     * @return AbstractValidatorCollection
     */
    protected function createCollection(): AbstractValidatorCollection
    {
        return $this->getMockForAbstractClass(
            AbstractValidatorCollection::class
        );
    }

    /**
     * Provide a collection.
     *
     * @return AbstractValidatorCollection[][]
     */
    public function collectionProvider(): array
    {
        return [
            [$this->createCollection()]
        ];
    }

    /**
     * Test the identifier for a collection with a multitude of validators.
     *
     * @param AbstractValidatorCollection $collection
     *
     * @return void
     * @dataProvider collectionProvider
     */
    public function testCombinedIdentifier(
        AbstractValidatorCollection $collection
    ) {
        $bar = $this->createValidatorMock('Bar');
        $baz = $this->createValidatorMock('Baz');

        $collection->addValidator($bar);
        $collection->addValidator($baz);

        $this->assertEquals(
            sprintf('%s(<Bar>, <Baz>)', $collection::COLLECTION_TYPE),
            $collection->getIdentifier()
        );

        $collection->removeValidator($bar);

        $this->assertEquals(
            sprintf('%s(<Baz>)', $collection::COLLECTION_TYPE),
            $collection->getIdentifier()
        );
    }
}
