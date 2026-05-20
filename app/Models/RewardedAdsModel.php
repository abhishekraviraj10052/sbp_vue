<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardedAdsModel extends Model
{
    protected $table = 'rewarded_ads';
    protected $fillable = [
        'title',
        'type',
        'filepath',
        'text',
        'status',
        'redirect_link',
        'whmcs_user_id',
        'whmcs_service_id'
    ];
}
