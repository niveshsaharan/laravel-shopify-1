<?php

namespace Osiset\ShopifyApp\Contracts;

use Osiset\ShopifyApp\Storage\Repositories\Criterias\AbstractCriteria;

/**
 * Reprecents criteria for ELoquent filtering/quering.
 */
interface EloquentCriteria
{
    /**
     * Skip the criteria?
     *
     * @param bool $status
     *
     * @return self
     */
    public function skipCriteria($status = true);

    /**
     * Get the criteria.
     *
     * @return mixed
     */
    public function getCriteria();

    /**
     * Get the criteria by.
     *
     * @param AbstractCriteria $criteria
     *
     * @return self
     */
    public function getByCriteria(AbstractCriteria $criteria);

    /**
     * Add criteria.
     *
     * @param AbstractCriteria $criteria
     *
     * @return self
     */
    public function pushCriteria(AbstractCriteria $criteria);

    /**
     * Apply the criteria.
     *
     * @return self
     */
    public function applyCriteria();
}
