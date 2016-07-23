<?php
namespace HylianShield\Validator;

interface ValidatorCollectionInterface extends ValidatorInterface
{
    /**
     * Add the given validator to the collection.
     *
     * @param ValidatorInterface $validator
     * @return ValidatorCollectionInterface
     */
    public function addValidator(
        ValidatorInterface $validator
    ): ValidatorCollectionInterface;

    /**
     * Remove the given validator from the collection.
     *
     * @param ValidatorInterface $validator
     * @return ValidatorCollectionInterface
     */
    public function removeValidator(
        ValidatorInterface $validator
    ): ValidatorCollectionInterface;
}
