<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminCategoryRequest;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index ()
    {
        return view('backend.category.index');
    }

    public function getCreate ()
    {
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->select('id', 'parent_id')
            ->get();
        return view('backend.category.create', ['categories' => $categories]);
    }

    public function postCreate (AdminCategoryRequest $request)
    {
        $category = new Category();
        $category->slug = str_slug($request->title);
        $category->slug = $request->parent_id;
        $category->translateOrNew('en')->title = trim($request->input('en_title'));
        $category->translateOrNew('vi')->title = trim($request->input('vi_title'));
        $category->translateOrNew('en')->keyword = trim($request->input('en_keyword'));
        $category->translateOrNew('vi')->keyword = trim($request->input('vi_keyword'));
        $category->translateOrNew('en')->description = trim($request->input('en_description'));
        $category->translateOrNew('vi')->description = trim($request->input('vi_description'));
        $category->save();
        return redirect()->route('admin.category.index');
    }

    public function getUpdate (Request $request, $id)
    {
        return view('backend.category.update');
    }

    public function postUpdate (Request $request, $id)
    {
    }

    public function active (Request $request, $id)
    {
    }

    public function delete (Request $request, $id)
    {
    }
}
