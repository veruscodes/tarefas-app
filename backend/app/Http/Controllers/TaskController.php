<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // RETORNA SOMENTE TASKS DA EMPRESA DO USUÁRIO LOGADO
        $user = auth()->user();
        return Task::where('company_id', $user->company_id)->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date'
        ]);

        // ADICIONA company_id AUTOMATICAMENTE
        $validated['company_id'] = auth()->user()->company_id;
        $validated['user_id'] = auth()->id();

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
{
    if ($task->company_id !== auth()->user()->company_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $validated = $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'sometimes|required|in:pending,in_progress,done',
        'priority' => 'sometimes|required|in:low,medium,high',
        'due_date' => 'nullable|date'
    ]);

    $task->update($validated);
    return response()->json($task);
}

    public function destroy(Task $task)
    {
        // VERIFICA SE A TASK PERTENCE À EMPRESA DO USUÁRIO
        if ($task->company_id !== auth()->user()->company_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}