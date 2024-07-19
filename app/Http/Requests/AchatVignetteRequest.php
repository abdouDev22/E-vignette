<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchatVignetteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|numeric',
            'password' => 'required|string',
        ];
    }
}
