<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clients_service;
use App\Models\clientTask;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'phone',
        'email',
        'date_time',
        'is_active',
    ];

    public function services()
    {
        return $this->hasMany(Clients_service::class, 'client_id');
    }

    public function task()
    {
        return $this->hasMany(clientTask::class, 'client_id');
    }
}
