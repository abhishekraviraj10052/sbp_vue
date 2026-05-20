<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VpnModel extends Model
{
    protected $table = 'vpns';
    protected $fillable = [
        'id',
        'title',
        'username',
        'password',
        'file_content',
        'vpn_username',
        'vpn_password',
        'whmcs_user_id',
        'whmcs_service_id'
    ];
}
