<?php

namespace App\Models;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcVendorService extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $table = 'svc_vendor_services';
}