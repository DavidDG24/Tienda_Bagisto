<?php

namespace Webkul\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookSetting extends Model
{
    protected $filable=['page_id','access_token','default_message','status'];

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = encrypt($value);
    }
    public function getAccessTokenAttribute($value)
    {
        return decrypt($value);
    }
}
