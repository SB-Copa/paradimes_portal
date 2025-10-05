<?php

namespace App\Http\Controllers\PersonalDetails;

use App\Http\Controllers\Controller;
use App\Models\PersonalDetails\CityMunicipalitiesModel;
use App\Models\PersonalDetails\ProvincesModel;
use App\Models\PersonalDetails\RegionsModel;
use App\Models\PersonalDetails\SexModel;
use App\Models\PersonalDetails\SuffixModel;
use Illuminate\Http\Request;

class PersonalAttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $sex = SexModel::get();

        $suffix = SuffixModel::get();

        $address = RegionsModel::with('provinces.cityMunicipalities.barangays')->get();
  

        return response()->json(['sex' => $sex, 'suffix' => $suffix, 'address' => $address]);
    }

    public function regions(){

        $regions = RegionsModel::get();

        return response()->json($regions);
    }

    public function regionsProvinces(string $regCode){
             $regions_provinces = RegionsModel::with([
                'provinces'
             ])
             ->whereHas('provinces', function($query) use ($regCode){
                $query->where('regCode','=',$regCode);
             })
             ->get();

            return response()->json($regions_provinces);
    }

   public function regionsProvincesCitiesMunicipalities(string $regCode, string $provCode)
    {
        
        $regions_provinces_cities_municipalities = RegionsModel::with(['provinces' => function($query) use ($regCode, $provCode) {
            $query->where('regCode', $regCode)
                ->where('provCode', $provCode)
                ->with('citiesMunicipalities');
        }])
        ->whereHas('provinces', function($query) use ($regCode, $provCode) {
            $query->where('regCode', $regCode)
                ->where('provCode', $provCode);
        })
        ->get();

        return response()->json($regions_provinces_cities_municipalities);
    }


    public function regionsProvincesCitiesMunicipalitiesBarangays(string $regCode, string $provCode, string $cityMunCode){
         $regions_provinces_cities_municipalities_barangays = RegionsModel::with(['provinces' => function($query) use ($regCode, $provCode, $cityMunCode) {
                $query->where('regCode', $regCode)
                    ->where('provCode', $provCode)
                    ->with(['citiesMunicipalities' => function($query) use ($regCode, $provCode, $cityMunCode){
                        $query->where('regCode',$regCode)->where('provCode',$provCode)->where('citymunCode',$cityMunCode)
                        ->with('barangays');
                    }]);
            }])
            ->whereHas('provinces.citiesMunicipalities.barangays', function($query) use ($regCode, $provCode, $cityMunCode) {
                $query->where('regCode', $regCode)
                    ->where('provCode', $provCode)
                    ->where('citymunCode', $cityMunCode);
            })
            ->get();



            return response()->json($regions_provinces_cities_municipalities_barangays);
    }

    public function sex(){

        
        return response()->json(SexModel::get());
    }

    public function suffix(){

        return response()->json(SuffixModel::get());
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
