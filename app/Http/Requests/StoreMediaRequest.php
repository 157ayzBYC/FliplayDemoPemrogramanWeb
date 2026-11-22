<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPatch = $this->isMethod('PATCH');
        $mediaId = $this->route('media')?->id;

        return [
            'title'       => ($isPatch ? 'sometimes|' : 'required|') . 'string|max:255|unique:media,title,' . $mediaId,
            'type'        => ($isPatch ? 'sometimes|' : 'required|') . 'string|max:100',
            'genre'       => ($isPatch ? 'sometimes|' : 'required|') . 'string|max:100',
            'description' => 'nullable|string',
        ];
    }
}
