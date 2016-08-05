<?php
namespace HylianShield\Validator;

class Invoker implements InvokerInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Invoker constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Forward the invocation to the validate method of the validator.
     *
     * @return bool
     */
    public function __invoke(): bool
    {
        return $this->validator->validate(...func_get_args());
    }
}
