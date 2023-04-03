<?php

namespace Designbycode\Datatables\Tests\Stubs;

use Designbycode\Datatables\Tests\Stubs\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use HasFactory;

    protected $fillable = ['title', 'content'];

}
