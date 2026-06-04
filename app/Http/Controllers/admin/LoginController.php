<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => true,
                "msg" => $validator->errors()
            ]);
        }


        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            if(Auth::user()->role == 'user'){
                $request->session()->put('permission_version', Auth::user()->permission_version);
            }
            return response()->json([
                "errors" => false,
                "user" => Auth::user()
            ]);
        } else {
            return response()->json([
                "errors" => true,
                "msg" => ["auth_error" => "Invalid email or password"]
            ]);
        }
    }


    public function getUserDetail(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->is_2fa_verified = $request->session()->get('is_2fa_verified')?true:false;
            return response()->json([
                "errors" => false,
                "user" => Auth::user()
            ]);
        } else {
            return response()->json([
                "errors" => true,
                "user" => null
            ]);
        }
    }

    public function getAppDetail(Request $request)
    {
        if($request['id']){
           $request->session()->put('whmcs_service_id', $request['id']); 
        }
        if ($request->session()->has('whmcs_service_id')) {
            return response()->json([
                "errors" => false,
                "app_detail" => AppModel::where('id',$request->session()->get('whmcs_service_id'))->first()
            ]);
        } else {
            return response()->json([
                "errors" => true,
                "app_detail" => null
            ]);
        }
    }

    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            "errors" => false,
            "msg" => "done"
        ]);
    }
}
