<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SystemUser;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_name',
        'employee_email',
        'employee_phone',
        'employee_address',
        'user_type',
        'employee_password',
        'employee_confirm_password',
    ];

    public function systemUser()
    {
        return $this->belongsTo(SystemUser::class, 'user_id');
    }
}
