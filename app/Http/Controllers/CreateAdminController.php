<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

/*   models   */
use App\Models\Employee;
use App\Models\SystemUser;
use App\Models\Service;
use App\Models\Clients_service;
use App\Models\task_allocation;

class CreateAdminController extends Controller
{

    public function createAdmin()
    {
        try {
            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Kolkata');
            $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');
    
            $systemUser = new SystemUser();
            $systemUser->email = "Neel9042@gmail.com";
            $systemUser->password = bcrypt("ADMIN");
            $systemUser->user_type = "ADMIN";
            $systemUser->save();
    
            $employee = new Employee();
            $employee->user_id = $systemUser->id;
            $employee->employee_name = "ADMIN NEEL";
            $employee->employee_email = $systemUser->email;
            $employee->employee_phone = "9999999999";
            $employee->employee_address = "dummy address";
            $employee->user_type = $systemUser->user_type;
            $employee->employee_password = $systemUser->password;
            $employee->employee_confirm_password = "ADMIN";
            $employee->date_time = $formattedDateTime;
    
            $employee->save();
    
            return redirect()->route('index')->with('adminCreatedMsg', 'Admin created successfully!');
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) {
                return redirect()->route('index')->with('adminCreatedMsg', 'Please do not try to mess with high access area !');
            } else {
                return redirect()->route('index')->with('adminCreatedMsg', 'Admin creation failed. Please try again later.');
            }
        }
    }
    
}
