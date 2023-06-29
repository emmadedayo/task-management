<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public $taskRepository;

    public function __construct(TaskRepository $taskRepository){
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = $this->taskRepository->getAll();
            return ApiResponse::success($tasks, 'Tasks retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to get tasks', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            //add user auth id to $request->validated()
            $request->validated()['user_id'] == '1';
            $task = $this->taskRepository->create($request->validated());
            // Commit the transaction
            DB::commit();
            return ApiResponse::success($task, 'Task created successfully', 201);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();
            return ApiResponse::error('Failed to create task'.$e, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            if (empty($id)) {
                return ApiResponse::error('Invalid task ID', 400);
            }
            $task = $this->taskRepository->findById($id);
            return ApiResponse::success($task, 'Task retrieved successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to get task', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, $id)
    {
        try {
            if (empty($id)) {
                return ApiResponse::error('Invalid task ID', 400);
            }
            // Begin a database transaction
            DB::beginTransaction();
            $task = $this->taskRepository->edit($request, $id);
            // Commit the transaction
            DB::commit();
            return ApiResponse::success($task, 'Task updated successfully', 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();
            return ApiResponse::error('Failed to update task', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (empty($id)) {
                return ApiResponse::error('Invalid task ID', 400);
            }
            // Begin a database transaction
            $task = $this->taskRepository->delete($id);
            // Commit the transaction
            return ApiResponse::successTwo('Task deleted successfully', 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            return ApiResponse::error('Failed to delete task', 500);
        }
    }
}

