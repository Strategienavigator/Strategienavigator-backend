<?php

namespace App\Rules;

use App\Services\EmailService;
use Illuminate\Contracts\Validation\Rule;

class EmailBlockList implements Rule
{


    private EmailService $emailService;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
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
        return $this->emailService->checkBlockLists($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.email_block_list');
    }
}
