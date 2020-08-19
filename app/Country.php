<?php

namespace App;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use LaravelSubQueryTrait;

    protected $fillable = ['name'];

    /**
     * Get all of the posts for the country.
     */
    public function posts()
    {
        return $this->hasManyThrough('App\Post', 'App\Customer', 'country_id', 'user_id', 'id', 'id');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }
}
