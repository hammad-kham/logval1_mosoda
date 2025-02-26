<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Template
 * @package App\Models
 * @version March 27, 2021, 8:31 pm UTC
 *
 * @property string $title
 * @property string $icon
 * @property string $description
 */
class Template extends Model
{

    use HasFactory;

    use SoftDeletes;

    public $table = 'templates';

    public $fillable = [
        'title',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'description' => 'required',
    ];
	
    public static $updaterules = [
        'title' => 'required',
        'description' => 'required',
    ];

}