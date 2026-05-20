<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DnsModel extends Model
{
    protected $table = 'dns';
    protected $fillable = ['name','dns','whmcs_user_id','whmcs_service_id'];
}
