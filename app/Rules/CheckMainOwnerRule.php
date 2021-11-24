<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckMainOwnerRule implements Rule
{
    private $owners;

    /**
     * Create a new rule instance.
     *
     * @param  array  $owners
     * @return void
     */
    public function __construct($owners)
    {
        $this->owners = $owners;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->owners && is_array($this->owners) > 0) {
            return in_array($value, $this->owners);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "This :attribute is not in owners list";
    }
}
