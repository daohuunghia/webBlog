<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    use NodeTrait;

    protected $table = 'categories';
    const STATUS_ACTIVE = 1; // hoạt động
    const STATUS_LOCK = 0; // khóa

    const HOT = 1;
    const NORMAL = 0;

    public $translatedAttributes = ['title', 'slug', 'keyword', 'description'];
    protected $fillable = ['avatar', 'parent_id', 'status', 'hot'];

    public $translationModel = 'App\Models\CategoryTranslations';

    protected $statusList = [
        Category::STATUS_ACTIVE => [
            'name' => 'backend.active',
            'class' => 'success'
        ],
        Category::STATUS_LOCK => [
            'name' => 'backend.lock',
            'class' => 'danger'
        ]
    ];
    public function category_translations () {
        return $this->hasMany('App\Models\CategoryTranslations');
    }
    public function getStatus () {
       return array_get($this->statusList, $this->status);
    }
    public function getLftName()
    {
        return '_lft';
    }

    public function getRgtName()
    {
        return '_rgt';
    }

    public function getParentIdName()
    {
        return 'parent_id';
    }

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }
}
