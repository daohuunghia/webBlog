<?php

namespace App\Policies;

use App\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update (User $user, Category $category)
    {
        return ($user->id == $category->user_id)
            ? Response::allow()
            : Response::deny('Bạn không có quyền');
    }

}
