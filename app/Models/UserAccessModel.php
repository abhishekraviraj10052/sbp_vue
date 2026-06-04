<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccessModel extends Model
{
    protected $table = 'user_access';
    protected $fillable = ['user_id','whmcs_service_id', 'status'];




    public function app()
    {
        return $this->belongsTo(AppModel::class, 'whmcs_service_id', 'id');
    }

}
