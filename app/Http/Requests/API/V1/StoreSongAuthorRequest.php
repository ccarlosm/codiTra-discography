<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreSongAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'song_id' => 'required|integer|exists:App\Models\V1\Song,id|unique:App\Models\V1\SongAuthor,song_id,'.$this->song_id.',author_id,'.$this->author_id,
            'author_id' => 'required|integer|exists:App\Models\V1\Author,id',
        ];
    }
}
