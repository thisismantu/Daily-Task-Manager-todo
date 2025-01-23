<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\TasksExport;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tasks = Task::with('user')
                ->when($request->user_id > 0, function ($query) use ($request) {
                    $query->where('user_id', $request->user_id);
                })
                ->when($request->has('start') && $request->has('end'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->start, $request->end]);
                })
                ->latest()
                ->get();

            return view('theme.task.task-list', compact('tasks'));
        }

        $Users = User::get();
        return view('theme.task.list', compact('Users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Task::create($request->all());
        return response()->json(['success' => true, 'msg' => 'New Task Assigned Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Task::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        $task->update($request->all());
        return response()->json(['success' => true, 'msg' => 'Task updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     *
     * Export Task
     * @return mixed
     */
    public function ExportTask(Request $request)
    {
        $user_id = $request->user_id ?? null;
        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // Trigger the export with the filters
        return Excel::download(new TasksExport($user_id, $start, $end), 'tasks.xlsx');
    }
}
