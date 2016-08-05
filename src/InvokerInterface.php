<?php
/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */
namespace HylianShield\Validator;

interface InvokerInterface
{
    /**
     * Forward the invocation to the validate method of the validator.
     *
     * @return bool
     */
    public function __invoke() : bool;
}
