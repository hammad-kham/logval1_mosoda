<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethod extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          $img=$this->image;
       if ($img=="method.png") {

        $img=uploads('defaults') .'/'.$img;
    }
    else{
        $img=uploads('payment_methods') .'/'.$img;
    }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $img,                        
        ];

    }
}