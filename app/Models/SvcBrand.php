<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcBrand extends Model
{
	use SoftDeletes;
	
	use HasFactory;
	
	public $table = 'svc_brands';
    

}
