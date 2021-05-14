<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Translatable;

    protected $table = 'roles';
    public $timestamps = false;

    public $translatedAttributes = ['name'];
    protected $fillable = ['name'];

    public $translationModel = 'App\Models\RoleTranslations';

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }
}
