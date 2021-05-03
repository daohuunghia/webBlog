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
        $categories = Category::get();
        return view('backend.category.index', compact('categories'));
    }

    public function getCreate ()
    {
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->select('id', 'parent_id')
            ->get();
            //dd($categories->toArray());
        return view('backend.category.create', ['categories' => $categories]);
    }

    public function postCreate (AdminCategoryRequest $request)
    {
        $category = new Category();
        $category->slug = str_slug($request->title);
        $category->slug = $request->parent_id;
        $category->status = $request->status ? Category::STATUS_ACTIVE : Category::STATUS_LOCK;
        $category->hot = $request->hot ? Category::HOT : Category::NORMAL;
        $category->translateOrNew('en')->title = trim($request->input('en_title'));
        $category->translateOrNew('vi')->title = trim($request->input('vi_title'));
        $category->translateOrNew('en')->slug = str_slug($request->input('en_title'));
        $category->translateOrNew('vi')->slug = str_slug($request->input('vi_title'));
        $category->translateOrNew('en')->keyword = trim($request->input('en_keyword'));
        $category->translateOrNew('vi')->keyword = $request->input('vi_keyword');
        $category->translateOrNew('en')->description = $request->input('en_description');
        $category->translateOrNew('vi')->description = $request->input('vi_description');
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
