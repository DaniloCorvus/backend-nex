<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Area;
use App\Models\Role;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->repository = $employeeRepository;
    }

    public function index()
    {

        try {
            return response()->json(['data' => $this->repository->all(), 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function get()
    {

        try {
            return response()->json(['data' =>  $this->repository->get(), 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function show($id)
    {
        try {
            $employee = $this->repository->find($id);
            if (null == $employee) {
                return response()->json(['error' =>  'employee no found', 'code' => 404], 404);
            }
            return response()->json(['data' =>  $employee, 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function forSelect()
    {
        try {
            $employees = $this->repository->forSelect();
            return response()->json(['data' =>  $employees, 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function store(StoreEmployeeRequest $employeeRequest)
    {

        try {
            $employee = $this->repository->create($employeeRequest->all());
            return response()->json(['data' =>  $employee, 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function update(UpdateEmployeeRequest $employeeUpdateRequest, $id)
    {
        try {
            $employee = $this->repository->update($employeeUpdateRequest->all(), $id);
            return response()->json(['data' =>  $employee, 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if (($this->repository->delete($id))) {
                return response()->json(['data' =>  'Eliminado Correcto', 'code' => 200], 200);
            }
            return response()->json(['error' =>  'Operacion no realizada. Posible error: employee no found', 'code' => 404], 404);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }

    public function areas()
    {

        try {
            return response()->json(['data' =>  Area::all(), 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }
    public function roles()
    {

        try {
            return response()->json(['data' =>  Role::all(), 'code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
        }
    }
}
