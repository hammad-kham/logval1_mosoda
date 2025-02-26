<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $img=$this->icon;
        if ($img=="sub_category.png") {

            $img=uploads('defaults') .'/'.$img;
        }
        else{
            $img=uploads('sub_categories') .'/'.$img;
        }
        $status=$this->status;
        (($status==1) ? $status=true : $status=false);
        return [
            'id' => $this->id,
            'cat_id' => $this->cat_id,
            'title' => $this->title,
            'ar_title' => $this->ar_title,
            'description' => $this->description,
            'ar_description' => $this->ar_description,
            'image' => $img,
            'status' => $status
        ];

    }
}