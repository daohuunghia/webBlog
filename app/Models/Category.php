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
    const STATUS_LOCK = 2; // khóa

    public $translatedAttributes = ['title', 'keyword', 'description'];
    protected $fillable = ['slug', 'avatar', 'parent_id', 'status', 'hot'];

    public $translationModel = 'App\Models\CategoryTranslations';

    public function category_translations () {
        return $this->hasMany('App\Models\CategoryTranslations');
    }
}
