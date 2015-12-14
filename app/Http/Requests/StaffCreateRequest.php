<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StaffCreateRequest extends Request
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
            'txtName' => 'required',
            'txtBirth' => 'required',
            'position' => 'required|not_in:0',
            'level' => 'required|not_in:0',
            'txtEmail' => 'required|unique:staff,email|regex:/^[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,6}/',
            'txtPhone' => 'required|numeric',
            'rActive' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'txtName.required' => 'Please enter name !',
            'txtBirth.required' => 'Please enter birth !',
            'position.required' => 'Please choose position !',
            'position.not_in' => 'Please choose position !',
            'level.required' => 'Please choose level !',
            'level.not_in' => 'Please choose level !',
            'txtEmail.required' => 'Please enter email !',
            'txtEmail.unique' => 'Email is exists !',
            'txtEmail.regex' => 'Email is Invalid !',
            'txtPhone.required' => 'Please enter phone !',
            'txtPhone.numeric' => 'Phone is number !',
            'rActive.in' => 'Please choose type active!',
        ];
    }
}
