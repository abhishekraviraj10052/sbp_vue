<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardedAdsConfigurationModel extends Model
{
    protected $table = 'rewarded_ads_configuration';
    protected $fillable = ['id', 'setting', 'value', 'whmcs_user_id','whmcs_service_id'];
}
