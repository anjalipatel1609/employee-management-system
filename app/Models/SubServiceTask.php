<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubService;

class SubServiceTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_service_id',
        'task',
        'date_time',
        'is_active',
    ];

    public function mainSubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }
}
