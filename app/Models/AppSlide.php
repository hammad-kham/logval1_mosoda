<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSlide extends Model
{
    use SoftDeletes;

    use HasFactory;

    //  public $table = 'app_slides';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'ar_title',
        'image',
        'description',
        'ar_description',

        // 'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'ar_title' => 'string',
        'description' => 'string',
        'ar_description' => 'string',
        'image' => 'string',
        // 'status' => 'tinyInteger'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'ar_title' => 'required',
        'image' => 'required',
        'description' => 'required',
        'ar_description' => 'required',
        //'status' => 'exit'
    ];

    public static $updaterules = [
        'title' => 'required',
        'ar_title' => 'required',
        'description' => 'required',
        'ar_description' => 'required',

    ];
}
