<?php
namespace App\Repositories\Post;

use App\Models\PostModel;
use App\Repositories\EloquentRepository;

class PostEloquentRepository extends EloquentRepository implements PostRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return PostModel::class;
    }

    /**
     * Get all posts only published
     * @return mixed
     */
    public function getAllPublished()
    {
        $result = $this->_model->where('is_published', 1)->get();

        return $result;
    }

    /**
     * Get post only published
     * @param $id int Post ID
     * @return mixed
     */
    public function findOnlyPublished($id)
    {
        $result = $this
            ->_model
            ->where('id', $id)
            ->where('is_published', 1)
            ->first();

        return $result;
    }
}
