<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTranslations extends Model
{
    protected $table = 'role_translations';
    protected $fillable = ['name'];
    public $timestamps = false;
}
