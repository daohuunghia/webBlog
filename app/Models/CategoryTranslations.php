<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslations extends Model
{
    protected $table = 'category_translations';
    protected $fillable = ['title', 'slug', 'keyword', 'description'];
    public $timestamps = false;
}
