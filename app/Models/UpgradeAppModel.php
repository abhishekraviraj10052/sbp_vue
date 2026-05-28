<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeAppModel extends Model
{
    protected $table = 'apk_versions';
    protected $fillable = ['apk_file_name', 'apk_version_name', 'apk_version_code', 'whmcs_user_id', 'whmcs_service_id'];
}
