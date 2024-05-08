<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableCountry;
use Illuminate\Support\Facades\Validator;

class AvailableCountryController extends Controller
{
    public function index()
    {
        $countries = AvailableCountry::get();
        return view('admin.pages.country.index', compact('countries'));
    }

    // store methode
    public function addCountry(Request $request)
    {
        // dd("hello");
        $rules = [
            'country' => 'required|max:255',
        ];
        $validatorMessege = [
            'country.required' => 'The Country title is required.',
            'country.max' => 'The Country title must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }
        // dd($request->all());

        AvailableCountry::create(['country_name' => $request->country]);
        $notification = array('message' => 'Country Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //edit method
    public function editCountry($id)
    {
        $data = AvailableCountry::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }

    public function countryUpdate(Request $request)
    {
        // dd("hello");
        $rules = [
            'e_country' => 'required|max:255',
        ];
        $validatorMessege = [
            'e_country.required' => 'The Country title is required.',
            'e_country.max' => 'The Country title must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessege);
        if ($validator->fails()) {
            $errorMessage = implode('<br>', $validator->errors()->all());
            $notification = array('message' => $errorMessage, 'alert-type' => 'error');
            return redirect()->back()->with($notification)->withInput();
        }


        // dd($request->all());
        $countryId = $request->input('id');

        $size = AvailableCountry::findorfail($countryId);

        $size->update([
            'country_name' => $request->e_country,
        ]);
        $notification = array('message' => 'Country Updated Successfull!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //delete method
    public function destroyCountry($id)
    {
        // dd($id);

        $country = AvailableCountry::find($id);
        $country->delete();

        $notification = array('message' => 'Country Deleted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
