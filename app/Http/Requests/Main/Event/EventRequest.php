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
            'adress' => ['nullable','regex:/^(https?:\/\/)?([\a-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'date' => 'required|date_format:Y-m-d|after_or_equal:today'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Etkinlik Adı',
            'time' => 'Etkinlik Saati',
            'description' => 'Etkinlik Konusu',
            'adress' => 'Etkinlik Adresi',
            'date' => 'Etkinlik Tarihi',
            'today' => 'Bugünün tarihi'
        ];
    }

}
