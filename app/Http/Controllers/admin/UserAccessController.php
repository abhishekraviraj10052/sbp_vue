<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppModel;
use App\Models\UserAccessModel;
use App\Models\UserAccessVerificationTokenModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class UserAccessController extends Controller
{
    public function list_user_access(Request $request)
    {
        $query = User::with('accesses.app')->where('role', 'user');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                    ->orWhere('firstname', 'like', '%' . $request->search . '%')
                    ->orWhere('lastname', 'like', '%' . $request->search . '%');
            });
        }

        $sortField = $request->sort_field ?? 'id';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        $records = $query->paginate(10);

        return response()->json([
            'errors' => false,
            'records' => $records
        ]);
    }


    public function manage_user_access(Request $request)
    {


        $validator = Validator::make($request->all(),  [
            'user_email' => 'required|email',
            'apps' => 'required|array|min:1',
        ], [
            'apps.required' => 'Please select at least one app.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $user_id = '';
        $status = '';
        $user = User::where('email', $request->user_email)->first();
        if (!$user) {
            User::insert([
                'whmcs_user_id' => Auth::user()->id,
                'firstname' => $request['user_email'],
                'lastname' => $request['user_email'],
                'email' => $request['user_email'],
            ]);

            $user_id = User::where('email', $request->user_email)->first()->id;
            $status = 'inactive';
        } else {
            $user->increment('permission_version');
            $user_id = $user->id;
            if($user->password == ''){
                $status = 'inactive';
            }else{
                $status = 'active';
            }
            
        }


        UserAccessModel::where('user_id', $user_id)->delete();
        foreach ($request['apps'] as $app_id) {
            UserAccessModel::insert([
                'user_id' => $user_id,
                'whmcs_service_id' => $app_id,
                'status' => $status,
            ]);
        }

        if ($status == 'inactive') {
            $token = Str::random(15);
            UserAccessVerificationTokenModel::insert([
                'user_id' => $user_id,
                'token' => md5($token),
            ]);
            $data = [
                'name' => $request['user_email'],
                'verificationUrl' => url('/') . '/user-access-verify/' . $token,
            ];

            try {

                Mail::to($request['user_email'])->send(new WelcomeEmail($data));
                return response()->json([
                    'errors' => false,
                    'msg' => 'Verification link has been sent successfully!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Failed to send verification link: ' . $e->getMessage()
                ], 500);
            }
        }else{
            return response()->json([
                'errors' => false,
                'msg' => 'User access updated successfully!'
             ]);
        }
    }

    public function validate_token(Request $request)
    {

        $record = UserAccessVerificationTokenModel::where('token', md5($request['token']))->first();
        if ($record) {
            UserAccessModel::where('user_id', $record->user_id)->update(['status' => 'active']);
            return response()->json([
                'errors' => false,
                'user_id' => $record->user_id,
                'msg' => 'Account activated successfully now create password!'
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'msg' => 'Invalid token!'
            ]);
        }
    }

    public function create_password(Request $request)
    {
        
        $validator = Validator::make($request->all(),  [
            'user_id' => 'required|exists:users,id',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        $user = User::where('id', $request['user_id'])->first();
        $user->password = Hash::make($request['password']);
        $user->save();

        UserAccessVerificationTokenModel::where('user_id', $request['user_id'])->delete();
        return response()->json([
            'errors' => false,
            'msg' => 'Password created successfully'
        ]);
    }

    public function user_access_apps()
    {
        $apps = AppModel::select('id', 'title')->get();
        return response()->json([
            'errors' => false,
            'apps' => $apps
        ]);
    }


    public function edit_user_access(Request $request)
    {

        $user = User::where('id', $request->id)->first();
        $apps = UserAccessModel::where('user_id', $user->id)->pluck('whmcs_service_id')->toArray();
        return response()->json([
            'errors' => false,
            'user_email' => $user->email,
            'assigned_apps' => $apps
        ]);
    }


    public function delete_user_access(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user) {
            UserAccessModel::where('user_id', $user->id)->delete();
            // $user->delete();
            return response()->json([
                'errors' => false,
                'msg' => 'User access deleted successfully!'
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'msg' => 'User not found!'
            ]);
        }
    }
}
