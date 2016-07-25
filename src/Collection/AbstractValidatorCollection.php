<?php
namespace HylianShield\Validator\Collection;

use HylianShield\Validator\ValidatorCollectionInterface;
use HylianShield\Validator\ValidatorInterface;
use SplObjectStorage;

abstract class AbstractValidatorCollection implements ValidatorCollectionInterface
{
    /**
     * The type of collection.
     *
     * @var string
     */
    const COLLECTION_TYPE = 'abstract';

    /**
     * @var SplObjectStorage
     */
    private $storage;

    /**
     * The identifier for the collection of validators.
     *
     * @var string
     */
    private $identifier;

    /**
     * Storage getter.
     *
     * @return SplObjectStorage|ValidatorInterface[]
     */
    final protected function getStorage(): SplObjectStorage
    {
        if ($this->storage === null) {
            $this->storage = new SplObjectStorage();
        }

        return $this->storage;
    }

    /**
     * Reset the collection identifier.
     *
     * @return void
     */
    private function resetIdentifier()
    {
        $this->identifier = null;
    }

    /**
     * Add the given validator to the collection.
     *
     * @param ValidatorInterface $validator
     * @return ValidatorCollectionInterface
     */
    public function addValidator(
        ValidatorInterface $validator
    ): ValidatorCollectionInterface {
        $this->resetIdentifier();

        $this
            ->getStorage()
            ->attach($validator);

        return $this;
    }

    /**
     * Remove the given validator from the collection.
     *
     * @param ValidatorInterface $validator
     * @return ValidatorCollectionInterface
     */
    public function removeValidator(
        ValidatorInterface $validator
    ): ValidatorCollectionInterface {
        $this->resetIdentifier();

        $this
            ->getStorage()
            ->detach($validator);

        return $this;
    }

    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    final public function getIdentifier(): string
    {
        if ($this->identifier === null) {
            /** @var ValidatorInterface[] $validators */
            $validators = [];

            foreach ($this->getStorage() as $validator) {
                $validators[] = $validator;
            }

            $this->identifier = sprintf(
                '%s(%s)',
                static::COLLECTION_TYPE,
                implode(
                    ', ',
                    array_map(
                        function (ValidatorInterface $validator) : string {
                            return sprintf(
                                '<%s>',
                                $validator->getIdentifier()
                            );
                        },
                        $validators
                    )
                )
            );
        }

        return $this->identifier;
    }
}
