<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppUserToDo extends Model
{
	use SoftDeletes;
	
	use HasFactory;

    public $table = 'app_user_to_dos';
}