<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LibrarianRequest extends FormRequest
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
        if($this->getMethod() == 'POST'){
            return [
                'name' => 'required|string',
                'username' => 'required|string|unique:librarians,username',
                'password' => 'required|min:6',
                'image' => 'nullable|mimes:jpeg,jpg,png',
            ];
        }

        if($this->getMethod() == 'PATCH'){
            return [
                'name' => 'string',
                'username' => 'string|unique:librarians,username',
                'image' => 'nullable|mimes:jpeg,jpg,png',
            ];
        }

    }
}
