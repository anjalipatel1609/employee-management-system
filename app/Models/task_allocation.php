<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\clientTask;

class task_allocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'employee_id',
        'allocated_date',
        'deadLine',
        'is_completed',
        'completed_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function ClientsTasks()
    {
        return $this->belongsTo(clientTask::class, 'task_id');
    }
}
