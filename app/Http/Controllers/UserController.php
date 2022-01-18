<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEmployeeRequest;
use App\Mail\NotifyRegister;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    // public function index()
    // {
    //     return $this->repository->all();
    // }

    // public function show($id)
    // {
    //     try {
    //         $user = $this->repository->find($id);
    //         if (null == $user) {
    //             return response()->json(['error' =>  'user no found', 'code' => 404], 404);
    //         }
    //         return response()->json(['data' =>  $user, 'code' => 200], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
    //     }
    // }

    // public function store(SaveEmployeeRequest $userRequest)
    // {
    //     try {
    //         $user = $this->repository->create($userRequest->all());

    //         Mail::to($userRequest->get('email'))->queue(new NotifyRegister);
    //         return response()->json(['data' => $user, 'code' => 200], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
    //     }
    // }

    // public function update(Request $userUpdateRequest)
    // {
    //     try {
    //         if ($this->repository->update(request()->all(), request()->get('id'))) {
    //             return response()->json(['error' =>  'Update Correcto', 'code' => 200], 200);
    //         }
    //         return response()->json(['error' =>  'Operacion no realizada. Posible error: user no found', 'code' => 404], 404);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         if (($this->repository->delete($id))) {
    //             return response()->json(['data' =>  'Eliminado Correcto', 'code' => 200], 200);
    //         }
    //         return response()->json(['error' =>  'Operacion no realizada. Posible error: user no found', 'code' => 404], 404);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage(), 'code' => 500], 500);
    //     }
    // }
}
