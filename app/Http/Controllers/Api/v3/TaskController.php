<?php

namespace App\Http\Controllers\Api\V3;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V3\TaskResource;

class TaskController extends Controller
{
    /*
    * Display a listing of the resource(tasks).
    * optional parameters:  page_number, per_page, sort_by, sort
    * page_number => Page number of the paginated task list
    * per_page => possible values (10, 25, 50, 100. Defaults value: 10)
    * sort_by => possible values ('id', 'title' or 'due_date'. Defaults value: 'id')
    * sort => possible values ('asc', 'desc'. Default value: 'desc')
    */
    public function index(Request $request)
    {
        // Validate the parameters with specific rules and custom validation error messages
        $validator = Validator::make($request->all(), 
        [
            'per_page' => 'in:10,25,50,100',
            'sort_by' => 'in:id,title,due_date',
            'sort' => 'in:asc,desc', 
        ], 
        [
            'per_page.in' => "The per_page field possible values are: 10, 25, 50, 100. Defaults value: 10",
            'sort_by.in' => "The sort_by field must be either 'id', 'title' or 'due_date'.",
            'sort.in' => "The sort field must be either 'asc' or 'desc'.",
        ]);
        
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 400);
        }

        // Declare the parameters, with default value
        $current_page = $request->input('page_number', 1);
        $per_page = $request->input('per_page', 10);
        $sort_by = $request->input('sort_by', 'id');
        $sort = $request->input('sort', 'desc');

        // Pagination
        $paginator = Task::orderBy($sort_by, $sort)->paginate($per_page, ['*'], 'page', $current_page);
        $tasks = $paginator->getCollection();
        $customMetadata = [
            'current_page' => $paginator->currentPage(),
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'total_pages' => $paginator->lastPage(),
        ];

        return [
            'data' => TaskResource::collection($tasks),
            'meta' => $customMetadata,
        ];
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
            'due_date' => 'after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
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
            '_method' => 'in:PUT',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $task->update($request->all());
            return response()->json($task, 200);
        }
    }

    // Remove the specified resource from storage by ID.
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully.'], 200);
    }
}
