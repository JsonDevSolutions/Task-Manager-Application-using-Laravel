<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TaskController extends Controller
{
    // Display a listing of the resource (tasks).
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    // Display the specified resource by id.
    public function show(Task $task)
    {
        return response()->json($task);
    }

    // Update the specified resource in storage by ID.
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response()->json($task, 200);
    }

    // Remove the specified resource from storage by ID.
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
