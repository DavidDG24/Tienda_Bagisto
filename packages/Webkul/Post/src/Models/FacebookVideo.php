<?php

namespace Webkul\Post\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookVideo extends Model
{
    protected $table = 'facebook_videos';

    protected $fillable = [
        'video_path',
        'description',
        'publish_time',
        'status',
    ];

    /**
     * Define el valor por defecto para la propiedad 'status' como 'pendiente'.
     */
    protected $attributes = [
        'status' => 'pendiente',
    ];
}
