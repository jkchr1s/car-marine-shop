<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Validator;

/**
 * Trait to ask for valid console input.
 * @see https://medium.com/code16/how-to-validate-user-input-in-a-laravel-artisan-console-command-899ed197007d
 */
trait AskValid
{
    /**
     * Prompt console message with request validation.
     *
     * @param string $question
     * @param string $field
     * @param array $rules
     * @return string
     */
    protected function askValid(String $question, String $field, array $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    /**
     * Prompt console message with request validation.
     *
     * @param string $question
     * @param string $field
     * @param array $rules
     * @return string
     */
    protected function askValidSecret(String $question, String $field, array $rules)
    {
        $value = $this->secret($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askSecret($question, $field, $rules);
        }

        return $value;
    }

    /**
     * Validator for input.
     *
     * @param array $rules
     * @param string $fieldName
     * @param string $value
     * @return array|null
     */
    protected function validateInput(array $rules, String $fieldName, String $value)
    {
        $validator = Validator::make([
            $fieldName => $value,
        ], [
            $fieldName => $rules,
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
