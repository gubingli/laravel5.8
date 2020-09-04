<?php
namespace App\Facades\Repositories;

use App\Facades\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;

abstract class Repository implements RepositoryInterface
{
    protected $app;


    protected $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract public function model();

    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->model->select($columns)->get();
    }
    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->select($columns)->find($id, 1);
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->model->select($columns)->where($field, $value)->get();
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
    }

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $this->model = new $this->model;

        return $this->model->fill($attributes)->save();
    }
    
    public function createGetId(array $attributes)
    {
        $this->model = new $this->model;
        return $this->model->insertGetId($attributes);
    }
    
    public function activitycreate(array $attributes)
    {
        if (!empty($attributes['release_date'])) {
            $attributes['release_date'] = strtotime($attributes['release_date']);
        }
        $this->model = new $this->model;
        return $this->model->fill($attributes)->save();
    }
    
    public function activitycreateGetId(array $attributes)
    {
        if (!empty($attributes['release_date'])) {
            $attributes['release_date'] = strtotime($attributes['release_date']);
        }
        $this->model = new $this->model;
        return $this->model->fill($attributes)->insertGetId($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->model->fill($attributes);
        return $this->model->save();
    }
    
    public function activityupdate(array $attributes, $id)
    {
        if (!empty($attributes['release_date'])) {
            $attributes['release_date'] = strtotime($attributes['release_date']);
        }
        
        $this->model = $this->model->findOrFail($id);
        $this->model->fill($attributes);
        return $this->model->save();
    }

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }
    
    /**
     * Order collection by a given column
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
    }
    
    /**
     * Load relations
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations)
    {
    }
}
