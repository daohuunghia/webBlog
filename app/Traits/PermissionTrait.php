<?php
namespace App\Traits;

trait PermissionTrait
{
    protected $permissions = null;

    private function roles() {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }
    public function checkHasPermission($permission = null)
    {
        if (is_string($permission)) {
            return $this->getPermissionsColection()->contains('code', $permission);
        }
        return false;
    }

    private function getPermissionsColection ()
    {
        $role = $this->roles->first();
        if ($role) {
            if (! $role->relationLoaded('permissions')) {
                $this->roles->load('permissions');
            }
            $this->permissions = $this->roles->pluck('permissions')->flatten();
        }
        return $this->permissions ?? collect();
    }
}
