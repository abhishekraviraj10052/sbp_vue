<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintainenceModeModel extends Model
{
    protected $table = 'maintainencnce_mode';
    protected $fillable = ['id', 'status', 'message','footer_content','whmcs_user_id','whmcs_service_id'];
}
