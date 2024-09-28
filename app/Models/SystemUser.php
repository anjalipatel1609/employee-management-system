<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class SystemUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'user_type',
        'date_time',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'user_id');
    }
}
