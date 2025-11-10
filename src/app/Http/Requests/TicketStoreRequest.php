<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TicketStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\+[1-9]\d{1,14}$/',
            'subject' => 'required|string|max:255',
            'text' => 'required|string',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:pdf,jpeg,jpg,png,gif',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->formatPhone($this->input('phone')),
        ]);
    }

    private function formatPhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        $phone = preg_replace('/[^\d+]/', '', $phone);
        if (! str_contains($phone, '+')) {
            $phone = '+'.$phone;
        }

        return $phone;
    }
}
