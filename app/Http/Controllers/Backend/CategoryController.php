<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\AdminCategoryRequest;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function index ()
    {
        $categories = Category::paginate(10);
        $data = [
            'categories' => $categories
        ];
        return view('backend.category.index', $data);
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
        $category->avatar = $request->avatar;
        $category->parent_id = $request->parent_id ?? 0;
        $category->slug = str_slug($request->title);
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
        $categories = Category::all();
        $this->_sort($categories);
        $category->save();
        return redirect()->route('admin.category.index');
    }

    protected function _sort($models, $parent_id = 0, &$index = 0)
    {
        foreach ($models as $model) {
            if ($model->parent_id == $parent_id) {
                $index++;
                $model->_lft = $index;
                if (!$this->_sort($models, $model->id, $index)) {
                    return false;
                }
                $index++;
                $model->_rgt = $index;
                if (!$model->save()) {
                    return false;
                }
            }
        }
        return true;
    }
    public function getUpdate (Request $request, $id)
    {
        $category = Category::find($id);
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->select('id', 'parent_id')
            ->get();
        $data = [
            'categories' => $categories,
            'category' => $category
        ];
        return view('backend.category.update', $data);
    }

    public function postUpdate (AdminCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->avatar = $request->avatar;
            $category->parent_id = $request->parent_id ?? 0;
            $category->slug = str_slug($request->title);
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
            $categories = Category::all();
            $this->_sort($categories);
        }
        return redirect()->route('admin.category.index');
    }

    public function active (Request $request, $id)
    {
    }

    public function getAction (Request $request, $action, $id)
    {
        $category = Category::find($id);
        if ($category) {
            switch ($action) {
                case 'status':
                    $category->status = !$category->status;
                    $category->save();
                    break;
                case 'delete':
                    $category->delete();
                    $category->deleteTranslations();
                    break;
            }
        }
        return redirect()->back();
    }
}
