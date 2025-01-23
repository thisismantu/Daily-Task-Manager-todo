<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TasksExport implements FromCollection, WithHeadings, WithMapping
{
    protected $user_id;
    protected $start;
    protected $end;

    // Constructor to inject the filters
    public function __construct($user_id = null, $start = null, $end = null)
    {
        $this->user_id = $user_id;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Task::with('user')
            ->when($this->user_id > 0, function ($query) {
                $query->where('user_id', $this->user_id);
            })
            ->when($this->start && $this->end, function ($query) {
                $query->whereBetween('created_at', [$this->start, $this->end]);
            })
            ->latest()
            ->get();
    }

    /**
     * Apply custom mapping for each row.
     *
     * @param  \App\Models\Task  $task
     * @return array
     */
    public function map($task): array
    {
        return [
            $task->user ? $task->user->name : 'No User', // Include user name, fallback to 'No User' if no user
            $task->name,
            $task->task_description,
            $task->created_at,
            $task->updated_at,
        ];
    }

    /**
     * Define the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'User Name',
            'Task Name',
            'Description',
            'Created At',
            'Updated At',
        ];
    }
}
