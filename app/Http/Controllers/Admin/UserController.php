<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{



    public function __construct(protected UserService $userService)
    {
        
    }

    public function index()
{
    // Ao invés de all(), use paginate()
    $users = $this->userService->getAllUsersPerPage(10); // 10 usuários por página
    return view('admin.users.index', compact('users'));
}

    

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $user = $this->userService->createUser($data);
        return redirect()->route('users.index');
    }

    public function edit(string $id)
    {
        // $user = User::where('id', '=', $id)->first();
        // $user = User::where('id', $id)->first(); // ->firstOrFail();
        if (!$user = User::find($id)) {
            return redirect()->route('users.index')->with('message', 'Usuário não encontrado');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->only(['name', 'email']);
        $this->userService->updateUser($id, $data);
        return redirect()->route('users.index');
    }

    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index');
    }

}
