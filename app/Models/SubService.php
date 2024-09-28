<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\SubServiceTask;
use App\Models\Clients_service;

class SubService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'sub_service_name',
        'frequency',
        'date_time',
        'is_active',
    ];

    public function mainService()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function subServiceTasks()
    {
        return $this->hasMany(SubServiceTask::class, 'sub_service_id');
    }

    public function clientsServices()
    {
        return $this->belongsToMany(Clients_service::class, 'clients_services', 'sub_service_id', 'client_id');
    }
}
