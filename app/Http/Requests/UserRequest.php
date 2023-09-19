<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required', Rule::unique('users')->ignore(\Auth::user())],
            'profile' => ['max:150','nullable'],
            'image' => [
                'nullable',
                'file', 
                'image',
                'mimes:jpeg,jpg,png',
                'dimensions:min_width=50,min_height=50,max_width=400,max_height=400',
                'max:200',
            ],
        ];
    }
}
