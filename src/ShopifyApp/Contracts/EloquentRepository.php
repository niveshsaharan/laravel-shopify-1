<?php

namespace Osiset\ShopifyApp\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Reprecents an Eloquent repository.
 */
interface EloquentRepository
{
    /**
     * @param array $columns The columns to return.
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Paginate the results.
     *
     * @param int   $perPage How many per page.
     * @param array $columns The columns to return.
     *
     * @return Collection
     */
    public function paginate(int $perPage = 1, array $columns = ['*']): Collection;

    /**
     * Create a model with mass assignment.
     *
     * @param array $data The data to create with.
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a model.
     *
     * @param mixed  $id   The ID of the model.
     * @param array  $data The data to update.
     * @param string $attr The attribute the ID is for.
     *
     * @return mixed
     */
    public function update($id, array $data, string $attr = 'id');

    /**
     * Delete the model.
     *
     * @param int $id The ID of the model.
     *
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Find by ID.
     *
     * @param int   $id      The ID of the model.
     * @param array $columns The columns to return.
     *
     * @return Model|null
     */
    public function find(int $id, array $columns = ['*']): ?Model;

    /**
     * Find by column.
     *
     * @param string $attribute The column to find by.
     * @param mixed  $value     The value the column must be.
     * @param array  $columns   The columns to return.
     *
     * @return Model|null
     */
    public function findBy(string $attribute, $value, array $columns = ['*']): ?Model;

    /**
     * Find all by column.
     *
     * @param string $attribute The column to find by.
     * @param mixed  $value     The value the column must be.
     * @param array  $columns   The columns to return.
     *
     * @return Collection
     */
    public function findAllBy(string $attribute, $value, array $columns = ['*']): Collection;

    /**
     * Find where.
     *
     * @param array $where   The conditions to find by.
     * @param array $columns The columns to return.
     * @param bool  $or      The where is of OR not AND (default: AND)
     *
     * @return Collection|null
     */
    public function findWhere(array $where, array $columns = ['*'], bool $or = false): ?Collection;

    /**
     * Delete by column.
     *
     * @param string $attribute The column to find by.
     * @param mixed  $value     The value the column must be.
     *
     * @return bool
     */
    public function deleteBy(string $attribute, $value): bool;

    /**
     * Delete where.
     *
     * @param array $where The conditions to find by.
     * @param bool  $or    The where is of OR not AND (default: AND)
     *
     * @return bool
     */
    public function deleteWhere(array $where, bool $or = false): bool;
}
