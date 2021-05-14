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
    protected $fillable = ['avatar', 'parent_id', 'status', 'hot', 'user_id'];

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

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getStatus () {
       return array_get($this->statusList, $this->status);
    }

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    public static function _sort($models, $parent_id = 0, &$index = 0)
    {
        foreach ($models as $model) {
            if ($model->parent_id == $parent_id) {
                $index++;
                $model->_lft = $index;
                if (!Category::_sort($models, $model->id, $index)) {
                    return false;
                }
                $index++;
                $model->_rgt = $index;
                if (!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }
}
