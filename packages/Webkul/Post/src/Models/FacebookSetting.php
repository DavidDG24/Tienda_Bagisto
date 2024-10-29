<?php

namespace Webkul\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookSetting extends Model
{
    protected $fillable=['page_id','access_token','default_message','status'];

    
}
