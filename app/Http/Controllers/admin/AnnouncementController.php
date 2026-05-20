<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\AnnouncementModel;

class AnnouncementController extends Controller
{
    protected $announcement_model;

    public function __construct()
    {
        $this->announcement_model = new AnnouncementModel();
    }

    public function list_announcements()
    {
        $records = $this->announcement_model->orderBy('id', 'desc')->paginate(10);
        return response()->json([
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
                'whmcs_user_id' => 1,
                'whmcs_service_id' => 1,
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
                'whmcs_user_id' => 1,
                'whmcs_service_id' => 1,
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
