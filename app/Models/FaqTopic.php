<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqTopic extends Model
{
    use HasFactory;
	// use SoftDeletingTrait;
	use SoftDeletes;

    public $table = 'faq_topics';
}
