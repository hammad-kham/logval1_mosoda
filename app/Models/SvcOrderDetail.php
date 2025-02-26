<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcOrderDetail extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'svc_order_details';
}