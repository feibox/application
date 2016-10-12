<?php

namespace App\Validators;

class StubaEmailValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        if (\Validator::make([$attribute => $value], [$attribute => 'email'])->passes()) {
            $email_parts = explode('@', $value);
            if ($email_parts[1] == 'stuba.sk' || $email_parts[1] == 'is.stuba.sk') {
                return true;
            }
        }
        return false;
    }
}
