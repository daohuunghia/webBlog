<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Models\Permission;
use App\Http\Requests\AdminRoleRequest;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
                'message' => trans('backend.Thêm thành công')
            ]);
            return redirect()->route('admin.role.index');
        } catch (\Exception $e) {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thêm thất bại')
            ]);
            DB::rollback();
            return redirect()->back();
        }
    }

    public function getUpdate(Request $request, $id)
    {
        $permissions = Permission::get()->chunk(4);
        $role = Role::find($id);
        $permissionsOfRole = $role->permissions->pluck('id');
        if ($role) {
            $data = [
                'permissions' => $permissions,
                'role' => $role,
                'permissionsOfRole' => $permissionsOfRole
            ];
            return view ('backend.role.update', $data);
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thông tin không tồn tại')
            ]);
        }

    }

    public function postUpdate (AdminRoleRequest $request, $id)
    {
        //dd($request->permissions_id);
        try {
            DB::beginTransaction();
            $role = Role::find($id);
            $role->code = Str::slug($request->en_name);
            $role->translateOrNew('vi')->name = $request->vi_name;
            $role->translateOrNew('en')->name = $request->en_name;
            if ($role->save()) {
                DB::table('permission_role')->where('role_id', $role->id)->delete();
                $role->permissions()->attach($request->permissions_id);
                DB::commit();
                $request->session()->flash('toastr', [
                    'type' => 'success',
                    'message' => trans('backend.Cập nhập thành công')
                ]);
                return redirect()->route('admin.role.index');
            }
        } catch (\Exception $e) {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Cập nhập thất bại')
            ]);
            DB::rollback();
            return redirect()->back();
        }

    }

    public function getAction (Request $request, $action = 'delete', $id)
    {
        $role = Role::find($id);
        if ($role) {
            DB::beginTransaction();
            try {
                DB::table('permission_role')->where('role_id', $role->id)->delete();
                $role->deleteTranslations();
                $role->delete();
                DB::commit();
                $request->session()->flash('toastr', [
                    'type' => 'success',
                    'message' => trans('backend.Xóa thành công')
                ]);
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thông tin không tồn tại')
            ]);
        }
        return redirect()->back();
    }

    function ajaxGetPermissions(Request $request)
    {
        $permissions = Permission::get()->chunk(4);
        if ($request->id) {
            $role = Role::find($request->id);
            if ($role) {
                $permissionsOfRole = $role->permissions->pluck('id');
                $data = [
                    'permissionsOfRole' => $permissionsOfRole,
                    'permissions' => $permissions
                ];
            }
            $html = view ('backend.user._permissions_view_ajax', $data)->render();
            return response()->json([
                'html' => $html
            ]);
        }
    }

    function ajaxGetPermissionsDefault ()
    {
        $permissions = Permission::get()->chunk(4);
        $data = [
            'permissions' => $permissions
        ];
        $html = view ('backend.user._permissions_view_ajax_default', $data)->render();
        return response()->json([
            'html' => $html
        ]);
    }
}
