<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SvcVendor extends Model
{
    use HasFactory;
	// use SoftDeletingTrait;
	use SoftDeletes;

    public $table = 'svc_vendors';

    protected $fillable = [
        'name',
        'arabic_name',
        'phone',
        'email',
        'location',
        'status',
        'is_featured',
        'image',
        'website',
        'description',
        'arabic_description'

    ];
    
}
