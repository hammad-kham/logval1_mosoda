<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcBrandOption extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'svc_brand_options';


}
