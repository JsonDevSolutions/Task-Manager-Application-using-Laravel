<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // Display a listing of the resource(tasks).
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    /*
    * Store a newly created resource in storage.
    * Title should not be Empty and should not exceed 10 characters.
    * Due Date should be a valid date in the future
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:10',
            'due_date' => 'date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $task = Task::create($request->all());
            return response()->json($task, 201);
        }
    }

    // Display the specified resource.
    public function show(Task $task)
    {
        return response()->json($task);
    }

    /*
    * Update the specified resource in storage by ID.
    * Title should not be Empty and should not exceed 10 characters.
    * Due Date should be a valid date in the future
    */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:10',
            'due_date' => 'date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $task->update($request->all());
            return response()->json($task, 200);
        }
    }

    // Remove the specified resource from storage by ID.
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
