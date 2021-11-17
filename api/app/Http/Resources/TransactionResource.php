<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "vcard" => $this->vcard,
            //"vcard_phone" => $this->vcard->phone_number,
            "date" => $this->date,
            "datetime" => $this->datetime,
            "type" => $this->type,
            "value" => $this->value,
            "old_balance" => $this->old_balance,
            "new_balance" => $this->new_balance,
            "payment_type" => $this->payment_type,
            "payment_reference" => $this->payment_reference,
            "pair_transaction" => $this->pair_transaction,
            "pair_vcard" => $this->pair_vcard,
            //"pair_vcard_phone" => $this->vcard->phone_number,
            "category_id" => $this->category_id,
            //"category_name" => $this->category->name,
            "description" => $this->description
        ];
    }
}