<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('front_page', function ($row) {
                    if ($row->front_page == 1) {
                        return '<span class="badge badge-success">Home Page</span>';
                    }
                })
                // ' . route('brand.delete', [$row->id]) . '
                ->addColumn('action', function ($row) {
                    $actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="' . $row->id . '" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                              <a href="' . route('admin.destroyBrand', [$row->id]) . '" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                              </a>';
                    return $actionbtn;
                })
                ->rawColumns(['action', 'front_page'])
                ->make(true);
        }

        return view('admin.pages.brand.index');
    }

    public function storeBrand(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|max:55',
            'brand_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $slug = Str::slug($request->brand_name, '-');

        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->brand_slug = Str::slug($request->brand_name, '-');
        $brand->front_page = $request->front_page;

        // Working with image
        $photo = $request->file('brand_logo');
        $photoname = uniqid() . '.' . $photo->getClientOriginalExtension();

        $directory = 'public/files/brand/';

        $image = Image::make($photo)->fit(240, 120)->encode();

        Storage::put($directory . $photoname, $image);

        $brand->brand_logo = 'files/brand/' . $photoname;

        $brand->save();

        $notification = ['message' => 'Brand Inserted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    public function editBrand($id)
    {
        $data = Brand::find($id);
        return view('admin.pages.category.edite', compact('data'));
    }


    public function brandUpdate(Request $request)
    {
        // dd($request->all());
        $slug = Str::slug($request->brand_name, '-');
        $data = [
            'brand_name' => $request->brand_name,
            'brand_slug' => Str::slug($request->brand_name, '-'),
            'front_page' => $request->front_page,
        ];

        if ($request->hasFile('brand_logo')) {
            // Check if old logo exists and delete it
            $imagePath = public_path('storage/' . $request->old_logo);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            // dd($request->all());
            // Working with image
            $photo = $request->file('brand_logo');
            $photoname = uniqid() . '.' . $photo->getClientOriginalExtension();

            $directory = 'public/files/brand/';

            $image = Image::make($photo)->fit(240, 120)->encode();

            Storage::put($directory . $photoname, $image);
            // dd($request->all());
            // Update brand information with the new logo
            $data['brand_logo'] = 'files/brand/' . $photoname;
        } else {
            $data['brand_logo'] = $request->old_logo;
        }

        // Update brand information
        Brand::where('id', $request->id)->update($data);

        $notification = ['message' => 'Brand Update!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }


    public function destroyBrand($id)
    {
        // dd($id);
        $brand = Brand::findOrFail($id);
        $imagePath = public_path('storage/' . $brand->brand_logo);

        if (File::exists($imagePath)) {
            unlink($imagePath);
        }
        $brand->delete();
        $notification = ['message' => 'Brand Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
