<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiProject extends Model
{
    protected $table = 'apitester_project';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $with = ['folders'];

    public function folders()
    {
        return $this->hasMany('App\Models\ApiFolder', 'project_id');
    }
}
