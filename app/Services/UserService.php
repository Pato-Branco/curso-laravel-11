<?php 

namespace App\Services;
use App\Repositories\UserRepositoryInterface;


class UserService {
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUsersPerPage($perPage) {
        return $this->userRepository->paginate($perPage);   
    }
    public function createUser(array $data) {
    // Lógica de validação ou transformação dos dados
    return $this->userRepository->create($data);
}

public function getUserById($id) {
    return $this->userRepository->find($id);
}
       public function updateUser($id, array $data) {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id) {
        return $this->userRepository->delete($id);
    }
}
