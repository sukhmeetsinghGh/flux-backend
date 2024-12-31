<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse;

    public function store(CreateTaskRequest $request)
    {
        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->completed ?? false,
            'todo_list_id' => $request->list_id ?? null, 
        ]);

        return $this->sendResponse($task, 'Task created successfully.', Response::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, $taskId)
    {
        $task = auth()->user()->tasks()->findOrFail($taskId);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->completed ?? $task->completed,
        ]);

        return $this->sendResponse($task, 'Task updated successfully.');
    }

    public function destroy($taskId)
    {
        $task = auth()->user()->tasks()->findOrFail($taskId);

        $task->delete();

        return $this->sendResponse([], 'Task deleted successfully.');
    }

    public function markAsCompleted(Request $request, $taskId)
    {
        $task = auth()->user()->tasks()->findOrFail($taskId);

        $task->update(['completed' => $request->get('completed')]);
        $msg = $request->get('completed')=== true ? 'completed' : 'in-complete';

        return $this->sendResponse($task, 'Task marked as '.$msg.'.');
    }

    public function index()
    {
        $tasks = auth()->user()->tasks()->get();

        return $this->sendResponse($tasks, 'All tasks fetched successfully.');
    }

    public function show($taskId)
    {
        $task = auth()->user()->tasks()->findOrFail($taskId);

        return $this->sendResponse($task, 'Task details fetched successfully.');
    }
}
