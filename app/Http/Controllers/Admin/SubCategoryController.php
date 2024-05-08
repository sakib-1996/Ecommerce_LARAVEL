<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Category;
use App\Models\Discount;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        $categories = Category::all();
        return view('admin.pages.subCategory.index', compact('subCategories', 'categories'));
    }


    public function storeCategory(Request $request)
    {
        $rules = [
            'subcategory_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
        ];

        $messages = [
            'subcategory_name.required' => 'The subcategory name is required.',
            'subcategory_name.max' => 'The subcategory name must not exceed 255 characters.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }

        $slug = Str::slug($request->subcategory_name, '-');
        SubCategory::create([
            'subcategory_name' => $request->subcategory_name,
            'subcat_slug' => $slug,
            'category_id' => $request->category_id,
        ]);

        $notification = array('message' => 'Subcategory Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //edit method
    public function editSubCategory($id)
    {
        $data = SubCategory::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }

    //  uppdate Sub category
    public function updateSubCategory(Request $request)
    {

        // dd($request->all());
        $sub_categoryId = $request->input('id');

        $validated = $request->validate([
            'subcategory_name' => 'required|max:255|unique:sub_categories,subcategory_name,' . $sub_categoryId,
            'category_id' => 'required|exists:categories,id',
        ]);

        $sub_category = SubCategory::findorfail($sub_categoryId);
        // dd($sub_category);
        $slug = Str::slug($request->subcategory_name, '-');
        $sub_category->update([
            'subcategory_name' => $request->subcategory_name,
            'category_id' => $request->category_id,
            'subcat_slug' => $slug,
        ]);
        $notification = array('message' => 'Category Updated Successfull!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }


    //delete method
    public function destroySubCategory($id)
    {
        // dd($id);

        $sub_category = SubCategory::find($id);
        $sub_category->delete();

        $notification = array('message' => 'Sub Category Deleted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }


    public function hello()
    {
        $subCategories = SubCategory::with('category')->get();
        $categories = Category::all();
        return view('frontend.pages.contact-page', compact('subCategories', 'categories'));
    }
}
