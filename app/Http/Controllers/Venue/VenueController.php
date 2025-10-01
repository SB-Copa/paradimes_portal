<?php

namespace App\Http\Controllers\Venue;

use App\Http\Controllers\Controller;
use App\Models\Venues\VenuesModel;
use App\Models\Venues\VenueTableRequirementsModel;
use App\Models\Venues\VenueTablesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

                $venue_validator = Validator::make($request->venue, [
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
                    'capacity' => 'required|integer|min:1',
                    'user_count' => 'required|integer|min:0',
                    'table_count' => 'required|integer|min:1',
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



                if ($venue_validator->fails()) {
                    DB::rollBack();
                    return response()->json([
                        'errors' => $venue_validator->errors()
                    ], 422);
                }


            $venue_data = $venue_validator->validated();
            $venue = VenuesModel::create($venue_data);

                
         
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

            /**
             * 
             * Add table
             * 
             * 
             */
   
            $table_validator = Validator::make($request->venue,[
                    'venue_tables' => 'array',
                    // 'venue_tables.*.venue_id' => 'required|exists:venues,id',
                    'venue_tables.*.venue_table_status_id' => 'required|exists:venue_table_statuses,id',
                    'venue_tables.*.capacity' => 'required|integer|min:1',
                    'venue_tables.*.name' => 'required|string',
                    'venue_tables.*.venue_table_requirements' => 'nullable|array',
                    'venue_tables.*.venue_table_requirements.*.name' => 'required|string',
                    'venue_tables.*.venue_table_requirements.*.description' => 'nullable|string',
                    'venue_tables.*.venue_table_requirements.*.venue_table_requirement_type_id' => 'required|exists:venue_table_requirement_types,id',
                    'venue_tables.*.venue_table_requirements.*.quantity' => 'required|integer|min:1',
                    'venue_tables.*.venue_table_requirements.*.price' => 'required|decimal',
            ]);

      
            
            if($table_validator->fails()){
                DB::rollBack();
                return response()->json([
                    'errors' => $table_validator->errors()
                ], 422);
            }
          
            

            if($request->venue['table_count'] != count($request->venue['venue_tables'])){
               return response()->json('Table count and venue tables mismatch.',400);
            }
            
            
            foreach($request->venue['venue_tables'] as $key1 => $value1){
                
                $venueTables = VenueTablesModel::firstOrCreate([
                    'venue_id' => $venue->id,
                    'capacity' => $value1['capacity'],
                    'venue_table_status_id' => $value1['venue_table_status_id'],
                    'user_type' => get_class(Auth::user()),
                    'user_id' => Auth::user()->id,
                    'name' => $value1['name'],
                ]);
                

                /*
                 * 
                 * When venue owner can create table requirements 
                 * will focus on events can add table requirements
                 * 
                 */


                // if(!empty($value1['venue_table_requirements'])){
                //     foreach($value1['venue_table_requirements'] as $key2 => $value2){
        
                //         VenueTableRequirementsModel::firstOrCreate([
                //             'name' => $value2['name'],
                //             'description' => $value2['description'],
                //             'venue_table_id' => $venueTables->id,
                //             'venue_table_requirement_type_id' => $value2['venue_table_requirement_type_id'],
                //             'quantity' => $value2['quantity'],
                //             'price' => $value2['price']
                //         ]);
                //     }
                // }
            }

            DB::commit();

            return response()->json('successful', 201);
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
