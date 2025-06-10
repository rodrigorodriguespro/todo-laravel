<?php

namespace App\Repositories;

use App\DTOs\TaskDTO;
use App\Models\User;

class TaskRepository {
    public function getAll(User $user, ?string $status = null, int $perPage = 5) {
        $query = $user->tasks();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('deadline')->paginate($perPage);
    }
    public function create(User $user, TaskDTO $dto) {
        return $user->tasks()->create((array) $dto);
    }
}