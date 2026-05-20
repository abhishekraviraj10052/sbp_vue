<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcements';
    protected $fillable = ['title','message','whmcs_user_id','whmcs_service_id'];
}
