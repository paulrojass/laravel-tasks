<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "status" => true,
            "tasks" => Task::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "text" => "required|string",
            "category_id" => "required"
        ]);

        $task = new Task;
        $task->text = $request->text;
        $task->category_id = $request->category_id;
        $task->save();

        return response()->json([
            "status" => true,
            "message" => "Tarea creada exitosamente",
            "task" => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            "text" => "required|string",
            "category_id" => "required"
        ]);

        $task = Task::where("id", $id)->first();

        if (!empty($task)) {
            $task->text = $request->text;
            $task->category_id = $request->category_id;
            $task->update();
        } else {
            return response()->json([
                "status" => false,
                "message" => "No existe el registro",
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Tarea editada exitosamente",
            "task" => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function markFinished(Request $request, $id)
    {
        $task = Task::where("id", $id)->first();

        if (!empty($task)) {
            $task->finished = $request->finished;
            $task->update();
        } else {
            return response()->json([
                "status" => false,
                "message" => "No existe el registro",
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Tarea editada exitosamente",
            "task" => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::where("id", $id)->first();
        if (!empty($task)) {
            $task->delete();
        } else {
            return response()->json([
                "status" => false,
                "message" => "No existe el registro",
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Tarea eliminada exitosamente",
            "task" => $task
        ]);
    }
}

