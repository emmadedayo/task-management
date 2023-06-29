<?php

namespace App\Repositories;

use App\Helpers\ApiResponse;
use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Api;

class TaskRepository implements TaskInterface
{
    public function getAll()
    {
        $task = Task::with('user')->latest()->get();
        return $task;
        // Implementation for retrieving all tasks
    }

    public function findById($id)
    {
        $task = Task::findOrFail($id);
        return $task;
        // Implementation for retrieving a task by ID
    }

    public function create($request)
    {
        // Implementation for creating a new task using the provided request
        $task = Task::create($request);
        return $task;
    }

    public function edit(Request $request, $id)
    {
        // Implementation for updating a task with the provided ID using the request
        $task = Task::findOrFail($id);
        $task->update($request->validated());
        return $task;
    }

    public function delete($id)
    {
        // Implementation for deleting a task by ID
        $task = $this->findById($id);
        $task->delete();
        return $task;
    }
}
