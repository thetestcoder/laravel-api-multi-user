<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $on_update = $this->method() == 'PUT' ? ',' . $this->id : '';
        return [
            'name'      => 'required',
            'email'     => 'required|email|unique:users' . $on_update,
            'password'  => 'required|min:8',
            'role_id'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Name is Required',
            'email.required'    => 'Email ID is Required',
            'password.required' => 'Password is Required',
            'role_id.required'  => 'Role is Required',
            'email.unique'      => 'Email already exist! Please Login',
        ];
    }
}
