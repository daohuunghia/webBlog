<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\AdminCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends BaseController
{
    public function index ()
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::get()->toFlatTree();
        $data = [
            'categories' => $categories
        ];
        return view('backend.category.index', $data);
    }

    public function getCreate ()
    {
        $this->authorize('create', Category::class);
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->get()
            ->toFlatTree();
        return view('backend.category.create', ['categories' => $categories]);
    }

    public function postCreate (AdminCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        $category = new Category();
        $category->avatar = $request->avatar;
        $category->parent_id = $request->parent_id ?? 0;
        $category->slug = str_slug($request->title);
        $category->status = $request->status ? Category::STATUS_ACTIVE : Category::STATUS_LOCK;
        $category->hot = $request->hot ? Category::HOT : Category::NORMAL;
        $category->user_id = Auth::user()->id;
        $category->translateOrNew('en')->title = trim($request->input('en_title'));
        $category->translateOrNew('vi')->title = trim($request->input('vi_title'));
        $category->translateOrNew('en')->slug = str_slug($request->input('en_title'));
        $category->translateOrNew('vi')->slug = str_slug($request->input('vi_title'));
        $category->translateOrNew('en')->keyword = trim($request->input('en_keyword'));
        $category->translateOrNew('vi')->keyword = $request->input('vi_keyword');
        $category->translateOrNew('en')->description = $request->input('en_description');
        $category->translateOrNew('vi')->description = $request->input('vi_description');
        if ($request->parent_id) {
            $parent = Category::where('id', $request->parent_id)->select('id', 'level')->first();
            $category->level = $parent->level + 1;
        } else {
            $category->level = 0;
        }
        $categories = Category::all();
        Category::_sort($categories);
        $category->save();
        return redirect()->route('admin.category.index');
    }

    public function getUpdate ($id)
    {
        $category = Category::find($id);
        $this->authorize('update', $category);
        $relationshipId = Category::where('status', Category::STATUS_ACTIVE)
            ->where('_lft', '>=', $category->_lft)
            ->where('_rgt', '<=', $category->_rgt)
            ->pluck('id');
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->whereNotIn('id', $relationshipId)
            ->get()
            ->toFlatTree();
        $data = [
            'categories' => $categories,
            'category' => $category
        ];
        return view('backend.category.update', $data);
    }

    public function postUpdate (AdminCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $this->authorize('update', $category);
        if ($category) {
            $category->avatar = $request->avatar;
            $category->parent_id = $request->parent_id ?? 0;
            $category->slug = str_slug($request->title);
            $category->status = $request->status ? Category::STATUS_ACTIVE : Category::STATUS_LOCK;
            $category->hot = $request->hot ? Category::HOT : Category::NORMAL;
            $category->user_id = Auth::user()->id;
            $category->translateOrNew('en')->title = trim($request->input('en_title'));
            $category->translateOrNew('vi')->title = trim($request->input('vi_title'));
            $category->translateOrNew('en')->slug = str_slug($request->input('en_title'));
            $category->translateOrNew('vi')->slug = str_slug($request->input('vi_title'));
            $category->translateOrNew('en')->keyword = trim($request->input('en_keyword'));
            $category->translateOrNew('vi')->keyword = $request->input('vi_keyword');
            $category->translateOrNew('en')->description = $request->input('en_description');
            $category->translateOrNew('vi')->description = $request->input('vi_description');
            if ($request->parent_id) {
                $parent = Category::where('id', $request->parent_id)->select('id', 'level')->first();
                $category->level = $parent->level + 1;
            } else {
                $category->level = 0;
            }
            $categories = Category::all();
            Category::_sort($categories);
            $category->save();
        }
        return redirect()->route('admin.category.index');
    }

    public function getAction ($action, $id)
    {
        $category = Category::find($id);
        $this->authorize('delete', $category);
        if ($action) {
            switch ($action) {
                case 'status':
                    $category->status = !$category->status;
                    $category->save();
                    break;
                case 'delete':
                    $categories = Category::descendantsAndSelf($id);
                    foreach ($categories as $item) {
                        $item->deleteTranslations();
                        $item->delete();
                    }
                    break;
            }
        }
        return redirect()->back();
    }
}
