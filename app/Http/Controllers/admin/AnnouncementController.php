<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\AnnouncementModel;
use Illuminate\Support\Facades\Auth;


class AnnouncementController extends Controller
{
    protected $announcement_model;

    public function __construct()
    {
        $this->announcement_model = new AnnouncementModel();
    }

    public function list_announcements(Request $request)
    {

        $whmcs_user_id = (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id;
        $query = AnnouncementModel::where('whmcs_user_id',$whmcs_user_id)->where('whmcs_service_id',$request->session()->get('whmcs_service_id'));
        if ($request->search) {
            
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
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

    public function manage_announcements(Request $request, Response $response)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:announcements,title,' . $request['id'],
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => true,
                'msg' => $validator->errors()
            ]);
        }

        if ($request['id'] == '') {
            if ($this->announcement_model->create([
                'title' => $request['title'],
                'message' => $request['message'],
                'whmcs_user_id' => (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
            ])) {
                return response()->json([
                    'errors' => false,
                    'msg' => 'Announcement created successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to create the announcement'
                ]);
            }
        } else {
            if ($this->announcement_model->where('id', $request['id'])->update([
                'title' => $request['title'],
                'message' => $request['message'],
                'whmcs_user_id' => (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id,
                'whmcs_service_id' => $request->session()->get('whmcs_service_id'),
            ])) {
                return response()->json([
                    'errors' => false,
                    'msg' => 'Announcement updated successfully'
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'msg' => 'Unable to Update the announcement'
                ]);
            }
        }
    }

    public function edit_announcement(Request $request)
    {

        return response()->json([
            'errors' => false,
            'record' => $this->announcement_model->find($request['id'])
        ]);
    }

    public function delete_announcement(Request $request)
    {

        if ($this->announcement_model->where('id', $request['id'])->delete() > 0) {
            return response()->json([
                'errors' => false,
                'msg' => 'Announcement deleted successfully'
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'msg' => 'Unable to delete the announcement'
            ]);
        }
    }
}
