<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'full_name' => trim((string) $this->input('full_name')),
            'email' => strtolower(trim((string) $this->input('email'))),
        ]);
    }

    /**
     * The same email may book more than once (e.g. a lecturer testing the form).
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
            'birthdate' => ['required', 'date', 'before:today'],
            'ticket_category' => ['required', Rule::in(array_keys(config('concert.tickets')))],
            'quantity' => ['required', 'integer', 'min:1', 'max:'.config('concert.max_quantity')],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.confirmed' => 'The password confirmation does not match.',
            'birthdate.before' => 'Please enter a valid birthdate.',
            'ticket_category.in' => 'Please choose a ticket category.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'full_name' => 'full name',
            'ticket_category' => 'ticket category',
        ];
    }
}
