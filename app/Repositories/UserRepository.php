<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all()
    {
        return $this->model->with(['company' => function ($q) {
            $q->select('name', 'id');
        }])->paginate(10, ['*'], 'page', request()->get('page', 1));
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->firstWhere('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        $user = $this->model->find($id);
        return $user;
    }
}
