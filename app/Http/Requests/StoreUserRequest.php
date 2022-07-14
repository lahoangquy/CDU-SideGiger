<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
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
            'type' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => [
                'required',
                'email:filter',
                'unique:users,email',
            ],
            'phone' => ['required', 'numeric'],
            'student_id' => 'exclude_unless:type,tasker|required',
            'course_name' => 'exclude_unless:type,tasker|required',
            'department' => 'exclude_unless:type,poster|required',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('email', 'regex:/^.+@students.cdu.edu.au$/i', function ($input) {
            return $input->type === 'tasker';
        });
    }
}
