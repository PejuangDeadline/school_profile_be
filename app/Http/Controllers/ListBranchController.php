<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use Illuminate\Support\Facades\Http;
use App\Models\Rule;

use Illuminate\Http\Request;

class ListBranchController extends Controller
{
    public function index($id){
        $id_branch = decrypt($id);

        $branch = Branch::where('id_institution',$id_branch)->get();
         //API Regional
         $ruleAuthRegional = Rule::where('rule_name', 'API Auth Regional')->first();
         $url_AuthRegional = $ruleAuthRegional->rule_value;
 
         $ruleEmailRegional = Rule::where('rule_name', 'Email Auth Regional')->first();
         $emailRegional = $ruleEmailRegional->rule_value;
 
         $rulePasswordRegional = Rule::where('rule_name', 'Password Auth Regional')->first();
         $passwordRegional = $rulePasswordRegional->rule_value;
 
         $response = Http::post($url_AuthRegional, [
             'email' => $emailRegional,
             'password' => $passwordRegional,
         ]);
 
         $data = $response['data'];
         $token = $data['token'];
 
         //get list province
         $ruleApiProvince = Rule::where('rule_name', 'API List Province')->first();
         $url_ApiProvince = $ruleApiProvince->rule_value;
 
         $getProvince = Http::withToken($token)
             ->get($url_ApiProvince);
         $provinces = $getProvince['data'];
         //End API Regional

        
        return view('list-branch.index',compact('branch','provinces'));
    }
}
