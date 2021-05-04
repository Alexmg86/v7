<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiProject extends Model
{
    protected $table = 'apitester_project';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $with = ['folders', 'items'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($project) {
            $project->folders()->delete();
            $project->items()->delete();
        });
    }

    public function folders()
    {
        return $this->hasMany('App\Models\ApiFolder', 'project_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\ApiItem', 'project_id', 'id')->whereNull('folder_id');
    }
}
