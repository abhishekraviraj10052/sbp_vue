<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TwoFaController extends Controller
{


    public function generate2faSecret(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $google2faUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='
            . urlencode($google2faUrl);

        session()->put('2fa_secret', $secret);
        return response()->json([
            'secret' => $secret,
            'qr' => $qrImage
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
        $valid = $google2fa->verifyKey(
            session()->get('2fa_secret'),
            $request['otp']
        );

        if (!$valid) {
            return response()->json([
                "errors" => true,
                "msg" => ['otp' => ['Invalid OTP']]
            ]);
        }

        $user->google2fa_secret = session()->get('2fa_secret');
        $user->is_2fa_enabled = true;
        $user->save();
        session()->forget('2fa_secret');
        return response()->json(['errors' => false,'msg' => '2FA enabled successfully']);
    }

    public function verify_2fa_login(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $google2fa = new Google2FA();
        if (!$google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            return response()->json([
                "errors" => true,
                "msg" => ['otp' => ['Invalid OTP']]
            ], 422);
        }
        auth()->login($user);
        return response()->json(['errors' => false,'msg' => 'Login successful']);
    }
}
