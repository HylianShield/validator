<?php
namespace HylianShield\Validator;

use SplObjectStorage;

class ValidatorCollection implements ValidatorCollectionInterface
{
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
     * ValidatorCollection constructor.
     */
    public function __construct()
    {
        $this->storage = new SplObjectStorage();
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
            ->storage
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
            ->storage
            ->detach($validator);

        return $this;
    }

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        $validators = $this->storage;
        $valid = $validators->count() > 0;

        /** @var ValidatorInterface $validator */
        foreach ($validators as $validator) {
            $valid = $validator->validate($subject);

            // No need to keep on checking.
            if ($valid !== true) {
                break;
            }
        }

        return $valid;
    }

    /**
     * Get the identifier for the validator.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        if ($this->identifier === null) {
            /** @var ValidatorInterface[] $validators */
            $validators = [];

            foreach ($this->storage as $validator) {
                $validators[] = $validator;
            }

            $this->identifier = sprintf(
                '(%s)',
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
