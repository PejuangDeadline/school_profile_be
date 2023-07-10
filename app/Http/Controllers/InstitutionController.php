<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Dropdown;
use App\Models\Institution;
use App\Models\InstitutionProfile;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\searchAreaTrait;

class InstitutionController extends Controller
{
    use searchAreaTrait;
    public function index(){
        $institutions = Institution::select(
                'institutions.*',
                'institution_profiles.id as id_profile'
            )
            ->leftJoin('institution_profiles','institutions.id','institution_profiles.id_institution')
            ->get();

        $dropdownGrades = Dropdown::where('category','Grade')
            ->get();

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

        return view('institutions.index',compact('institutions','dropdownGrades','provinces'));
    }

    public function store(Request $request){
        $request->validate([
            'inst_name' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $query = Institution::create([
                'name' => $request->inst_name,
                'is_active' => '1'
            ]);

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Add Institution');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Add Institution');
        }
    }

    public function createProfile($id_inst){
        $id_inst = decrypt($id_inst);

        return view('institutions.create_profile',compact('id_inst'));
    }

    public function editProfile($id_profile){
        $id_profile = decrypt($id_profile);

        $profile = InstitutionProfile::where('id',$id_profile)->first();

        return view('institutions.edit_profile',compact('profile','id_profile'));
    }

    public function storeProfile(Request $request){
        // dd($request->all());

        $request->validate([
            'id_inst' => 'required',
            'about' => 'required',
            'vision' => 'required',
            'mission' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $query = InstitutionProfile::create([
                'id_institution' => $request->$request->id_inst,
                'about' => $request->about,
                'vision' => $request->vision,
                'mission' => $request->mission,
            ]);

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Add Institution Profile');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Add Institution Profile');
        }
    }

    public function updateProfile(Request $request){
        // dd($request->all());

        $request->validate([
            'id_profile' => 'required',
            'about' => 'required',
            'vision' => 'required',
            'mission' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $query =  InstitutionProfile:: where('id',$request->id_profile)
                ->update([
                    'about' => $request->about,
                    'vision' => $request->vision,
                    'mission' => $request->mission,
                ]);
            
            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Update Institution Profile');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Update Institution Profile');
        }
    }

    public function storeBranch(Request $request){
        //dd($request->all());
        $request->validate([
            "id_inst" => "required",
            "grade" => "required",
            "name_branch" => "required",
            "province_by_id" => "required"
        ]);

        //get Token Area
        $rule = Rule::where('rule_name', 'API Auth Regional')->first();
        $url_getToken = $rule->rule_value;

        $ruleAuthUsers = Rule::where('rule_name', 'Email Auth Regional')->first();
        $authUsername = $ruleAuthUsers->rule_value;

        $ruleAuthPass = Rule::where('rule_name', 'Password Auth Regional')->first();
        $authPassword = $ruleAuthPass->rule_value;

        $response = Http::post($url_getToken, [
            'email' => $authUsername,
            'password' => $authPassword,
        ]);

        $data = $response['data'];
        $token = $data['token'];
        
        DB::beginTransaction();
        try {
            //Area name by ID
            $province_name = $this->provinceName($token, $request->province_by_id);

            //check grade already
            $checkGrade = Branch::where('id_institution',$request->id_inst)
                            ->where('grade',$request->grade)
                            ->where('province',$province_name)
                            ->count();

            if($checkGrade > 0){
                return redirect('/institution')->with('failed','Branch With Grade '.$request->grade.' in Province '.$province_name.' Already Exist' );
            }


            $query = Branch::create([
                'id_institution' => $request->id_inst,
                'grade' => $request->grade,
                'name' => $request->name_branch,
                'province' => $province_name,
            ]);

            DB::commit();
            // all good

            return redirect('/institution')->with('status','Success Add Branch');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/institution')->with('failed','Failed Add Branch');
        }
    }
}
