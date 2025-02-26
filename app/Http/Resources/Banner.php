<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Banner extends JsonResource
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
       if ($img=="banner.png") {

        $img=uploads('defaults') .'/'.$img;
    }
    else{
        $img=uploads('banners') .'/'.$img;
    }
    $status=$this->status;
    (($status==1) ? $status=true : $status=false);
        return [
            'id' => $request->id,
            'page_id' => $this->page_id,
            'location_id' => $this->location_id,
            'image' => $img,
            'description' => $this->description,
            'link' => $this->link,
            'status' => $status,

        ];
    }
}