<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppStoragePreference;
use Illuminate\Support\Facades\Auth;

class AppStoragePreferenceController extends Controller
{


    public function manage_app_storage_preference(Request $request){

        
        $message = ($request['mode'] == 'local')?'Preference changed to local successfully':'Preference changed to cloud successfully';
        if($request['id'] == ''){
            if(AppStoragePreference::create([
                'mode' => $request['mode'],
                'whmcs_user_id' => Auth::user()->id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
            ])){
                return response()->json([
                    'errors' => false,
                    'msg' => $message
                ]);
            }
        }else{
            if(AppStoragePreference::where('id',$request['id'])->update([
                'mode' => $request['mode'],
                'whmcs_user_id' => Auth::user()->id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
            ])){
                return response()->json([
                    'errors' => false,
                    'msg' => $message
                ]);
            }
        }


    }


    public function manage_app_storage_status(){
       $record = AppStoragePreference::first();
        return response()->json([
            'errors' => false,
            'record' => $record
        ]);

    }
}
