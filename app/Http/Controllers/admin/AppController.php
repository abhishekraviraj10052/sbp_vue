<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\AppModel;



class AppController extends Controller
{

    protected $app_model;

    public function __construct(){
        $this->app_model = new AppModel();
    }

    public function list_app(){
        $records = $this->app_model->orderBy('id','desc')->paginate(10);
        return response()->json([
            'records' => $records
        ]);
    }

    public function manage_app(Request $request,Response $response){

        $validator = Validator::make($request->all(),[
            'app_name' => 'required|unique:apps,title,' . $request['id'],
            'app_type' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        if($request['id'] == ''){
                if($this->app_model->create([
                    'title' => $request['app_name'],
                    'type' => $request['app_type'],
                    'whmcs_user_id' => 1,
                ])){
                    return response()->json([
                        'errors' => false,
                        'msg' => 'App created successfully'
                    ]);
                }else{
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to create the app'
                    ]);
                }
        }else{
                if($this->app_model->where('id',$request['id'])->update([
                    'title' => $request['app_name'],
                    'type' => $request['app_type'],
                    'whmcs_user_id' => 1,
                ])){
                    return response()->json([
                        'errors' => false,
                        'msg' => 'App updated successfully'
                    ]);
                }else{
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to update the app'
                    ]);
                }
        }

        
       
    }

    public function edit_app(Request $request){

        return response()->json([
            'errors' => false,
            'record' => $this->app_model->find($request['id'])
        ]);
    }

    public function delete_app(Request $request){

        if($this->app_model->where('id',$request['id'])->delete() > 0){
            return response()->json([
                'errors' => false,
                'msg' => 'App deleted successfully'
            ]);
        }else{
            return response()->json([
                'errors' => true,
                'msg' => 'Unable to delete the app'
            ]);
        }
       
    }

    public function app_types(){
        return response()->json([
            'app_types' => config('constant.app_types')
        ]);
    }
}
