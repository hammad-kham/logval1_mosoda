<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlowerColor extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $table = 'flower_colors';
}