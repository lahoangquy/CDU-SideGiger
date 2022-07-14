<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'category_id' => ['required'],
            'description' => ['required'],
            'files' => ['nullable', 'array'],
            'files.*.file' => ['string', 'max:255'],
            'files.*.extension' => ['string', 'max:50'],
            'due_date' => ['date']
        ];
    }
}
