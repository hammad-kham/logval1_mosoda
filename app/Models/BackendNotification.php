<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackendNotification extends Model
{
	use SoftDeletes;
	
	use HasFactory;

    public $table = 'backend_notifications';
}