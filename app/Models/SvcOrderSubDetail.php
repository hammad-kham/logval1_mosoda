<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcOrderSubDetail extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'svc_order_sub_details';
}