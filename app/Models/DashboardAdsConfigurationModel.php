<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardAdsConfigurationModel extends Model
{
    protected $table = 'dashboard_ads_configuration';
    protected $fillable = ['setting', 'value', 'whmcs_user_id', 'whmcs_service_id'];
}
