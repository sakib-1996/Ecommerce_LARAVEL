<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableCountry;
use App\Models\AvailableDistrict;
use Illuminate\Support\Facades\Validator;

class AvailableDistrictController extends Controller
{
    public function index($country)
    {
        // Fetch the available districts for the provided country ID
        $districts = AvailableDistrict::where('country_id', $country)->get();
        $exist_country = AvailableCountry::find($country);

        return view('admin.pages.country.district.index', compact('districts', 'exist_country'));
    }

    // store methode
    public function addistrict(Request $request)
    {
        // dd($request->all());
        $rules = [
            'district_name' => 'required|max:255',
            'base_cost' => 'required|max:255',
            'cost_by_condition' => 'required|max:255',
        ];

        $validatorMessages = [
            'district_name.required' => 'The District Name is required.',
            'base_cost.required' => 'The Base Cost is required.',
            'cost_by_condition.required' => 'The Cost By Height & Width is required.',

            'district_name.max' => 'The District Name must not exceed 255 characters.',
            'base_cost.max' => 'The Base Cost must not exceed 255 characters.',
            'cost_by_condition.max' => 'The Cost By Height & Width must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessages);

        if ($validator->fails()) {
            $errorMessage = implode(' ', $validator->errors()->all());
            $notification = ['message' => $errorMessage, 'alert-type' => 'error'];
            return redirect()->back()->with($notification)->withInput();
        }

        // dd($request->all());

        AvailableDistrict::create([
            'district_name' => $request->district_name,
            'base_cost' => $request->base_cost,
            'cost_by_condition' => $request->cost_by_condition,
            'country_id' => $request->country_id,
        ]);
        $notification = array('message' => 'District Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //edit method
    public function editdistrict($id)
    {
        $data = AvailableDistrict::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }


    public function districtUpdate(Request $request)
    {
        // dd("hello");
        $rules = [
            'e_district_name' => 'required|max:255',
            'e_base_cost' => 'required|max:255',
            'e_cost_by_condition' => 'required|max:255',
        ];

        $validatorMessages = [
            'e_district_name.required' => 'The District Name is required.',
            'e_base_cost.required' => 'The Base Cost is required.',
            'e_cost_by_condition.required' => 'The Cost By Height & Width is required.',

            'e_district_name.max' => 'The District Name must not exceed 255 characters.',
            'e_base_cost.max' => 'The Base Cost must not exceed 255 characters.',
            'e_cost_by_condition.max' => 'The Cost By Height & Width must not exceed 255 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessages);

        if ($validator->fails()) {
            $errorMessage = implode(' ', $validator->errors()->all());
            $notification = ['message' => $errorMessage, 'alert-type' => 'error'];
            return redirect()->back()->with($notification)->withInput();
        }


        // dd($request->all());
        $districtId = $request->input('id');

        $district = AvailableDistrict::findorfail($districtId);
        // dd($districtId);

        $district->update([
            'district_name' => $request->e_district_name,
            'base_cost' => $request->e_base_cost,
            'cost_by_condition' => $request->e_cost_by_condition,
        ]);
        $notification = array('message' => 'Country Updated Successfull!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //delete method
    public function destroyDistrict($id)
    {
        // dd($id);

        $district = AvailableDistrict::find($id);
        $district->delete();

        $notification = array('message' => 'District Deleted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
