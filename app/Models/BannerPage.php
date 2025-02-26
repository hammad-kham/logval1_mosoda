<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerPage extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'banner_pages';
}
