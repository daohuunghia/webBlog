<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminUserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function index ()
    {
        $users = User::paginate(10);
        $data = [
            'users' => $users
        ];
        return view('backend.user.index', $data);
    }

    public function getCreate ()
    {
        return view ('backend.user.create');
    }

    public function postCreate (AdminUserRequest $request)
    {
        $user = User::create($request->all());
        $user->password = Hash::make($request->password);
        $user->status = $request->status ? User::STATUS_ACTIVE : User::STATUS_LOCK ;
        $user->save();
        if ($user) {
            $request->session()->flash('toastr', [
                'type' => 'success',
                'message' => trans('backend.Thêm thành công')
            ]);
            return redirect()->route('admin.user.index');
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Thêm thất bại')
            ]);
            return redirect()->back();
        }
    }

    public function getUpdate (Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $data = [
                'user' => $user
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
        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'avatar' => 'required',
            'phone' => 'min:10|max:11|unique:users,phone,' . $id,
        ]);
        $user = User::findOrFail($id);
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
            $user->save();
            $request->session()->flash('toastr', [
                'type' => 'success',
                'message' => trans('backend.Cập nhập thành công')
            ]);
            return redirect()->route('admin.user.index');
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => trans('backend.Cập nhập thất bại')
            ]);
            return redirect()->back();
        }
    }

    public function getAction ($action, $id)
    {
        if ($action) {
            switch ($action) {
                case 'status':
                    $user = User::find($id);
                    $user->status = !$user->status;
                    $user->save();
                    break;
                case 'delete':
                    $user = User::find($id);
                    if ($user) {
                        $user->delete();
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
