<?php

namespace App\Http\Requests\Main\Question;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|max:1000|min:4'
        ];
    }

    public function attributes()
    {
        return [
            'question' => 'soru'
        ];
    }
}
