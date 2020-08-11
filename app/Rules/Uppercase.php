<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/*
    Developer   : Muhammad Rizky Firdaus
    Date        : 11-08-2020
    Description : Make Rules uppercase for 'item' 
 
*/

class Uppercase implements Rule
{
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
        return strtoupper($value) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
       return 'The :attribute must be uppercase.';
    }
}
