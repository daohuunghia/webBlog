<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'categories';
    const STATUS_ACTIVE = 1; // hoạt động
    const STATUS_LOCK = 0; // khóa

    const HOT = 1; 
    const NORMAL = 0;

    public $translatedAttributes = ['title', 'slug', 'keyword', 'description'];
    protected $fillable = ['avatar', 'parent_id', 'status', 'hot'];

    public $translationModel = 'App\Models\CategoryTranslations';

    public function category_translations () {
        return $this->hasMany('App\Models\CategoryTranslations');
    }
}
