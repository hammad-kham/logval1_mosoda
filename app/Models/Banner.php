<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Banner extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'banners';

    public $fillable = [
        'title',
        'ar_title',
        'page_id',
        'location_id',
        'image',
        'link',        
        'status',        
        
    ];
    public static $rules = [
        'title' => 'required',
        'ar_title' => 'required',
        'location_id' => 'required',
        'page_id' => 'required',
        'link'=> 'required',       
        'image' => 'required',
    ];
    public static $updaterules = [
       'title' => 'required',
       'ar_title' => 'required',
       'location_id' => 'required',
       'page_id' => 'required',
       'link'=> 'required',              
   ];
}
