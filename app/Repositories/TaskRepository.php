<?php

namespace App\Repositories;

use App\DTOs\TaskDTO;
use App\Models\User;

class TaskRepository {
    public function getAll(User $user, ?string $status = null) {
        return $user->tasks()
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('deadline')
            ->paginate(10);
    }
    public function create(User $user, TaskDTO $dto) {
        return $user->tasks()->create((array) $dto);
    }
}