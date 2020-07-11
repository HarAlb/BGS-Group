<?php

namespace App\Http\Requests\Event;

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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'feature' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000',
            'event_start' => 'nullable|date',
            'event_end' => 'nullable|date|after:event_start',
        ];
    }
}
