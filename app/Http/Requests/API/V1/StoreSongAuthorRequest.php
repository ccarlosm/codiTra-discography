<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSongAuthorRequest extends FormRequest
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
            'song_id' => [
                'required',
                'integer',
                'exists:App\Models\V1\Song,id',
            ],
            'author_id' => [
                'required',
                'integer',
                'exists:App\Models\V1\Author,id',
                // Use Rule::unique to enforce unique combination of song_id and author_id
                Rule::unique('song_authors')->where(function ($query) {
                    return $query->where('song_id', $this->song_id);
                }),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'author_id.unique' => __('validation.pivot_tables.author_id.unique'),
        ];
    }
}
