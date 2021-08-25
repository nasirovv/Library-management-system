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
        if($this->routeIs('librarians.store')){
            return [
                'fullName' => 'required|string',
                'username' => 'required|string|unique:librarians,username',
                'password' => 'required|min:6',
                'image' => 'nullable|mimes:jpeg,jpg,png',
            ];
        }

        if($this->except('password')){
            return [
                'fullName' => 'required|string',
                'username' => 'required|string',
                'image' => 'nullable|mimes:jpeg,jpg,png',
            ];
        }

    }
}
