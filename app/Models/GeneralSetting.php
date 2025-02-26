<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class GeneralSetting extends Model

{

    use SoftDeletes;



    use HasFactory;



    public $table = 'general_settings';



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

