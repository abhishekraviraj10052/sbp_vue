<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MaintainenceModeModel;
use Illuminate\Support\Facades\Auth;



class MaintainenceModeController extends Controller
{

    protected $MaintainenceModeModel;

    public function __construct(){
        $this->MaintainenceModeModel = new MaintainenceModeModel();
    }

    public function manage_maintainence_mode(Request $request){
        $validator = Validator::make($request->all(),[
            'status' => 'nullable',
            'message' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        if($request['id'] == ''){
                if($this->MaintainenceModeModel->create([
                    'status' => ($request['status'])?'on':'off',
                    'message' => $request['message'],
                    'whmcs_user_id' => Auth::user()->id,
                    'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                ])){
                    return response()->json([
                        'errors' => false,
                        'msg' => 'Maintainence mode created successfully'
                    ]);
                }else{
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to create the app'
                    ]);
                }
        }else{
                if($this->MaintainenceModeModel->where('id',$request['id'])->update([
                    'status' => ($request['status'])?'on':'off',
                    'message' => $request['message'],
                    'whmcs_user_id' => Auth::user()->id,
                    'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                ])){
                    return response()->json([
                        'errors' => false,
                        'msg' => 'Maintainence mode updated successfully'
                    ]);
                }else{
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to update'
                    ]);
                }
        }

    }

    public function manage_maintainence_status(Request $request){
        $record = $this->MaintainenceModeModel->where('whmcs_user_id',Auth::user()->id)->where('whmcs_service_id',$request->session()->get('whmcs_service_id'))->first();

         if($record){
            return response()->json([
                    'errors' => false,
                    'id' => $record->id,
                    'status' => $record->status,
                    'msg' => $record->message
                ]);
        }else{

          return response()->json([]);
    }
        }
}
