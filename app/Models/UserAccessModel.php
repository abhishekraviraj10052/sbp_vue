<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccessModel extends Model
{
    protected $table = 'user_access';
    protected $fillable = ['user_id', 'whmcs_user_id', 'apps', 'status'];
}
