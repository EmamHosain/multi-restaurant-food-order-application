<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::latest()->get();
        return view('admin.backend.city.all_city', compact('cities'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|unique:cities',
        ]);

        try {
            City::create([
                'city_name' => $request->input('city_name'),
                'city_slug' => Str::slug($request->input('city_name')),
            ]);
            $notification = [
                'alert-type' => 'success',
                'message' => 'City created successfully.'
            ];
            return redirect()->back()->with($notification);

        } catch (\Throwable $th) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Something went wrong.'
            ];
            return redirect()->back()->with($notification);

        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $city = City::find($id);
        return response()->json($city);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'city_name' => ['required', Rule::unique(City::class)->ignore($request->input('id'))],
        ]);

        try {
            $city = City::find($request->input('id'));

            $city->update([
                'city_name' => $request->input('city_name'),
                'city_slug' => Str::slug($request->input('city_name')),
            ]);

            $notification = [
                'alert-type' => 'success',
                'message' => 'City updated successfully.'
            ];
            return redirect()->back()->with($notification);
        } catch (\Throwable $th) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Something went wrong.'
            ];
            return redirect()->back()->with($notification);

        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {

        $city->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'City deleted successfully.'
        ];
        return redirect()->back()
            ->with($notification);
    }
}
