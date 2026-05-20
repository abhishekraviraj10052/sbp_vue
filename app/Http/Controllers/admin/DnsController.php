<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\DnsModel;
use Illuminate\Support\Facades\Auth;

class DnsController extends Controller
{

    protected $dns_model;

    public function __construct(){
        $this->dns_model = new DnsModel();
    }

    public function list_dns(){
        $records = $this->dns_model->where('whmcs_user_id', Auth::user()->id)->where('whmcs_service_id', session()->get('whmcs_service_id'))->orderBy('id','desc')->paginate(10);
        return response()->json([
            'records' => $records
        ]);
    }

    public function manage_dns(Request $request,Response $response){

        $validator = Validator::make($request->all(),[
            'dns_name' => 'required|unique:dns,name,' . $request['id'],
            'dns_value' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        if($request['id'] == ''){
                if($this->dns_model->create([
                    'name' => $request['dns_name'],
                    'dns' => $request['dns_value'],
                    'whmcs_user_id' => Auth::user()->id,
                    'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                ])){
                    return response()->json([
                        'errors' => false,
                        'msg' => 'Dns created successfully'
                    ]);
                }else{
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to create the dns'
                    ]);
                }
        }else{
                if($this->dns_model->where('id',$request['id'])->update([
                    'name' => $request['dns_name'],
                    'dns' => $request['dns_value'],
                    'whmcs_user_id' => Auth::user()->id,
                    'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                ])){
                    return response()->json([
                        'errors' => false,
                        'msg' => 'Dns updated successfully'
                    ]);
                }else{
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to Update the dns'
                    ]);
                }
        }

        
       
    }

    public function edit_dns(Request $request){

        return response()->json([
            'errors' => false,
            'record' => $this->dns_model->find($request['id'])
        ]);
    }

    public function delete_dns(Request $request){

        if($this->dns_model->where('id',$request['id'])->delete() > 0){
            return response()->json([
                'errors' => false,
                'msg' => 'Dns deleted successfully'
            ]);
        }else{
            return response()->json([
                'errors' => true,
                'msg' => 'Unable to delete the dns'
            ]);
        }
       
    }
}
