<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChildCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ChildCategory::with(['category', 'subcategory'])
                ->select('child_categories.*')
                ->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    return $row->category->category_name;
                })
                ->addColumn('subcategory_name', function ($row) {
                    return $row->subcategory->subcategory_name;
                })
                ->addColumn('action', function ($row) {
                    $actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="' . $row->id . '" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                              <a href="' . route('admin.deleteChildCategory', $row->id) . '"  class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i></a>';

                    return $actionbtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $categories = Category::all();
        return view('admin.pages.childcategory.index', compact('categories'));
    }

    public function storeChildCategory(Request $request)
    {
        $rules = [
            'childcategory_name' => 'required|max:255',
            'subcategory_id' => 'required',
            'category_id' => 'required',
        ];
        $validatorMessege = [
            'childcategory_name.required' => 'The child category name is required.',
            'childcategory_name.max' => 'The child category name must not exceed 255 characters.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'category_id.required' => 'Please select a category.',
        ];
        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }

        $slug = Str::slug($request->childcategory_name, '-');
        ChildCategory::create([
            'childcategory_name' => $request->childcategory_name,
            'childcategory_slug' => $slug,
            'subcategory_id' => $request->subcategory_id,
            'category_id' => $request->category_id,
        ]);
        $notification = array('message' => 'Subcategory Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function sabCategoryByCategoyId($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json(['data' => $subCategories]);
    }

    public function chlidCategoryBySabCategoyId($id)
    {
        $childCategories = ChildCategory::where('subcategory_id', $id)->get();
        return response()->json(['childCat' => $childCategories]);
    }


    //  uppdate Sub category
    public function ChildcategoryUpdate(Request $request)
    {
        // dd($request->all());
        $child_categoryId = $request->input('id');

        $validated = $request->validate([
            'childcategory_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required',
        ]);

        $child_category = ChildCategory::findOrFail($child_categoryId);
        // dd($child_category);
        $slug = Str::slug($request->childcategory_name, '-');
        $child_category->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'childcategory_name' => $request->childcategory_name,
            'childcategory_slug' => $slug,
        ]);

        $notification = array('message' => 'Category Updated Successfully!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }


    //edit method
    public function editChildCategory($id)
    {
        $data = ChildCategory::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }
}
