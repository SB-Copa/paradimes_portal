<?php

namespace App\Http\Controllers\Venue;

use App\Http\Controllers\Controller;
use App\Models\Venues\VenuesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          
          DB::beginTransaction();

                try {

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|unique:venues,name',
                    'address' => 'nullable|string',
                    'region_id' => 'required|string|exists:refregion,regCode',
                    'province_id' => 'required|string|exists:refprovince,provCode',
                    'municipality_id' => 'required|string|exists:refcitymun,citymunCode',
                    'barangay_id' => 'required|string|exists:refbrgy,brgyCode',
                    'contact_number' => 'required|string|max:20',
                    'email' => 'nullable|email|max:255',
                    'websites' => 'nullable|array',
                    'websites.*' => 'url',
                    'capacity' => 'required|integer|min:0',
                    'user_count' => 'required|integer|min:0',
                    'table_count' => 'required|integer|min:0',
                    'menu_images' => 'nullable|array',
                    'menu_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    'banner_images' => 'nullable|array',
                    'banner_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    'carousel_images' => 'nullable|array',
                    'carousel_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                    'menu' => 'nullable|string',
                    'about' => 'nullable|string',
                    'venue_status_id' => 'required|integer|exists:venue_statuses,id',
                ]);



                if ($validator->fails()) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }


                $data = $validator->validated();
                $venue = VenuesModel::create($data);

                
         
            if($request->hasFile('banner_images')){

                foreach ($request->file('banner_images') as $image) {
                    $img = Image::read($image)
                                ->resize(1200, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })
                                ->encode(); // re-encode to clean file

                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('private')->put('venue_banners/' . $filename, $img);
                }

            }

            if($request->hasFile('carousel_images')){
                foreach ($request->file('carousel_images') as $image) {
                    $img = Image::read($image)
                                ->resize(1200, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })
                                ->encode(); // re-encode to clean file

                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('private')->put('venue_carousel_images/' . $filename, $img);
                }
            }

            
            if($request->hasFile('menu_images')){
                foreach ($request->file('menu_images') as $image) {
                    $img = Image::read($image)
                                ->resize(1200, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })
                                ->encode(); // re-encode to clean file

                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('private')->put('venue_menu_images/' . $filename, $img);
                }
            }

                DB::commit();

                return response()->json($venue, 201);
        } catch (Exception $e) {
            // Rollback on error
            DB::rollBack();
            // Handle the exception
            throw $e;
        }

        DB::commit();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
