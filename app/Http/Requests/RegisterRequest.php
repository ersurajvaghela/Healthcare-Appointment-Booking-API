<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Http\Traits\Requests\RequestTraits;

class RegisterRequest extends FormRequest {

    use RequestTraits;

    /**
     * 
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * 
     * @return array
     */
    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

}
