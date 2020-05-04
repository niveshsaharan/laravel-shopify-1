<?php

namespace Osiset\ShopifyApp\Repositories\Criterias;

use Illuminate\Database\Eloquent\Model;
use Osiset\ShopifyApp\Contracts\EloquentRepository;

/**
 * Base criteria.
 */
abstract class AbstractCriteria
{
    /**
     * Apply criteria to a model through a repository.
     *
     * @param Model              $model      An Eloquent model.
     * @param EloquentRepository $repository An Eloquent repository.
     *
     * @return mixed
     */
    abstract public function apply(Model $model, EloquentRepository $repository);
}
