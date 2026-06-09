<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirebaseDeviceModel extends Model
{
    protected $table = 'firebase_devices';
    protected $fillable = ['username','device_token','whmcs_user_id','whmcs_service_id'];
}
