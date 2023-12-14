<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

	// post model
	protected $fillable = [
		'title',
		'content',
		'published_at',
	];
}
