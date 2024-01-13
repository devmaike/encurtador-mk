<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreUrlRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url_original' =>  ['required', 'url', 'max:2048', function ($attribute, $value, $fail) {
                foreach ($this->urlBlockList() as $blockedUrl) {
                    if (Str::contains($value, $blockedUrl)) {
                        $fail('Essa URL não é permitida.');
                    }
                }
            }],
            'data_expiracao' => ['nullable', 'date', 'after_or_equal:today'],
            'apelido' => ['nullable', 'string', 'unique:urls,short_url', 'max:25']
        ];
    }

    public function urlBlockList(): array
    {
        return [
            config('app.url'),
        ];
    }

    
}
