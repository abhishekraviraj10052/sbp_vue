<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppModel;
use App\Models\UserAccessModel;
use Illuminate\Support\Facades\Validator;


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
        $rules = [
            'user_email' => 'required|email',
            'apps' => 'required|array|min:1',
        ];

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
        $user = User::where('email', $request->user_email)->first();
        if (!$user) {
            User::insert([
                'firstname' => $request['user_email'],
                'lastname' => $request['user_email'],
                'email' => $request['user_email'],
            ]);

            $user_id = User::where('email', $request->user_email)->first()->id;
        } else {
            $user_id = $user->id;
        }

    
        foreach($request['apps'] as $app_id){
            UserAccessModel::insert([
                'user_id' => $user_id,
                'whmcs_user_id' => auth()->user()->id,
                'app_id' => $app_id,
                'status' => 'inactive',
            ]);
        }

        return response()->json([
            'errors' => false,
            'msg' => 'User access updated successfully.'
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
}
