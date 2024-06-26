<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user !=null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // using json to store object
        return [
            '*.customerId' => ['required', 'integer'],
            '*.amount'=> ['required', 'numeric' ],
            '*.status'=> ['required', Rule::in(['B', 'P', 'V', 'b','p','v'])],// B: billed, P: Paid, V: Void
            '*.billedDate'=> ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate'=> ['date_format:Y-m-d H:i:s', 'nullable'],            
        ];
    }

    // Prepare for validation from user to database
    protected function prepareForValidation(){
        $data = [];
        //type from data likes: customer_id, billed_date, paid_date convert to customerId, billedDate, paidDate from user
        foreach ($this->toArray() as $obj){
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }    
}
