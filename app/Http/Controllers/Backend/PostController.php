<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends BaseController
{
    public function __contruct()
    {
        $this->middleware('can:view,post')->only('show');
    }

    public function show () {
        dd('Có quyền truy nhập');
    }

    public function index () {
        dd(1);
    }
}
