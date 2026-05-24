<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DashboardAdsConfigurationModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\VpnModel;
use ZipArchive;
use Illuminate\Support\Facades\Auth;


class VpnController extends Controller
{
    protected $vpn_model;

    public function __construct()
    {
        $this->vpn_model = new VpnModel();
    }

    public function list_vpn(Request $request)
    {
            $query = VpnModel::query();
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

    public function manage_vpn(Request $request, Response $response)
    {


        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240'
        ], [
            'file.required' => 'The file field is required.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $allowedExtensions = ['ovpn', 'zip'];

        $file = $request->file('file');

        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        if (!in_array($extension, $allowedExtensions)) {
            return response()->json(['errors' => true, 'msg' => ['file' => ['The file must be an .ovpn or zip file.']]]);
        }
        $filePath = $file->getRealPath();
        $fileContent = file_get_contents($filePath);

        if ($file && $file->getClientOriginalExtension() != 'zip') {
            if (!$this->isValidVpnContent($fileContent)) {
                return response()->json(['errors' => true, 'msg' => ['file' => ['The file must be a valid .ovpn file.']]]);
            }
        }


        $zip_contents = [];
        if ($file && $file->getClientOriginalExtension() === 'zip') {
            $path = $file->getRealPath();
            $zip_contents = $this->getZipContent($path);
        }

        $title = $request['title'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $password = (!empty(trim($request['password']))) ? Hash::make($request['password']) : '';
        $shareable_password = (!empty(trim($request['password']))) ? aes_encrypt($request['password']) : '';

        if ($request['id'] == '') {

            if (!empty($zip_contents)) {
                foreach ($zip_contents as $zip_content) {
                    $this->vpn_model->insert([
                        'title' => $this->generateUniqueTitle($zip_content['title']),
                        'username' => $request['username'],
                        'password' => $password,
                        'shareable_password' => $shareable_password,
                        'file_content' => aes_encrypt($zip_content['file_content']),
                        'whmcs_user_id' => Auth::user()->id,
                        'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    return response()->json([
                        'errors' => false,
                        'msg' => 'VPN created successfully'
                    ]);
                }
            } else {
                if ($this->vpn_model->insert([
                    'title' => $this->generateUniqueTitle($title),
                    'username' => $request['username'],
                    'password' => $password,
                    'shareable_password' => $shareable_password,
                    'file_content' => aes_encrypt($fileContent),
                    'whmcs_user_id' => Auth::user()->id,
                    'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ])) {
                    return response()->json([
                        'errors' => false,
                        'msg' => 'VPN created successfully'
                    ]);
                } else {
                    return response()->json([
                        'errors' => true,
                        'msg' => 'Unable to create the VPN'
                    ]);
                }
            }
        } else {

            if ($this->vpn_model->where('id', $request['id'])->update([
                'title' => $request['title'],
                'username' => $request['username'],
                'password' => $password,
                'shareable_password' => $shareable_password,
                'whmcs_user_id' => Auth::user()->id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ])) {
                return response()->json([
                    'errors' => false,
                    'msg' => 'VPN updated successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to Update the VPN'
                ]);
            }
        }
    }

    public function edit_vpn(Request $request)
    {

        $record = $this->vpn_model->find($request['id']);
        if ($record->filepath != '') {
            $record->filepath = explode(',', $record->filepath);
        } else {
            $record->filepath = [];
        }

        return response()->json([
            'errors' => false,
            'record' => $record
        ]);
    }


    function generateUniqueTitle($title)
    {

        $originalTitle = $title;
        $count = 0;

        while ($this->vpn_model->where('title', $title)->exists()) {
            $count++;
            $title = $originalTitle . '(' . $count . ')';
        }

        return $title;
    }


    public function delete_vpn(Request $request)
    {
        $record = $this->vpn_model->find($request['id']);
        if ($record && $record->type == 'image' && $record->filepath != '') {
            $filepaths = explode(',', $record->filepath);
            foreach ($filepaths as $filepath) {
                if (file_exists(public_path('uploads/vpn/' . $filepath))) {
                    unlink(public_path('uploads/vpn/' . $filepath));
                }
            }
        }

        if ($this->vpn_model->where('id', $request['id'])->delete() > 0) {
            return response()->json([
                'errors' => false,
                'msg' => 'VPN deleted successfully'
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'msg' => 'Unable to delete the VPN'
            ]);
        }
    }


    private function getZipContent($path)
    {
        $zip = new ZipArchive;

        if ($zip->open($path) === TRUE) {

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileName = $zip->getNameIndex($i);
                if (substr($fileName, -1) == '/') {
                    continue;
                }

                $fileContent = $zip->getFromIndex($i);
                if (!$this->isValidVpnContent($fileContent)) {
                    return response()->json(['errors' => true, 'msg' => ['file' => ['The file must be a valid .ovpn file.']]]);
                }

                $contents[] = [
                    'title' => $fileName,
                    'file_content' => $fileContent
                ];
            }

            $zip->close();
        }

        return $contents;
    }


    private function isValidVpnContent($content)
    {

        $requiredSections = ['client', 'remote', 'ca', 'cert', 'key'];
        foreach ($requiredSections as $section) {
            if (!preg_match("/\b$section\b/", $content)) {
                return false;
            }
        }
        return true;
    }
}
