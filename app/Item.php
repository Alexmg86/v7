<?php

namespace App;

use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use LaravelSubQueryTrait;
    
    protected $fillable = ['invoice_id', 'price', 'price'];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('price', function (Builder $builder) {
        //     $builder->where('price', '<', 30);
        // });
    }

    public function subitems()
    {
        return $this->hasMany('App\SubItems');
    }
}
