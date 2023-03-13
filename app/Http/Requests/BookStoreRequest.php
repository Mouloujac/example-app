<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'googlebook_id' => ['required', 'string', 'max:200'],
            'title' => ['nullable', 'string', 'max:400'],
            'description' => ['nullable', 'string'],
            'author' => ['nullable', 'string', 'max:250'],
            'img' => ['nullable', 'string'],
            'note_id' => ['nullable', 'integer', 'exists:notes,id'],
            'commentaire_id' => ['nullable', 'integer', 'exists:commentaires,id'],
        ];
    }
}
