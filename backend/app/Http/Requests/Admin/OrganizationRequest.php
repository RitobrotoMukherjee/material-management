<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
        $return = [
            'data.is_admin' => 'required|boolean',
            'data.login_id' => 'required|string|unique:users,login_id,' . $this->data['id'],
            'data.name' => 'required|string',
            'data.email' => 'required|email',
            'data.address' => 'required|string|max:150',
            'data.contact_person' => 'required|string',
            'data.contact_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,contact_no,'. $this->data['id'],
            'data.purchase_date' => 'required|date',
            'data.renewal_date' => 'required|date|after:'.$this->data['purchase_date'],
            'data.image_link' => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
        ];
        if(isset($this->data['password']) && $this->data['password'] !== ""){
            $return['data.password'] = 'string|min:5|confirmed';
        }
        if($this->data['id'] === ""){
            $return['data.image_link'] = 'required';
            $return['data.password'] = 'required|string|min:8|confirmed';
        }
        return $return;
    }
    
    public function messages() {
        return [
            'data.is_admin.required' => 'Is the user an Admin?',
            'data.is_admin.boolean' => 'User Type Is Wrong.',
            'data.login_id.required' => 'Login Id Is Required',
            'data.login_id.string' => 'Please enter a Valid Login Id',
            'data.login_id.unique' => 'This Login Id already exist, Please create a different Login Id ',
            'data.name.required' => 'Name Is Required',
            'data.name.string' => 'It is not a valid name',
            'data.email.required' => 'Email Is Required',
            'data.email.email' => 'Enter A Valid Email',
            'data.address.max' => 'Max 150 Characters Allowed For Address',
            'data.contact_person.required' => 'Contact Person Name Is Required',
            'data.contact_no.required' => 'Contact Number is required',
            'data.contact_no.regex' => 'Enter a valid phone number',
            'data.contact_no.min' => 'Contact number length should be 10',
            'data.contact_no.unique' => 'Contact Number Must be unique',
            'data.purchase_date.required' => 'Purchase Date Is Required',
            'data.purchase_date.date' => 'Purchase Date Must be a valid date',
            'data.renewal_date.required' => 'Renewal Date Is Required',
            'data.renewal_date.date' => 'Renewal Date Must be a valid date',
            'data.renewal_date.after' => 'Renewal Date Must be Greater Than Purchase Date',
            'data.image_link.required' => 'Top Image Is Required',
            'data.image_link.mimes' => 'Allowed Images Are jpg/jpeg/png',
            'data.image_link.max' => 'Maximum Allowed Image Size 2 MB',
        ];
    }
}
