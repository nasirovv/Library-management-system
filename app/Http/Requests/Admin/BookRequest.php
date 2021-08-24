<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'name' => 'required|string',
            'author' => 'required|string',
            'ISBN' => 'required|string',
            'description' => 'required|string',
            'originalCount' => 'required|numeric',
            'count' => 'required|numeric',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'publishedDate' => 'required',
        ];
    }
}
