<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactDetail extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'contact_details';

    public $fillable = [
        'title',
        'value',


    ];
    public static $rules = [
        'title' => 'required',
        'value' => 'required',

    ];
    public static $updaterules = [
        'title' => 'required',
        'value' => 'required',

    ];
}
