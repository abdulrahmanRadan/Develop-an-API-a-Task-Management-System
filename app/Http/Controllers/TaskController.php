<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return $task;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'status' => 'string|in:pending,in_progress,completed',
            'due_date' => 'date|nullable',
            'assigned_user_id' => 'exists:users,id|nullable',
        ]);

        $task = Task::create($request->all());

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string|nullable',
            'status' => 'string|in:pending,in_progress,completed',
            'due_date' => 'date|nullable',
            'assigned_user_id' => 'exists:users,id|nullable',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

    public function assignUser(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'assigned_user_id' => 'exists:users,id|nullable',
        ]);

        $task->assigned_user_id = $request->assigned_user_id;
        $task->save();

        return response()->json($task);
    }
}
