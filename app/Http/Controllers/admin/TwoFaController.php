<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class TwoFaController extends Controller
{


    public function generate_2fa_secret(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $user->google2fa_secret = aes_encrypt($secret);
        $user->save();
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return response()->json([
            'secret' => $secret,
            'qr' => $qrCodeUrl
        ]);
    }

    public function verify_2fa_otp(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
           'otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => true,
                "msg" => $validator->errors()
            ]);
        }

        $google2fa = new Google2FA();
        $user = auth()->user();
        if($user->google2fa_secret == ''){
            return response()->json([
                "errors" => true,
                "msg" => ['otp' => ['Invalid OTP']]
            ]);
        }
        $valid = $google2fa->verifyKey(
            aes_decrypt($user->google2fa_secret),
            $request['otp']
        );

        if (!$valid) {
            return response()->json([
                "errors" => true,
                "msg" => ['otp' => ['Invalid OTP']]
            ]);
        }
        
        $google2fa_backup_code = 
        strtoupper(Str::random(4)) 
        . '-' . strtoupper(Str::random(4)) 
        . '-' . strtoupper(Str::random(4)) 
        .'-' . strtoupper(Str::random(4));
        
        $user->google2fa_backup_code = aes_encrypt($google2fa_backup_code);
        $user->is_2fa_enabled = true;
        $request->session()->put('is_2fa_verified',true);
        $user->save();
        return response()->json(['errors' => false, 'google2fa_backup_code' => $google2fa_backup_code, 'msg' => '2FA enabled successfully']);
    }

    public function verify_2fa_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => true,
                "msg" => $validator->errors()
            ]);
        }

        $user = auth()->user();
        if($user->google2fa_secret == ''){
            return response()->json([
                "errors" => true,
                "msg" => ['otp' => ['Invalid OTP']]
            ]);
        }
        $google2fa = new Google2FA();
        if (!$google2fa->verifyKey(aes_decrypt($user->google2fa_secret), $request->otp)) {
            return response()->json([
                "errors" => true,
                "msg" => ['otp' => ['Invalid OTP']]
            ]);
        }
        $request->session()->put('is_2fa_verified',true);
        $user->is_2fa_verified = $request->session()->get('is_2fa_verified');
        return response()->json(['errors' => false, 'user' => $user, 'msg' => 'Login successful']);
    }

    public function disable_2fa(){
        $user = auth()->user();
        $user->google2fa_secret = '';
        $user->google2fa_backup_code= '';
        $user->is_2fa_enabled = false;
        $user->save();
        return response()->json(['errors' => false, 'msg' => '2FA disabled successfully']);

    }


    public function reset_backup_code(){
        $user = auth()->user();
        $google2fa_backup_code = 
        strtoupper(Str::random(4)) 
        . '-' . strtoupper(Str::random(4)) 
        . '-' . strtoupper(Str::random(4)) 
        .'-' . strtoupper(Str::random(4));
        
        $user->google2fa_backup_code = aes_encrypt($google2fa_backup_code);
        $user->save();
        return response()->json(['errors' => false, 'msg' => 'Backup code reset successfully']);

    }

    public function download_backup_code()
    {
        $user = auth()->user();
        return response(aes_decrypt($user->google2fa_backup_code))
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=backupcode');
    }
}
