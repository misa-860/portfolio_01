<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'contents' => ['required', 'max:140'],
            'image' => [
                'required',
            	'file', // ファイルがアップロードされている
            	'image', // 画像ファイルである
            	'mimes:jpeg,jpg,png', // 形式はjpegかpng
            	'dimensions:min_width=100,min_height=100', 
            	'max:10240'
            ],
        ];
    }
}
