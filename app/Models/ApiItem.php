<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiItem extends Model
{
    protected $table = 'apitester_item';

    protected $fillable = ['folder_id', 'name', 'body'];
}
