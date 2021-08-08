<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class ValidateEmailExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $check_already_exists = false;
    public function __construct($already_exists = null)
    {
        if($already_exists){
            $this->check_already_exists = $already_exists;
        }
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
        //
        if($value){
            $result = User::doesExistEmail($value);
            if($this->check_already_exists){
                return !$result;
            }else{
                return $result;
            }
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
        if($this->check_already_exists){
            return 'This email already exists.';
        }else{
            return "This email doesn't exists.";
        }

    }
}
