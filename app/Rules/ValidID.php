<?php

namespace App\Rules;

use App\Accounts;
use Illuminate\Contracts\Validation\Rule;

class ValidID implements Rule
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
        return Accounts::all()->associated_account_type->where("id","=","value");
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The id should be a valid id.';
    }
}
