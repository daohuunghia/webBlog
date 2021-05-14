<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Models\Permission;
use App\Http\Requests\AdminRoleRequest;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    public function index ()
    {
        $roles = Role::paginate(20);
        return view ('backend.role.index', compact('roles'));
    }
    public function getCreate ()
    {
        $permissions = Permission::get()->chunk(4);
        return view ('backend.role.create', compact('permissions'));
    }

    public function postCreate (AdminRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $role = new Role();
            $role->code = Str::slug($request->en_name);
            $role->translateOrNew('vi')->name = $request->vi_name;
            $role->translateOrNew('en')->name = $request->en_name;
            $role->save();
            $role->permissions()->attach($request->permissions_id);
            DB::commit();
            $request->session()->flash('toastr', [
                'type' => 'success',
                'message' => trans('backend.Thêm dữ liệu thành công')
            ]);
            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thêm dữ liệu thất bại')
            ]);
            DB::rollback();
            return redirect()->back();
        }
    }

    public function getUpdate(AdminRoleRequest $request, $id)
    {
        $permissions = Permission::get()->chunk(4);
        $role = Role::find($id);
        if ($role) {
            $data = [
                'permissions' => $permissions,
                'role' => $role
            ];
            return view ('backend.role.update', $data);
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thông tin không tồn tại')
            ]);
        }

    }

    public function postUpdate ()
    {

    }

    public function getAction ()
    {

    }
}
