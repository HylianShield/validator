<?php
namespace HylianShield\Validator\Collection;

class MatchAllCollection extends AbstractValidatorCollection
{
    /**
     * The type of collection.
     *
     * @var string
     */
    const COLLECTION_TYPE = 'all';

    /**
     * Validate the given subject.
     *
     * @param mixed $subject
     * @return bool
     */
    public function validate($subject): bool
    {
        $validators = $this->getStorage();
        $valid = $validators->count() > 0;

        foreach ($validators as $validator) {
            $valid = $validator->validate($subject);

            // No need to keep on checking.
            if ($valid !== true) {
                break;
            }
        }

        return $valid;
    }
}
