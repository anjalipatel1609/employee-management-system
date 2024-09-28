<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'CS_id',
        'CS_task_id',
        'entry_date',
        'is_allocated',
        'allocated_date',
        'employee_id',
        'is_completed',
        'completed_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function client_Service()
    {
        return $this->belongsTo(Clients_service::class, 'CS_id');
    }

    public function client_Service_tasks()
    {
        return $this->belongsTo(SubServiceTask::class, 'CS_task_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
