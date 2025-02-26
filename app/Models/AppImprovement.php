<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppImprovement extends Model
{
    use HasFactory;
	// use SoftDeletingTrait;
	use SoftDeletes;

    public $table = 'app_improvements';
}
