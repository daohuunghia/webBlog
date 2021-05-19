<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissions;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasPermissions;

    const STATUS_ACTIVE = 1; // hoạt động
    const STATUS_LOCK = 0; // khóa

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'status', 'avatar', 'job'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $statusList = [
        User::STATUS_ACTIVE => [
            'name' => 'backend.active',
            'class' => 'success'
        ],
        User::STATUS_LOCK => [
            'name' => 'backend.lock',
            'class' => 'danger'
        ]
    ];
    public function getStatus () {
        return array_get($this->statusList, $this->status);
    }

    public function roles () {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }
}
