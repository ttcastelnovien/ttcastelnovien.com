<?php

namespace App\Rules;

use App\Models\Accounting\LedgerAccount;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AccountNumberInRange implements DataAwareRule, ValidationRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->data['parent_id'])) {
            return;
        }

        $parent = LedgerAccount::find($this->data['parent_id']);

        if (is_null($parent)) {
            return;
        }

        $prefix = rtrim($parent->code, '0');

        if (! str_starts_with((string) $value, $prefix)) {
            $fail("Le numéro du compte enfant doit commencer par $prefix.");
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
