<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DashboardAdsConfigurationModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\DashboardAdsModel;

class DashboardAdsController extends Controller
{
    protected $dashboard_ads_model;

    public function __construct()
    {
        $this->dashboard_ads_model = new DashboardAdsModel();
    }

    public function list_dashboard_ads()
    {
        $records = $this->dashboard_ads_model->orderBy('id', 'desc')->paginate(10);
        foreach ($records as $index =>  $record) {
            $record->filepath = explode(',', $record->filepath);
        };
        return response()->json([
            'records' => $records
        ]);
    }

    public function manage_dashboard_ads(Request $request, Response $response)
    {

        $file_validation_rules1 = '';
        $file_validation_rules2 = '';
        if ($request['id'] == '') {
                $file_validation_rules1 = 'required|array';
        }
        if ($request->hasFile('files')) {
            $file_validation_rules2 = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:dashboard_ads,title,' . $request['id'],
            'files' => $file_validation_rules1,
            'files.*' => $file_validation_rules2
        ], [
            'files.required' => 'The image field is required.',
            'files.*.image' => 'Each file must be an image.',
            'files.*.mimes' => 'Each file must be a jpeg, png, jpg, or gif.',
            'files.*.max' => 'Each file must not exceed 2048 kilobytes.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $filenames = [];
        if ($request['id'] != '') {
            $record = $this->dashboard_ads_model->find($request['id']);
            if ($record->filepath != '') {
                $filenames = explode(',', $record->filepath);
            }
        }
        if ($request->hasFile('files')) {

            $dir = public_path('uploads/dashboard_ads/');
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

            if ($this->dashboard_ads_model->insert([
                'title' => $request['title'],
                'type' => $request['content_type'],
                'filepath' => implode(',', $filenames),
                'text' => $request['message'] ?? '',
                'status' => $request['status'] ?? 'active',
                'redirect_link' => $request['redirect_link'] ?? '',
                'whmcs_user_id' => 1,
                'whmcs_service_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ])) {
                return response()->json([
                    'errors' => false,
                    'msg' => 'Dashboard ads created successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to create the dashboard ads'
                ]);
            }
        } else {

            if ($this->dashboard_ads_model->where('id', $request['id'])->update([
                'title' => $request['title'],
                'type' => $request['content_type'],
                'filepath' => implode(',', $filenames),
                'text' => $request['message'],
                'status' => $request['status'],
                'redirect_link' => $request['redirect_link'] ?? '',
                'whmcs_user_id' => 1,
                'whmcs_service_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ])) {
                return response()->json([
                    'errors' => false,
                    'files' => $filenames,
                    'msg' => 'Dashboard ads updated successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to Update the dashboard ads'
                ]);
            }
        }
    }

    public function edit_dashboard_ads(Request $request)
    {

        $record = $this->dashboard_ads_model->find($request['id']);
        if ($record->filepath != '') {
            $record->filepath = explode(',', $record->filepath);
        }else{
            $record->filepath = [];
        }

        return response()->json([
            'errors' => false,
            'record' => $record
        ]);
    }

    public function delete_image(Request $request)
    {
        $record = $this->dashboard_ads_model->find($request['id']);
        if ($record) {
            $filepaths = explode(',', $record->filepath);
            if (($key = array_search($request['filename'], $filepaths)) !== false) {
                if (file_exists(public_path('uploads/dashboard_ads/' . $request['filename']))) {
                    unlink(public_path('uploads/dashboard_ads/' . $request['filename']));
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

    public function delete_dashboard_ads(Request $request)
    {
        $record = $this->dashboard_ads_model->find($request['id']);
        if ($record && $record->type == 'image' && $record->filepath != '') {
            $filepaths = explode(',', $record->filepath);
            foreach ($filepaths as $filepath) {
                if (file_exists(public_path('uploads/dashboard_ads/' . $filepath))) {
                    unlink(public_path('uploads/dashboard_ads/' . $filepath));
                }
            }
        }

        if ($this->dashboard_ads_model->where('id', $request['id'])->delete() > 0) {
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

    public function configure_dashboard_ads(Request $request)
    {
        $config = DashboardAdsConfigurationModel::first();
        if ($config) {
            $config->setting = 'add_status';
            $config->value = $request['add_status'];
            $config->whmcs_user_id = 1;
            $config->whmcs_service_id = 1;
            $config->save();
        } else {
            DashboardAdsConfigurationModel::insert([
                'setting' => 'add_status',
                'value' => $request['add_status'],
                'whmcs_user_id' => 1,
                'whmcs_service_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return response()->json([
            'errors' => false,
            'msg' => 'Dashboard ads configuration updated successfully'
        ]);
    }

    public function dashboard_ads_configuration_data()
    {
        $configurations = DashboardAdsConfigurationModel::all();
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
