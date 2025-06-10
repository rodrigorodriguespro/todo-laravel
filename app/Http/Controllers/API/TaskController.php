<?php

namespace App\Http\Controllers\API;

use App\DTOs\TaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Carbon\Carbon;


class TaskController extends Controller {
    public function __construct(private TaskService $service) {}

    public function index(Request $request) {
        return $this->service->list($request->user(), $request->status, 5);
    }

    public function store(StoreUpdateTaskRequest $request) {
        $dto = new TaskDTO(
            $request->input('title'),
            $request->input('description'),
            $request->input('status'),
            $request->input('deadline') ? Carbon::parse($request->input('deadline')) : null
        );
        return $this->service->create($request->user(), $dto);
    }

    public function show(Task $task) {
        return $task;
    }

    public function update(StoreUpdateTaskRequest $request, Task $task) {
        $dto = new TaskDTO(
            $request->input('title'),
            $request->input('description'),
            $request->input('status'),
            $request->input('deadline') ? Carbon::parse($request->input('deadline')) : null
        );
        $task->update((array) $dto);
        return $task;
    }

    public function destroy(Task $task) {
        $task->delete();
        return response()->noContent();
    }
}