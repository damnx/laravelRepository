<?php
namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @param $columns array mặc định lấy tất cả
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * Get one
     * @param $limit number măc định lấy constants limit
     * @param $columns array mặc định lấy tất cả
     * @return mixed
     */
    public function paginate($limit = null, $columns = array('*'));

    /**
     * Get one
     * @param $field
     * @param $value string mặc định null
     * @param $columns array mặc định lấy tất cả
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = array('*'));

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    public function with($relations);
    
    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
