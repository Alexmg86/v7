<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiFolder extends Model
{
    protected $table = 'apitester_folder';

    protected $fillable = ['project_id', 'name'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany('App\Models\ApiItem', 'folder_id');
    }
}
