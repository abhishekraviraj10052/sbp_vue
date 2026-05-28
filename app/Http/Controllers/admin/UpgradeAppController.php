<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\UpgradeAppModel;
use Illuminate\Support\Facades\Auth;


class UpgradeAppController extends Controller
{
    public function manage_app_version(Request $request)
    {
        if ($request->isMethod('post')) {
            if (!$request->hasFile('file')) {
                return response()->json(['message' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');
            $fileName = $request->fileName;
            $chunkIndex = $request->chunkIndex;
            $totalChunks = $request->totalChunks;

            $chunkPath = storage_path('app/chunks/' . $request->session()->get('whmcs_service_id'));
            if ($chunkIndex == 0) {
                File::deleteDirectory($chunkPath);
            }


            if (!file_exists($chunkPath)) {
                mkdir($chunkPath, 0777, true);
            }

            //Save chunk
            $file->move($chunkPath, $chunkIndex);

            //Check all chunks exist
            $allUploaded = true;

            for ($i = 0; $i < $totalChunks; $i++) {
                if (!file_exists($chunkPath . '/' . $i)) {
                    $allUploaded = false;
                    break;
                }
            }

            if (!$allUploaded) {
                return response()->json([
                    'message' => 'Chunk uploaded'
                ]);
            }

            //Create upload directory
            $uploadDir = storage_path('app/uploads/apk_folder_' . $request->session()->get('whmcs_service_id'));
            if ($allUploaded) {
                File::deleteDirectory($uploadDir);
            }

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $finalPath = $uploadDir . '/' . $fileName;

            //IMPORTANT: use wb not ab
            $outputFile = fopen($finalPath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {

                $chunkFile = $chunkPath . '/' . $i;
                $inputFile = fopen($chunkFile, 'rb');
                while ($buffer = fread($inputFile, 4096)) {
                    fwrite($outputFile, $buffer);
                }
                fclose($inputFile);
                unlink($chunkFile);
            }

            fclose($outputFile);
            File::deleteDirectory($chunkPath);
            $apkDetails = $this->getApkVersionDetails($finalPath);

            if (is_array($apkDetails)) {
                $existingRecord = UpgradeAppModel::where('whmcs_user_id', Auth::user()->id)->where('whmcs_service_id', $request->session()->get('whmcs_service_id'))->first();
                if (!$existingRecord) {
                    UpgradeAppModel::insert([
                        'apk_file_name' => $fileName,
                        'apk_version_name' => $apkDetails['versionName'],
                        'apk_version_code' => $apkDetails['versionCode'],
                        'whmcs_user_id' => Auth()->user()->id,
                        'whmcs_service_id' => $request->session()->get('whmcs_service_id')
                    ]);
                } else {
                    if ($existingRecord) {
                        $existingRecord->update([
                            'apk_file_name' => $fileName,
                            'apk_version_name' => $apkDetails['versionName'],
                            'apk_version_code' => $apkDetails['versionCode'],
                            'whmcs_user_id' => Auth()->user()->id,
                            'whmcs_service_id' => $request->session()->get('whmcs_service_id')
                        ]);
                    } else {
                        return response()->json(['message' => 'Record not found'], 404);
                    }
                }

                return response()->json([
                    'errors' => false,
                    'record' => 'done'
                ]);
            }
        }else{
            $record = UpgradeAppModel::where('whmcs_user_id', Auth::user()->id)->where('whmcs_service_id', $request->session()->get('whmcs_service_id'))->first();
            return response()->json([
                'record' => $record
            ]);
        }
    }

    public function delete_app_version(Request $request)
    {
        if ($request->isMethod('post')) {
            $record = UpgradeAppModel::where('whmcs_user_id', Auth::user()->id)->where('whmcs_service_id', $request->session()->get('whmcs_service_id'))->first();
            if ($record) {
                $filePath = storage_path('app/uploads/apk_folder_' . $request->session()->get('whmcs_service_id') . '/' . $record->apk_file_name);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $record->delete();
                return response()->json(['errors' => false,'message' => 'Apk deleted successfully']);
            } else {
                return response()->json(['message' => 'Record not found'], 404);
            }
        }
    }



    function getApkVersionDetails($apkFilePath)
    {
        $packageName ='com.example.app';
        $versionName = 1.0;
        $versionCode = 100;
        return [
            'packageName' => $packageName,
            'versionName' => $versionName,
            'versionCode' => $versionCode,
        ];

        // Path to the aapt binary
        $aaptPath = WRITEPATH . 'android-sdk/lib/build-system/aapt2-proto';
        $aaptPath = 'aapt';

        //Check if aapt exists at the specified path
        $aaptCheckCommand = escapeshellcmd($aaptPath);
        if (shell_exec("which $aaptCheckCommand") === null) {
            return 'aapt tool not found';
        }

        //Run the aapt command to get the APK details
        $command = escapeshellcmd("$aaptPath dump badging " . escapeshellarg($apkFilePath));
        $output = shell_exec($command);


        if ($output === null) {
            return 'Failed to execute aapt command';
        }


        $versionName = null;
        $versionCode = null;
        $packageName = null;

        if (preg_match("/package: name='([^']+)'/", $output, $matches)) {
            $packageName = $matches[1];
        }

        if (preg_match("/versionName='([^']+)'/", $output, $matches)) {
            $versionName = $matches[1];
        }

        if (preg_match("/versionCode='([^']+)'/", $output, $matches)) {
            $versionCode = $matches[1];
        }

        return [
            'packageName' => $packageName,
            'versionName' => $versionName,
            'versionCode' => $versionCode,
        ];
    }
}
