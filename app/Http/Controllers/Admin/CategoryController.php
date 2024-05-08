<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('admin.pages.category.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);

        // dd($request->all());
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->category_slug = Str::slug($request->category_name, '-');
        $category->front_page = $request->front_page;

        // Working with image
        $photo = $request->file('cat_img');
        $photoname = uniqid() . '.' . $photo->getClientOriginalExtension();

        $directory = 'public/files/cat_img/';

        $image = Image::make($photo)->fit(240, 150)->encode();

        Storage::put($directory . $photoname, $image);

        $category->cat_img = 'files/cat_img/' . $photoname;

        $category->save();



        $notification = array('message' => 'Category Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //edit method
    public function editCategory($id)
    {
        $data = Category::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }
    public function updateCategory(Request $request)
    {

        // dd($request->all());
        $data = [
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name, '-'),
            'front_page' => $request->e_front_page,
        ];

        if ($request->hasFile('e_cat_img')) {
            // dd($request->all());
            // Check if old logo exists and delete it
            $imagePath = public_path('storage/' . $request->old_cat_img);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            // dd($request->all());
            // Working with image
            $photo = $request->file('e_cat_img');
            $photoname = uniqid() . '.' . $photo->getClientOriginalExtension();

            $directory = 'public/files/cat_img/';

            $image = Image::make($photo)->fit(240, 150)->encode();

            Storage::put($directory . $photoname, $image);
            // dd($request->all());
            // Update brand information with the new logo
            $data['cat_img'] = 'files/cat_img/' . $photoname;
        } else {
            $data['cat_img'] = $request->old_cat_img;
        }



        Category::where('id', $request->id)->update($data);

        $notification = ['message' => 'Category Update!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    //delete method
    public function destroyCategory($id)
    {
        // dd($id);

        $category = Category::findOrFail($id);
        $imagePath = public_path('storage/' . $category->cat_img);
        // dd($imagePath);
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }
        $category->delete();
        $notification = ['message' => 'category Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
