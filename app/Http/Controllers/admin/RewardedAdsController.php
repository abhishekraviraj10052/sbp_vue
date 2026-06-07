<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RewardedAdsConfigurationModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\RewardedAdsModel;
use Illuminate\Support\Facades\Auth;


class RewardedAdsController extends Controller
{
    protected $rewarded_ads_model;

    public function __construct()
    {
        $this->rewarded_ads_model = new RewardedAdsModel();
    }

    public function list_rewarded_ads(Request $request)
    {

            $whmcs_user_id = (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id;
            $query = RewardedAdsModel::where('whmcs_user_id',$whmcs_user_id)->where('whmcs_service_id',$request->session()->get('whmcs_service_id'));
            
            if ($request->search) {
                
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('type', 'like', '%' . $request->search . '%');
                });

            }

            $sortField = $request->sort_field ?? 'id';
            $sortDirection = $request->sort_direction ?? 'desc';
            $query->orderBy($sortField, $sortDirection);

            $records = $query->paginate(10);
            foreach ($records as $index =>  $record) {
                if ($record->type == 'image') {
                    $record->filepath = explode(',', $record->filepath);
                }
            };
            return response()->json([
                'errors' => false,
                'records' => $records
            ]);

    }

    public function manage_rewarded_ads(Request $request, Response $response)
    {


        if ($request['content_type'] == 'image') {

            $file_validation_rules1 = '';
            $file_validation_rules2 = '';
            if ($request['id'] == '') {
                  $file_validation_rules1 = 'required|array';
            }
            if ($request->hasFile('files')) {
                $file_validation_rules2 = 'image|mimes:jpeg,png,jpg,gif|max:2048';
            }

            $validator = Validator::make($request->all(), [
                 'title' => 'required|unique:rewarded_ads,title,' . $request['id'],
                 'files' => $file_validation_rules1,
                 'files.*' => $file_validation_rules2
            ], [
                'files.required' => 'The image field is required.',
                'files.*.image' => 'Each file must be an image.',
                'files.*.mimes' => 'Each file must be a jpeg, png, jpg, or gif.',
                'files.*.max' => 'Each file must not exceed 2048 kilobytes.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:rewarded_ads,title,' . $request['id'],
                'message' => 'required'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $filenames = [];
        if ($request['id'] != '') {
            $record = $this->rewarded_ads_model->find($request['id']);
            if ($record->type == 'image' && $record->filepath != '') {
                $filenames = explode(',', $record->filepath);
            }
        }
        if ($request->hasFile('files')) {

            $dir = public_path('uploads/rewarded_ads/');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($dir, $filename);
                $filenames[] = $filename;
            }
        }



        if ($request['id'] == '') {

            if ($this->rewarded_ads_model->insert([
                'title' => $request['title'],
                'type' => $request['content_type'],
                'filepath' => implode(',', $filenames),
                'text' => $request['message'] ?? '',
                'status' => $request['status'] ?? 'active',
                'redirect_link' => $request['redirect_link'] ?? '',
                'whmcs_user_id' => (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ])) {
                return response()->json([
                    'errors' => false,
                    'msg' => 'Rewarded ads created successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to create the rewarded ads'
                ]);
            }
        } else {
            
            if ($this->rewarded_ads_model->where('id', $request['id'])->update([
                'title' => $request['title'],
                'type' => $request['content_type'],
                'filepath' => implode(',', $filenames),
                'text' => $request['message'],
                'status' => $request['status'] ?? 'active',
                'redirect_link' => $request['redirect_link'] ?? '',
                'whmcs_user_id' => (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ])) {
                return response()->json([
                    'errors' => false,
                    'files' => $filenames,
                    'msg' => 'Rewarded ads updated successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to Update the rewarded ads'
                ]);
            }
        }
    }

    public function edit_rewarded_ads(Request $request)
    {

        $record = $this->rewarded_ads_model->find($request['id']);
        if ($record->type == 'image' && $record->filepath != '') {
            $record->filepath = explode(',', $record->filepath);
        }

        return response()->json([
            'errors' => false,
            'record' => $record
        ]);
    }

    public function delete_image(Request $request)
    {
        $record = $this->rewarded_ads_model->find($request['id']);
        if ($record) {
            $filepaths = explode(',', $record->filepath);
            if (($key = array_search($request['filename'], $filepaths)) !== false) {
                if (file_exists(public_path('uploads/rewarded_ads/' . $request['filename']))) {
                    unlink(public_path('uploads/rewarded_ads/' . $request['filename']));
                }
                unset($filepaths[$key]);
                $record->filepath = implode(',', $filepaths);
                $record->save();
                return response()->json([
                    'errors' => false,
                    'msg' => 'Image deleted successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Image not found in the record'
                ]);
            }
        } else {
            return response()->json([
                'errors' => true,
                'msg' => 'Record not found'
            ]);
        }
    }

    public function delete_rewarded_ads(Request $request)
    {
        $record = $this->rewarded_ads_model->find($request['id']);
        if ($record && $record->type == 'image' && $record->filepath != '') {
            $filepaths = explode(',', $record->filepath);
            foreach ($filepaths as $filepath) {
                if (file_exists(public_path('uploads/rewarded_ads/' . $filepath))) {
                    unlink(public_path('uploads/rewarded_ads/' . $filepath));
                }
            }
        }

        if ($this->rewarded_ads_model->where('id', $request['id'])->delete() > 0) {
            return response()->json([
                'errors' => false,
                'msg' => 'Advertisement deleted successfully'
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'msg' => 'Unable to delete the advertisement'
            ]);
        }
    }



    public function configure_rewarded_ads(Request $request)
    {
        $configurations = $request->except('id');
        foreach ($configurations as $setting => $value) {
            RewardedAdsConfigurationModel::updateOrCreate(
                ['setting' => $setting],
                [
                    'value' => $value, 
                    'whmcs_user_id' => (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id,
                    'whmcs_service_id' => $request->session()->get('whmcs_service_id')
                ]
            );
        }
        return response()->json([
            'errors' => false,
            'msg' => 'Configuration saved successfully'
        ]);
    }

    public function rewarded_ads_configuration_data()
    {
        $configurations = RewardedAdsConfigurationModel::all();
        $config_data = [];
        foreach ($configurations as $config) {
            $config_data[$config->setting] = $config->value;
        }
        return response()->json([
            'errors' => false,
            'configurations' => $config_data
        ]);
    }
}
