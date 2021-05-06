<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiItem extends Model
{
    protected $table = 'apitester_item';

    protected $fillable = [
        'folder_id',
        'project_id',
        'name',
        'body'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['method', 'url'];

    public function getMethodAttribute()
    {
        return 'GET';
    }

    public function getUrlAttribute()
    {
        return 'https://laravel.com';
    }
}
