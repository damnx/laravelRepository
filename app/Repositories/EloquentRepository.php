<?php
namespace App\Repositories;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($columns = array('*'))
    {
        return $this->_model->all($columns);
    }

    /**
     * Get one
     * @param $limit number
     * @param $columns array
     * @return mixed
     */
    public function paginate($limit = null, $columns = array('*'))
    {
        $limit = is_null($limit) ? config('constants.limit') : $limit;
        $results = $this->_model->paginate($limit, $columns);
        return $results;
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        $result = $this->_model->find($id, $columns);
        return $result;
    }

    /**
     * Get one
     * @param $field
     * @param $value
     * @param $columns array
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = array('*'))
    {
        $result = $this->_model->where($field, '=', $value)->get($columns);
        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $result = $this->_model->create($attributes);
        return $result;
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    public function with($relations)
    {
        $this->_model = $this->_model->with($relations);
        return $this;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
            return $result;
        }

        return false;
    }
}
