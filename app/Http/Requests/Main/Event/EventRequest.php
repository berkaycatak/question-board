<?php

namespace App\Http\Requests\Main\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'name' => 'required|max:255|min:5',
            'time' => 'required|max:5|min:5',
            'description' => 'nullable|max:1000',
            'adress' => 'nullable|max:500',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'adı',
            'time' => 'saati',
            'description' => 'konusu',
            'adress' => 'adresi',
            'date' => 'tarihi',
            'today' => 'bugünün tarihi'
        ];
    }

}
