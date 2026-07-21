<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirebaseDeviceModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;



class FirebaseController extends Controller
{
    public function save_token(Request $request)
    {
        if (FirebaseDeviceModel::create([
            'username' => 'test',
            'device_token' => $request['token'],
            'whmcs_user_id' => (Auth::user()->role == 'admin') ? Auth::user()->id : Auth::user()->whmcs_user_id,
            'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
        ])) {
            return response()->json(['errors' => false, 'token saved successfully.']);
        } else {
            return response()->json(['errors' => true, 'Unable to save the token.']);
        }
    }

    public function send_notification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $tokens = FirebaseDeviceModel::whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();

        if (empty($tokens)) {
            return response()->json([
                'success' => false,
                'message' => 'No devices found'
            ]);
        }

        try {

            $client = new GoogleClient();

            $client->setAuthConfig(
                storage_path('app/firebase/firebase_credentials.json')
            );

            $client->addScope(
                'https://www.googleapis.com/auth/firebase.messaging'
            );

            $client->refreshTokenWithAssertion();
            $accessToken = $client->getAccessToken()['access_token'];
            $projectId = 'sbp-vue';
            $successCount = 0;
            $failedCount = 0;

            foreach ($tokens as $token) {

                try {

                    $payload = [
                        "message" => [
                            "token" => $token,
                            "notification" => [
                                "title" => $request->title,
                                "body" => $request->message,
                            ],
                            "data" => [
                                "title" => $request->title,
                                "message" => $request->message,
                            ]
                        ]
                    ];

                    $response = Http::withToken($accessToken)
                        ->post(
                            "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send",
                            $payload
                        );

                    if ($response->successful()) {

                        $successCount++;
                    } else {

                        $failedCount++;

                        \Log::error('FCM Error: ' . $response->body());
                    }
                } catch (\Exception $e) {

                    $failedCount++;

                    \Log::error('FCM Send Error: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'sent' => $successCount,
                'failed' => $failedCount,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
