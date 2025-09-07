<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ExportTasksCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $user = User::find($this->userId);
        
        //  FILTRA TASKS SOMENTE DA EMPRESA DO USUÁRIO
        $tasks = Task::where('company_id', $user->company_id)->get();

        $csvFileName = 'tasks_export_' . date('Y-m-d_H-i-s') . '.csv';
        $csvPath = storage_path('app/exports/' . $csvFileName);

        // Garante que o diretório existe
        if (!file_exists(dirname($csvPath))) {
            mkdir(dirname($csvPath), 0755, true);
        }

        $csvFile = fopen($csvPath, 'w');
        fputcsv($csvFile, ['Título', 'Descrição', 'Status', 'Prioridade', 'Data Vencimento']);

        foreach ($tasks as $task) {
            fputcsv($csvFile, [
                $task->title,
                $task->description,
                $task->status,
                $task->priority,
                $task->due_date
            ]);
        }

        fclose($csvFile);
    }
}