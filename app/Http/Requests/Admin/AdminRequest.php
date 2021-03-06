<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        if($this->has('newPassword')){
            return [
                'oldPassword' => 'required|min:6',
                'confirmPassword' => 'required|min:6',
                'username' => 'string|nullable'
            ];
        }
        return [
            'username' => 'string|nullable'
        ];
    }
}
