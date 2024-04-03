<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Rewrite to display A CUSTOMER in the api route, if not rewriting, it will display all variables from the table sql
        //For example: localhost:8000/api/v1/customers/1
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'type'=>$this->type,
            'email'=>$this->email,
            'address'=>$this->address,
            'city'=>$this->city,
            'state'=>$this->state,
            'postalCode'=>$this->post_code
        ];
    }
}
