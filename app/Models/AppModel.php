<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    protected $table = 'apps';
    protected $fillable = ['title','type','whmcs_user_id'];
}
