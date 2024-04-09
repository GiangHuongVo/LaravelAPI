<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user !=null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // For update method, there has 2 ways of updating, PUT or PATCH
        $method = $this->method();
        // If user changes the whole ressource to data, use PUT
        if($method == 'PUT') {
            return [
                'name' => ['required'],
                'type'=> ['required', Rule::in(['I', 'B', 'i', 'b'])],
                'email'=> ['required', 'email'],
                'address'=> ['required'],
                'city'=> ['required'],
                'state'=> ['required'],
                'postalCode'=> ['required'],
            ];
        }
        else {
            // If user changes the partial ressource to data, use PATCH, "sometimes"
            return [
                'name' => ['sometimes','required'],
                'type'=> ['sometimes','required', Rule::in(['I', 'B', 'i', 'b'])],
                'email'=> ['sometimes','required', 'email'],
                'address'=> ['sometimes','required'],
                'city'=> ['sometimes','required'],
                'state'=> ['sometimes','required'],
                'postalCode'=> ['sometimes','required'],
            ];
        }        
    }

        // To allow 
    protected function prepareForValidation(){
        // check if it has postCode changes => for patch
        if($this->postalCode){
            $this->merge([
                'post_code'=>$this->postalCode
            ]);
        }        
    }    
}
