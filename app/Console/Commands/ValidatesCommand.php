<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class ValidatesCommand extends Command
{
    use ValidatesInput;

    protected function messages(): array
    {
        return [
            'required'   => 'input :attribute is required',
            'between'    => 'input :attribute length is not between :min to :max',
            'date'       => 'input :attribute length is not a valid date format',
            'regex'      => 'input :attribute must match the given regular expression',
            'timezone'   => 'input :attribute value is not in the valid time zone list',
            'email'      => 'input :attribute is not a valid email format',
            'exists'     => 'input :attribute does not exist',
            'unique'     => 'input :attribute already exists',
            'enum_value' => 'input :attribute is not in the allow list',
            'boolean'    => 'input :attribute only allows true or false',
        ];
    }
}
