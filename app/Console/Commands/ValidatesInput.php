<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ValidatesInput
{
    protected ValidatorContract $validator;

    abstract protected function rules(): array;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->validator()->fails()) {
            throw new InvalidArgumentException($this->formatErrors());
        }

        return parent::execute($input, $output);
    }

    protected function validator(): ValidatorContract
    {
        if (isset($this->validator)) {
            return $this->validator;
        }

        return $this->validator = Validator::make(
            $this->getDataToValidate(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );
    }

    protected function getDataToValidate(): array
    {
        $data = array_merge($this->arguments(), $this->options());

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

    protected function formatErrors(): string
    {
        return implode(PHP_EOL, $this->validator()->errors()->all());
    }

    protected function messages(): array
    {
        return [];
    }

    protected function attributes(): array
    {
        return [];
    }
}
