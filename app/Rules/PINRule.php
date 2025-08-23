<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PINRule implements ValidationRule
{

    protected string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (!ctype_digit($value)) {
            $fail("{$this->type} može sadržavati samo znamenke od 0-9");
            return;
        }

        if ($this->type === 'JMBAG' && strlen($value) !== 10) {
            $fail("{$this->type} mora imati 10 znamenki");
        }

        if ($this->type === 'OIB' && strlen($value) !== 11) {
            $fail("{$this->type} mora imati 11 znamenki.");
        }
    }
}
