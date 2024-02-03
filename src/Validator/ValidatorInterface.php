<?php

namespace Validator;

interface ValidatorInterface
{
    public function validate($value): bool;
}