<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppStoragePreference extends Model
{
     protected $table = 'app_storagage_preferences';
     protected $fillable = [
        'mode',
        'whmcs_user_id',
        'whmcs_service_id'
    ];
}
