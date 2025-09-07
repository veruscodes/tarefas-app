<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task->load('user');
    }

    public function build()
    {
        return $this->subject('Nova tarefa criada')
                    ->view('emails.task_created');
    }
}
