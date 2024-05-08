<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function sizeIndex()
    {
        $sizes = Size::get();
        return view('admin.pages.settings.size.index', compact('sizes'));
    }
    // store methode
    public function sizeStore(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
        ];
        $validatorMessege = [
            'title.required' => 'The size title is required.',
            'title.max' => 'The size title must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }
        // dd($request->all());

        Size::create(['title' => $request->title]);
        $notification = array('message' => 'Size Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
    //edit method
    public function editSize($id)
    {
        $data = Size::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }
    public function sizeUpdate(Request $request)
    {
        // dd($request->all());
        $sizeId = $request->input('id');

        $rules = [
            'title' => 'required|max:255',
        ];
        $validatorMessege = [
            'title.required' => 'The size title is required.',
            'title.max' => 'The size title must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }


        $size = Size::findorfail($sizeId);

        $size->update([
            'title' => $request->title,
        ]);
        $notification = array('message' => 'Size Updated Successfull!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
    //delete method
    public function destroySize($id)
    {
        // dd($id);

        $size = Size::find($id);
        $size->delete();

        $notification = array('message' => 'Size Deleted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }





    
    // ===== COLOR =====
    public function colorIndex()
    {
        $colors = Color::get();
        return view('admin.pages.settings.color.index', compact('colors'));
    }

    // store methode
    public function colorStore(Request $request)
    {
        // dd($request->all());
        $rules = [
            'colors' => 'required|max:255',
        ];
        $validatorMessege = [
            'colors.required' => 'The size colors is required.',
            'colors.max' => 'The size colors must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }
        // dd($request->all());

        Color::create(['color' => $request->colors, 'color_code' => $request->color_code]);
        $notification = array('message' => 'Color Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
    //edit method
    public function editColor($id)
    {
        $data = Color::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }
    public function colorUpdate(Request $request)
    {
        // dd($request->all());
        $colorId = $request->input('id');

        $rules = [
            'color' => 'required|max:255',
        ];
        $validatorMessege = [
            'color.required' => 'The color title is required.',
            'color.max' => 'The color title must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }


        $color = Color::findorfail($colorId);

        $color->update([
            'color' => $request->color,
            'color_code' => $request->color_code,
        ]);
        $notification = array('message' => 'Color Updated Successfull!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
    //delete method
    public function destroyColor($id)
    {
        // dd($id);
        $color = Color::find($id);
        $color->delete();

        $notification = array('message' => 'Size Deleted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
