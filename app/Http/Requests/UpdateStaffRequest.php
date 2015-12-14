<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateStaffRequest extends Request
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
            'txtPhone' => 'required|numeric',
            
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
            'txtPhone.required' => 'Please enter phone !',
            'txtPhone.numeric' => 'Phone is number !',
        ];
    }
}
