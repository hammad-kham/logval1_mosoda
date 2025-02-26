<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcService extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $table = 'svc_services';


    protected $fillable = [
        'cat_id',
        'sub_cat_id',
        'title',
        'ar_title',
        'description',
        'ar_description',
        'icon',
        'small_price',
        'medium_price',
        'large_price',
        'created_by',
    ];

}