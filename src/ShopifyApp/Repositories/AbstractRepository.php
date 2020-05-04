<?php

namespace Osiset\ShopifyApp\Repositories;

use Closure;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Osiset\ShopifyApp\Contracts\EloquentCriteria;
use Osiset\ShopifyApp\Contracts\EloquentRepository;
use Osiset\ShopifyApp\Repositories\Criterias\AbstractCriteria;

/**
 * Base repository.
 * Based on: https://github.com/bosnadev/repository
 */
abstract class AbstractRepository implements EloquentRepository, EloquentCriteria
{
    /**
     * App for resolving models in container.
     *
     * @var Application
     */
    protected $app;

    /**
     * The model class.
     *
     * @var Model
     */
    protected $model;

    /**
     * New model instance.
     *
     * @var Model
     */
    protected $newModel;

    /**
     * The criteria for filtering/quering.
     *
     * @var Collection
     */
    protected $criteria;

    /**
     * Skip any loaded criteria.
     *
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * Prevents from overwriting same criteria in chain usage.
     *
     * @var bool
     */
    protected $preventCriteriaOverwriting = true;

    /**
     * Setup.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->criteria = new Collection();
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Specify model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * {@inheritDoc}
     */
    public function all(array $columns = ['*']): Collection
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * Load with relations.
     *
     * @param array $relations The relations to load.
     *
     * @return self
     */
    public function with(array $relations): self
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(int $perPage = 25, array $columns = ['*']): Collection
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Save a model without mass assignment.
     *
     * @param array $data The data to save.
     *
     * @return bool
     */
    public function createWithoutMass(array $data): bool
    {
        foreach ($data as $k => $v) {
            $this->model->$k = $v;
        }

        return $this->model->save();
    }

    /**
     * Save in bulk.
     *
     * @param array $data The model data to save.
     *
     * @return bool
     */
    public function saveBulk(array $data): bool
    {
        return $this->model::insert($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data, string $attr = 'id')
    {
        return $this
            ->model
            ->where($attr, '=', $id)
            ->update($data);
    }

    /**
     * Find and update.
     *
     * @param mixed $id The ID of the model.
     * @param array $data The data to update.
     *
     * @return bool
     */
    public function updateRich($id, array $data): bool
    {
        $model = $this->model->find($id);
        if (!$model) {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id, array $columns = ['*']): ?Model
    {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(string $attribute, $value, array $columns = ['*']): ?Model
    {
        $this->applyCriteria();
        return $this
            ->model
            ->where($attribute, '=', $value)
            ->first($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findAllBy(string $attribute, $value, array $columns = ['*']): Collection
    {
        $this->applyCriteria();
        return $this
            ->model
            ->where($attribute, '=', $value)
            ->get($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function findWhere(array $where, array $columns = ['*'], bool $or = false): ?Collection
    {
        $model = $this->baseFindWhere($where, $or);
        return $model->get($columns);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteBy(string $attribute, $value): bool
    {
        $this->applyCriteria();
        return $this
            ->model
            ->where($attribute, '=', $value)
            ->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteWhere(array $where, bool $or = false): bool
    {
        $model = $this->baseFindWhere($where, $or);
        return $model->delete();
    }

    /**
     * Find by where in.
     *
     * @param string $attribute The attribute to find where in.
     * @param array  $values    The values to find against.
     * @param        $columns   The columns to return.
     *
     * @return Collection|null
     */
    public function findWhereIn(string $attribute, array $values, array $columns = ['*']): ?Collection
    {
        $this->applyCriteria();
        return $this->model->whereIn($attribute, $values)->get($columns);
    }

    /**
     * Make a model.
     *
     * @throws Exception If model is not a model.
     *
     * @return Builder
     */
    public function makeModel(): Model
    {
        return $this->setModel($this->model());
    }

    /**
     * Set model to instantiate.
     *
     * @param string $eloquentModel The model class.
     *
     * @throws Exception If model is not a model.
     *
     * @return Model
     */
    public function setModel($eloquentModel): Model
    {
        $this->newModel = $this->app->make($eloquentModel);
        if (!$this->newModel instanceof Model) {
            throw new Exception("Class {$this->newModel} must be an instance of ".Model::class);
        }

        $this->model = $this->newModel;
        return $this->model;
    }

    /**
     * Reset the criteria.
     *
     * @return self
     */
    public function resetScope(): self
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function skipCriteria($status = true): self
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * {@inheritDoc}
     */
    public function getByCriteria(AbstractCriteria $criteria): self
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function pushCriteria(AbstractCriteria $criteria): self
    {
        if ($this->preventCriteriaOverwriting) {
            // Find existing criteria
            $key = $this->criteria->search(function ($item) use ($criteria) {
                return (is_object($item) && (get_class($item) == get_class($criteria)));
            });

            // Remove old criteria
            if (is_int($key)) {
                $this->criteria->offsetUnset($key);
            }
        }

        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function applyCriteria(): self
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof EloquentCriteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function baseFindWhere(array $where, bool $or = false): ?Collection
    {
        $this->applyCriteria();
        $model = $this->model;

        foreach ($where as $field => $value) {
            if ($value instanceof Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }

        return $model;
    }
}
