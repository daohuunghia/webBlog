<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminUserRequest;
use App\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function index ()
    {
        $this->authorize('viewAny', User::class);
        $users = User::paginate(10);
        $data = [
            'users' => $users
        ];
        return view('backend.user.index', $data);
    }

    public function getCreate (Request $request)
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        $data = [
            'roles' => $roles
        ];
        return view ('backend.user.create', $data);
    }

    public function postCreate (AdminUserRequest $request)
    {
        $this->authorize('create', User::class);
        try {
            DB::beginTransaction();
            $user = User::create($request->all());
            $user->password = Hash::make($request->password);
            $user->status = $request->status ? User::STATUS_ACTIVE : User::STATUS_LOCK ;
            if ($user->save()) {
                $user->roles()->attach($request->role_id);
                $request->session()->flash('toastr', [
                    'type' => 'success',
                    'message' => trans('backend.Thêm thành công')
                ]);
                DB::commit();
                return redirect()->route('admin.user.index');
            }
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thêm thất bại')
            ]);
            return redirect()->back();

        }

    }

    public function getUpdate (Request $request, $id)
    {
//        $this->authorize('update', User::class);
        $user = User::find($id);
        $this->authorize('update', $user);
        $roles = Role::all();
        $roleOfUser = $user->roles->pluck('id');
        if ($user) {
            $data = [
                'user' => $user,
                'roles' => $roles,
                'roleOfUser' => $roleOfUser
            ];
            return view ('backend.user.update', $data);
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thông tin user không tồn tại')
            ]);
            return redirect()->route('admin.user.index');
        }

    }

    public function postUpdate (Request $request, $id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);
        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'avatar' => 'required',
            'phone' => 'min:10|max:11|unique:users,phone,' . $id,
            'role_id' => 'required'
        ]);
        try {
            DB::beginTransaction();
            if ($user) {
                $user->name = $request->name;
                $user->avatar = $request->avatar;
                $user->status = $request->status ? User::STATUS_ACTIVE : User::STATUS_LOCK;
                $user->phone = $request->phone;
                $user->job = $request->job;
                if ($request->check_change_password) {
                    $request->validate([
                        'password' => 'required|min:6|max:20',
                        're_password' => 'required|same:password',
                    ]);
                    $user->password = Hash::make($request->password);
                }
                if ($user->save()) {
                    DB::table('role_user')->where('user_id', $user->id)->delete();
                    $user->roles()->attach($request->role_id);
                    DB::commit();
                    $request->session()->flash('toastr', [
                        'type' => 'success',
                        'message' => trans('backend.Cập nhập thành công')
                    ]);
                    return redirect()->route('admin.user.index');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Cập nhập thất bại')
            ]);
            return redirect()->back();
        }

    }

    public function getAction ($action, $id)
    {
        $user = User::find($id);
        $this->authorize('delete', $user);
        if ($action) {
            switch ($action) {
                case 'status':
                    $user->status = !$user->status;
                    $user->save();
                    break;
                case 'delete':
                    try {
                        DB::beginTransaction();
                        if ($user) {
                            $user->delete();
                            DB::table('role_user')->where('user_id', $user->id)->delete();
                            DB::commit();
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                    }
                    break;
            }
        }
        return redirect()->back();
    }

    public function getLogin ()
    {
        return view ('backend.user.login');
    }
    public function postLogin (Request $request)
    {
        $user = User::where('email', $request->email)->where('status', User::STATUS_ACTIVE)->first();
        if ($user) {
            $data = $request->only('email', 'password');
            if (Auth::attempt($data)) {
                $request->session()->flash('toastr',  [
                    'type' => 'success',
                    'message' => trans('backend.Đăng nhập thành công')
                ]);
                return redirect()->route('admin.dashboard');
            } else {
                $request->session()->flash('toastr',  [
                    'type' => 'error',
                    'message' => trans('backend.Đăng nhập thất bại')
                ]);
                return redirect()->back()->with('error', 'Login information is not correct')->withInput();
            }
        } else {
            return redirect()->back()->with('error', 'Tài khoản của bạn đang bị khóa')->withInput();
        }
    }

    public function getLogout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->flash('toastr',  [
                'type' => 'info',
                'message' => trans('backend.Đăng xuất thành công')
            ]);
        }
        return redirect()->route('admin.user.login');
    }

    public function view(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return view('backend.user.view', compact('user'));
    }
}
