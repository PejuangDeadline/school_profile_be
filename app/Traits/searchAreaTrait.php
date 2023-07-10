<?php

namespace App\Traits;

use App\Models\Rule;
use Illuminate\Support\Facades\Http;

trait searchAreaTrait
{
    public function provinceName($token,$province_id)
    {
       //get Province name
       $ruleApiSearchProvince=Rule::where('rule_name','API Search Province by ID')->first();
       $url_ApiSearchProvince=$ruleApiSearchProvince->rule_value;

       $getSearchProvince=Http::withToken($token)
       ->post($url_ApiSearchProvince,[
           'province_id' => $province_id
       ]);

       $data=$getSearchProvince['data'][0];
       //dd($data);
       return $data['nama'];
    }

    public function cityName($token,$city_id)
    {
       //get City name
       $ruleApiSearchCity=Rule::where('rule_name','API Search City by ID')->first();
       $url_ApiSearchCity=$ruleApiSearchCity->rule_value;

       $getSearchCity=Http::withToken($token)
       ->post($url_ApiSearchCity,[
           'city_id' => $city_id
       ]);

       $data=$getSearchCity['data'][0];

       return $data['nama'];
    }

    public function districtName($token,$district_id)
    {
       //get District name
       $ruleApiSearchDistrict=Rule::where('rule_name','API Search District by ID')->first();
       $url_ApiSearchDistrict=$ruleApiSearchDistrict->rule_value;

       $getSearchDistrict=Http::withToken($token)
       ->post($url_ApiSearchDistrict,[
           'district_id' => $district_id
       ]);

       $data=$getSearchDistrict['data'][0];

       return $data['nama'];
    }

    public function subdistrictName($token,$subdistrict_id)
    {
       //get Subdistrict name
       $ruleApiSearchSubdistrict=Rule::where('rule_name','API Search Sub District by ID')->first();
       $url_ApiSearchSubdistrict=$ruleApiSearchSubdistrict->rule_value;

       $getSearchSubdistrict=Http::withToken($token)
       ->post($url_ApiSearchSubdistrict,[
           'subdistrict_id' => $subdistrict_id
       ]);

       $data=$getSearchSubdistrict['data'][0];

       return $data['nama'];
    }
}
