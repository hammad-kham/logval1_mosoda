<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppSlide extends JsonResource
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
        if ($img=="slide.png") {

            $img=uploads('defaults') .'/'.$img;
        }

        else{
            $img=uploads('app_slides') .'/'.$img;
        }

        $status=$this->status;
        (($status==1) ? $status=true : $status=false);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'ar_title' => $this->ar_title,
            'module' => $this->module,
            'type' => $this->type,
            'description' => $this->description,
            'ar_description' => $this->ar_description,
            'image' => $img,
            'status' => $status,
        ];

    }
}