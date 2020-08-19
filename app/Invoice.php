<?php

namespace App;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Invoice extends Model
{
    use LaravelSubQueryTrait;

    protected $fillable = ['name'];

    protected $appends = [
        'full'
    ];

    // protected $withCount = 'items';

    // protected $withSum = ["items:price"];

    public function items()
    {
        return $this->hasMany('App\Item');
    }

    public function goods()
    {
        return $this->belongsToMany('App\Good');
    }

    public function getFullAttribute()
    {
        return $this->name;
    }
}
