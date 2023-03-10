<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:400'],
            'author' => ['required', 'string', 'max:250'],
            'note_id' => ['required', 'integer', 'exists:notes,id'],
            'commentaire_id' => ['required', 'integer', 'exists:commentaires,id'],
        ];
    }
}
