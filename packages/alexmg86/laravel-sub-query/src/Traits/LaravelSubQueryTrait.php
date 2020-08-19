<?php

namespace Alexmg86\LaravelSubQuery\Traits;

use Alexmg86\LaravelSubQuery\Collection\LaravelSubQueryCollection;
use Alexmg86\LaravelSubQuery\LaravelSubQuery;

trait LaravelSubQueryTrait
{
    /**
     * Eager load relation sums on the model.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function loadSum($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;

        $this->newCollection([$this])->loadSum($relations);

        return $this;
    }

    /**
     * Eager load relation min value on the model.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function loadMin($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;

        $this->newCollection([$this])->loadMin($relations);

        return $this;
    }

    /**
     * Eager load relation max value on the model.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function loadMax($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;

        $this->newCollection([$this])->loadMax($relations);

        return $this;
    }

    /**
     * Eager load relation max value on the model.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function loadAvg($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;

        $this->newCollection([$this])->loadAvg($relations);

        return $this;
    }

    /**
     * Eager load latest relation on the model.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function loadOneLatest($relations)
    {
        return $this->newCollection([$this])->loadOneLatest($relations);
    }

    /**
     * Eager load oldest relation on the model.
     *
     * @param  array|string  $relations
     * @return $this
     */
    public function loadOneOldest($relations)
    {
        return $this->newCollection([$this])->loadOneOldest($relations);
    }

    public function newEloquentBuilder($builder)
    {
        $newEloquentBuilder = new LaravelSubQuery($builder);
        $newEloquentBuilder->setModel($this);

        if (isset($this->withSum)) {
            $newEloquentBuilder->setWithSum($this->withSum);
        }

        if (isset($this->withMin)) {
            $newEloquentBuilder->setWithMin($this->withMin);
        }

        if (isset($this->withMax)) {
            $newEloquentBuilder->setWithMax($this->withMax);
        }

        if (isset($this->withAvg)) {
            $newEloquentBuilder->setWithAvg($this->withAvg);
        }

        if (isset($this->withOneOldest)) {
            $newEloquentBuilder->setWithOneOldest($this->withOneOldest);
        }

        if (isset($this->withOneLatest)) {
            $newEloquentBuilder->setWithOneLatest($this->withOneLatest);
        }

        return $newEloquentBuilder;
    }

    public function newCollection(array $models = [])
    {
        return new LaravelSubQueryCollection($models);
    }
}