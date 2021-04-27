<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiFolder extends Model
{
    protected $table = 'apitester_folder';

    protected $fillable = ['project_id', 'name'];

    protected $with = ['items'];

    public function items()
    {
        return $this->hasMany('App\Models\ApiItem');
    }
}
