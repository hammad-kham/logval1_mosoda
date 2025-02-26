<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerLocation extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'banner_locations';

    public $fillable = [
        'location',
       
    ];
    public static $rules = [
        'location' => 'required',
      
    ];
}
