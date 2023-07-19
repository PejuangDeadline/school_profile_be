<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AjaxAreaController extends Controller
{
    public function searchCity($province_id)
    {
        //API Regional
        $ruleAuthRegional=Rule::where('rule_name','API Auth Regional')->first();
        $url_AuthRegional=$ruleAuthRegional->rule_value;
        
        $ruleEmailRegional=Rule::where('rule_name','Email Auth Regional')->first();
        $emailRegional=$ruleEmailRegional->rule_value;

        $rulePasswordRegional=Rule::where('rule_name','Password Auth Regional')->first();
        $passwordRegional=$rulePasswordRegional->rule_value;
        
        $response = Http::post($url_AuthRegional, [
            'email' => $emailRegional,
            'password' => $passwordRegional,
        ]);

        $data=$response['data'];
        $token=$data['token'];

        //get list city
        $ruleApiCity=Rule::where('rule_name','API List City')->first();
        $url_ApiCity=$ruleApiCity->rule_value;

        $getCity=Http::withToken($token)
        ->post($url_ApiCity,[
            'province_id' => $province_id
        ]);
        $cities=$getCity['data'];
        //End API Regional

        return json_encode($cities);
    }

    public function searchDistrict($city_id)
    {
        //API Regional
        $ruleAuthRegional=Rule::where('rule_name','API Auth Regional')->first();
        $url_AuthRegional=$ruleAuthRegional->rule_value;
        
        $ruleEmailRegional=Rule::where('rule_name','Email Auth Regional')->first();
        $emailRegional=$ruleEmailRegional->rule_value;

        $rulePasswordRegional=Rule::where('rule_name','Password Auth Regional')->first();
        $passwordRegional=$rulePasswordRegional->rule_value;
        
        $response = Http::post($url_AuthRegional, [
            'email' => $emailRegional,
            'password' => $passwordRegional,
        ]);

        $data=$response['data'];
        $token=$data['token'];

        //get list district
        $ruleApiDistrict=Rule::where('rule_name','API List District')->first();
        $url_ApiDistrict=$ruleApiDistrict->rule_value;

        $getDistrict=Http::withToken($token)
        ->post($url_ApiDistrict,[
            'city_id' => $city_id
        ]);
        $districts=$getDistrict['data'];
        //End API Regional

        return json_encode($districts);
    }

    public function searchSubDistrict($district_id)
    {
        //API Regional
        $ruleAuthRegional=Rule::where('rule_name','API Auth Regional')->first();
        $url_AuthRegional=$ruleAuthRegional->rule_value;
        
        $ruleEmailRegional=Rule::where('rule_name','Email Auth Regional')->first();
        $emailRegional=$ruleEmailRegional->rule_value;

        $rulePasswordRegional=Rule::where('rule_name','Password Auth Regional')->first();
        $passwordRegional=$rulePasswordRegional->rule_value;
        
        $response = Http::post($url_AuthRegional, [
            'email' => $emailRegional,
            'password' => $passwordRegional,
        ]);

        $data=$response['data'];
        $token=$data['token'];

        //get list Sub district
        $ruleApiSubDistrict=Rule::where('rule_name','API List Sub District')->first();
        $url_ApiSubDistrict=$ruleApiSubDistrict->rule_value;

        $getSubDistrict=Http::withToken($token)
        ->post($url_ApiSubDistrict,[
            'district_id' => $district_id
        ]);
        $subdistricts=$getSubDistrict['data'];
        //End API Regional

        return json_encode($subdistricts);
    }

    public function searchZipcode($subdistrict_id)
    {
        //API Regional
        $ruleAuthRegional=Rule::where('rule_name','API Auth Regional')->first();
        $url_AuthRegional=$ruleAuthRegional->rule_value;
        
        $ruleEmailRegional=Rule::where('rule_name','Email Auth Regional')->first();
        $emailRegional=$ruleEmailRegional->rule_value;

        $rulePasswordRegional=Rule::where('rule_name','Password Auth Regional')->first();
        $passwordRegional=$rulePasswordRegional->rule_value;
        
        $response = Http::post($url_AuthRegional, [
            'email' => $emailRegional,
            'password' => $passwordRegional,
        ]);

        $data=$response['data'];
        $token=$data['token'];

        //get Sub district
        $ruleApiSearchSubDistrict=Rule::where('rule_name','API Search Sub District by ID')->first();
        $url_ApiSearchSubDistrict=$ruleApiSearchSubDistrict->rule_value;

        $getSearchSubDistrict=Http::withToken($token)
        ->post($url_ApiSearchSubDistrict,[
            'subdistrict_id' => $subdistrict_id
        ]);
        $searchSubdistricts=$getSearchSubDistrict['data'];
        //End API Regional

        return json_encode($searchSubdistricts);
    }
}
