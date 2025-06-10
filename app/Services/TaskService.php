<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Models\User;
use App\Repositories\TaskRepository;

class TaskService {
    public function __construct(private TaskRepository $repo) {}

    public function list(User $user, ?string $status) {
        return $this->repo->getAll($user, $status);
    }

    public function create(User $user, TaskDTO $dto) {
        return $this->repo->create($user, $dto);
    }
}