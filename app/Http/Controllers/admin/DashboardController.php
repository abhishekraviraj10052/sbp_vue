<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    AppModel,
    AnnouncementModel,
    DashboardAdsModel,
    DnsModel,
    RewardedAdsModel
};



class DashboardController extends Controller
{
    protected $app_model;
    protected $announcement_model;
    protected $dashboard_ads_model;
    protected $dns_model;
    protected $rewarded_ads_model;

    public function __construct()
    {
        $this->app_model = new AppModel();
        $this->announcement_model = new AnnouncementModel();
        $this->dashboard_ads_model = new DashboardAdsModel();
        $this->dns_model = new DnsModel();
        $this->rewarded_ads_model = new RewardedAdsModel();
    }

    public function index(Request $request)
    {
        $whmcs_user_id = (Auth::user()->role == 'admin')?Auth::user()->id:Auth::user()->whmcs_user_id;
        $whmcs_service_id = $request->session()->put('whmcs_service_id', $request['whmcs_service_id']);
        return response()->json([
            'announcement_count' => $this->announcement_model->where('whmcs_user_id', $whmcs_user_id)->where('whmcs_service_id', $whmcs_service_id)->count(),
            'dashboard_ads_count' => $this->dashboard_ads_model->where('whmcs_user_id', $whmcs_user_id)->where('whmcs_service_id', $whmcs_service_id)->count(),
            'dns_count' => $this->dns_model->where('whmcs_user_id', $whmcs_user_id)->where('whmcs_service_id', $whmcs_service_id)->count(),
            'rewarded_ads_count' => $this->rewarded_ads_model->where('whmcs_user_id', $whmcs_user_id)->where('whmcs_service_id', $whmcs_user_id)->count(),
        ]);
    }
}
