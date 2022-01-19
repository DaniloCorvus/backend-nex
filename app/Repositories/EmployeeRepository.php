<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Facades\File;

class EmployeeRepository
{
    protected $model;

    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function all()
    {
        return $this->model->with(['area', 'roles' => function ($q) {
            $q->select('id');
        }])->paginate(10, ['*'], 'page', request()->get('page', 1));
    }

    public function get()
    {
        return $this->model->get(['name', 'id']);
    }

    public function create(array $data)
    {
        $this->model->nombre = $data['name'];
        $this->model->email = $data['email'];
        $this->model->sexo = $data['sex'];
        $this->model->area_id = 1;
        $this->model->boletin = $data['news'];
        $this->model->descripcion = $data['description'];
        $this->model->save();
        return $this->model;
    }

    public function update(array $data, $id)
    {
        $employee = $this->model->firstWhere('id', $id);
        $employee->nombre = $data['name'];
        $employee->email = $data['email'];
        $employee->sexo = $data['sex'];
        $employee->area_id = $data['area'];
        $employee->boletin = $data['news'];
        $employee->descripcion = $data['description'];
        $employee->update();

        $this->assingRol($employee);

        return $employee;
    }

    public function assingRol($employee)
    {
        $employee->roles()->detach();
        $employee->roles()->attach(request()->get('rol'));
    }

    public function forSelect()
    {
        return $this->model->get(['id', 'name']);
    }

    public function delete($id)
    {
        $employee = $this->find($id);
        return $this->model->destroy($id);
    }

    public function disponibility($id)
    {
        $employee = $this->find($id);
        return $employee->limit;
    }

    public function find($id)
    {
        $employee = $this->model->find($id);
        return $employee;
    }
}
