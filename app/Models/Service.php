<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubService;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'date_time',
        'is_active',
    ];

    public function subServices()
    {
        return $this->hasMany(SubService::class, 'service_id');
    }
}
