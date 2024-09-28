<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients_service extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'sub_service_id',
        'starting_period',
        'entry_date',
        'is_allocated',
        'allocated_date',
        'employee_id',
        'is_completed',
        'completed_date',
        'payment_amount',
        'payment_status',
        'bill_number',
        'is_invoice_generated',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function SubServiceTaken()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function clientTasks()
    {
        return $this->hasMany(clientTask::class, 'CS_id');
    }
}
