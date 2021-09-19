<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'bookId' => 'required|integer',
            'wantedDate' => 'required|date_format:Y-m-d',
            'wantedDuration' => 'required|integer'
        ];
    }
}
