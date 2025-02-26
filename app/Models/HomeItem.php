<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeItem extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $table = 'home_items';
}