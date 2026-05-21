<?php

use App\Http\Controllers\admin\AppController;
use App\Http\Controllers\admin\DnsController;
use App\Http\Controllers\admin\AnnouncementController;
use App\Http\Controllers\admin\DashboardAdsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\RewardedAdsController;
use App\Http\Controllers\admin\VpnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin'],function(){

    Route::post('/',[LoginController::class,'login']);
    Route::post('logout',[LoginController::class,'logout']);

    Route::post('auth-check',[LoginController::class,'authCheck']);
    Route::post('get-app-detail',[LoginController::class,'getAppDetail']);


    //Dashboard routes
    Route::post('app-detail',[DashboardController::class,'index']);

    //App routes
    Route::post('app-list',[AppController::class,'list_app']);
    Route::post('app-manage',[AppController::class,'manage_app']);
    Route::post('app-edit',[AppController::class,'edit_app']);
    Route::post('app-delete',[AppController::class,'delete_app']);
    Route::post('app-types',[AppController::class,'app_types']);

    //Dns routes
    Route::post('dns-list',[DnsController::class,'list_dns']);
    Route::post('dns-manage',[DnsController::class,'manage_dns']);
    Route::post('dns-edit',[DnsController::class,'edit_dns']);
    Route::post('dns-delete',[DnsController::class,'delete_dns']);


    //Announcement routes
    Route::post('announcement-list',[AnnouncementController::class,'list_announcements']);
    Route::post('announcement-manage',[AnnouncementController::class,'manage_announcements']);
    Route::post('announcement-edit',[AnnouncementController::class,'edit_announcement']);
    Route::post('announcement-delete',[AnnouncementController::class,'delete_announcement']);


    //Rewarded-ads routes
    Route::post('rewarded-ads-list',[RewardedAdsController::class,'list_rewarded_ads']);
    Route::post('rewarded-ads-manage',[RewardedAdsController::class,'manage_rewarded_ads']);
    Route::post('rewarded-ads-edit',[RewardedAdsController::class,'edit_rewarded_ads']);
    Route::post('rewarded-ads-delete',[RewardedAdsController::class,'delete_rewarded_ads']);
    Route::post('rewarded-ads-image-delete',[RewardedAdsController::class,'delete_image']);
    Route::post('rewarded-ads-configure',[RewardedAdsController::class,'configure_rewarded_ads']);
    Route::post('rewarded-ads-configure-data',[RewardedAdsController::class,'rewarded_ads_configuration_data']);


    //Dashboard-ads routes
    Route::post('dashboard-ads-list',[DashboardAdsController::class,'list_dashboard_ads']);
    Route::post('dashboard-ads-manage',[DashboardAdsController::class,'manage_dashboard_ads']);
    Route::post('dashboard-ads-edit',[DashboardAdsController::class,'edit_dashboard_ads']);
    Route::post('dashboard-ads-delete',[DashboardAdsController::class,'delete_dashboard_ads']);
    Route::post('dashboard-ads-image-delete',[DashboardAdsController::class,'delete_image']);
    Route::post('dashboard-ads-configure',[DashboardAdsController::class,'configure_dashboard_ads']);
    Route::post('dashboard-ads-configure-data',[DashboardAdsController::class,'dashboard_ads_configuration_data']);


    //Vpn routes
    Route::post('vpn-list',[VpnController::class,'list_vpn']);
    Route::post('vpn-manage',[VpnController::class,'manage_vpn']);
    Route::post('vpn-edit',[VpnController::class,'edit_vpn']);
    Route::post('vpn-delete',[VpnController::class,'delete_vpn']);
});


Route::get('/{any?}', function () { return view('layout'); })->where('any', '.*');


