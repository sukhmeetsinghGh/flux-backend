<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateListRequest;
use App\Http\Requests\UpdateListRequest;
use App\Models\TodoList;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $lists = auth()->user()->todoLists()->with('tasks')->get();
        return $this->sendResponse($lists, 'Lists retrieved successfully.');
    }

    public function store(CreateListRequest $request)
    {
        $list = auth()->user()->todoLists()->create([
            'name' => $request->name
        ]);
        return $this->sendResponse($list, 'List created successfully.', Response::HTTP_CREATED);
    }

    public function update(UpdateListRequest $request, $id)
    {
        $list = auth()->user()->todoLists()->findOrFail($id);
        $list->update(['name' => $request->name]);

        return $this->sendResponse($list, 'List updated successfully.');
    }

    public function destroy($id)
    {
        $list = auth()->user()->todoLists()->findOrFail($id);
        $list->delete();

        return $this->sendResponse([], 'List deleted successfully.');
    }

      public function getTasksForList($listId)
    {
        $list = auth()->user()->todoLists()->find($listId);

        if (!$list) {
            return $this->sendError('Todo list not found or you do not have access to it.', [], 404);
        }

        $tasks = $list->tasks; // Assuming there is a 'tasks' relationship defined in the TodoList model

        return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
    }
}
