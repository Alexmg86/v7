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

    protected $appends = ['method', 'url', 'request', 'headers'];

    public function getMethodAttribute()
    {
        $body = json_decode($this->body);
        return $body->method ?? 'GET';
    }

    public function getUrlAttribute()
    {
        $body = json_decode($this->body);
        return $body->url ?? 'https://laravel.com';
    }

    public function getRequestAttribute()
    {
        $body = json_decode($this->body);
        return $body->body ?? [];
    }

    public function getHeadersAttribute()
    {
        $body = json_decode($this->body);
        return $body->headers ?? [];
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = json_encode($value);
    }
}
