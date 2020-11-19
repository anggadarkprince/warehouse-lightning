<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Name implements Rule
{
    private $field = 'field';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $this->field = $attribute;

        return preg_match('/^[A-Za-z ,.\']+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ' . $this->field . ' should a valid name.';
    }
}
