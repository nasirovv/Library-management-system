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
        $rules = [
            'name' => 'required|string',
            'author' => 'required|string',
            'ISBN' => 'required|string',
            'description' => 'required|string',
            'count' => 'required|numeric',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'publishedYear' => 'required',
            ];

        if($this->routeIs('books.store')) {
            $rules['ISBN'] = 'required|string|unique:books,ISBN';
        }
        return $rules;
    }
}
