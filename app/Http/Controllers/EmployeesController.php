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
use App\Models\clientTask;
use App\Models\task_allocation;

class EmployeesController extends Controller
{
    public function Employee_C(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'employee_name' => 'required|string|max:50',
                'employee_phone' => 'required|numeric|digits:10|unique:employees,employee_phone',

                'employee_email' => 'required|email|max:60|unique:system_users,email',
                'employee_address' => 'required|string|max:150',
                'user_type' => 'required|string',
                'employee_password' => 'required|string|min:8|max:15',
                'employee_confirm_password' => 'required|string|min:8|max:15|same:employee_password',
            ], 
            [
                'employee_name.required' => 'Please enter employee name',
                'employee_phone.required' => 'Please enter employee phone number',
                'employee_email.required' => 'Please enter employee email',
                'employee_address.required' => 'Please enter employee address',
                'employee_password.required' => 'Please enter employee password',
                'employee_confirm_password.required' => 'Please enter employee confirm password',

                'employee_phone.unique' => 'This phone number is already taken, please choose another one !',
                'employee_email.unique' => 'This email address is already taken, please choose another one !',

                'employee_confirm_password.same' => 'The password and confirm password must be the same !',

            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $systemUser = new SystemUser();
        $systemUser->email = $request->input('employee_email');
        $systemUser->password = bcrypt($request->input('employee_password'));
        $systemUser->user_type = $request->input('user_type');
        $systemUser->save();

        $employee = new Employee();
        $employee->user_id = $systemUser->id;
        $employee->employee_name = $request->input('employee_name');
        $employee->employee_email = $request->input('employee_email');
        $employee->employee_phone = $request->input('employee_phone');
        $employee->employee_address = $request->input('employee_address');
        $employee->user_type = $request->input('user_type');
        $employee->employee_password = bcrypt($request->input('employee_password'));
        $employee->employee_confirm_password = $request->input('employee_confirm_password');
        $employee->date_time = $formattedDateTime;

        $employee->save();

        return redirect()->back()->with('success', 'User added successfully !');
    }

    public function employee_U(Request $request, $id)
    {   
        $employee_to_update = Employee::find($id);

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        try{
            $validatedData = $request->validate([
                'employee_name' => 'required|string|max:50',
                'employee_phone' => 'required|numeric|digits:10|unique:employees,employee_phone,' . $id,
                'employee_email' => 'required|email|max:60|unique:system_users,email,' . $id,
                'employee_address' => 'required|string|max:150',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $employee_to_update->employee_name = $request->input('employee_name');
        $employee_to_update->employee_phone = $request->input('employee_phone');
        $employee_to_update->employee_email = $request->input('employee_email');
        $employee_to_update->employee_address = $request->input('employee_address');

        $employee_to_update->date_time = $formattedDateTime;

        $employee_to_update->save();

        $system_user = $employee_to_update->systemUser;
        $system_user->email = $request->input('employee_email'); 
        $system_user->save();

        return redirect()->back()->with('update_success', 'Data updated successfully!');
    }

    public function deactivating_employee($id)
    {
        $employee_to_deactivate = Employee::find($id);
        $employee_to_deactivate->is_active = "0";
        $employee_to_deactivate->save();
        return redirect()->route('employee');
    }

    public function activating_employee($id)
    {
        $employee_to_deactivate = Employee::find($id);
        $employee_to_deactivate->is_active = "1";
        $employee_to_deactivate->save();
        return redirect()->route('employee');
    }

    public function employee_logout(){
        if(Session::has('employee_session')){
            Session::pull('employee_session');
            return redirect('/');
        }
    }

    public function HR__ADMIN__logout(){
        if(Session::has('HR__ADMIN__session')){
            Session::pull('HR__ADMIN__session');
            return redirect('/');
        }
    }

    public function mark_task_as_completed(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'task_completed_remark' => 'required|string|max:50',
            ], 
            [
                'task_completed_remark.max' => 'Remark text must be less than 50 characters',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $task_id = $request->input('task_id');
        $client_task_id = $request->input('client_task_id');
        $remark = $request->input('task_completed_remark');

        $task_record = task_allocation::find($task_id);
        $client_task_record = clientTask::find($client_task_id);

        $task_record->is_completed = "1";
        $task_record->task_completed_remark = $remark;
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $task_record->completed_date = $formattedDateTime;
        $task_record->save();

        $client_task_record->is_completed = "1";
        $client_task_record->save();

        $subServiceId = $client_task_record->CS_id;
        $allTasksCompleted = clientTask::where('CS_id', $subServiceId)
                                        ->where('is_completed', 0)
                                        ->doesntExist();

        if ($allTasksCompleted) {
            $clientService = Clients_service::find($subServiceId);
            $clientService->is_completed = "1";
            $clientService->completed_date = $formattedDateTime;
            $clientService->save();
        }

        return redirect()->back()->with('marked', 'Task marked as completed successfully !');
    }

    public function update_task_approval(Request $request, $id)
    {
        try{
            $validatedData = $request->validate([
                'remark' => 'required|string|max:50',
            ], 
            [
                'remark.max' => 'Remark text must be less than 50 characters',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $task_allocation = task_allocation::find($id);
        
        if(!$task_allocation) {
            return redirect()->back()->with('error', 'Task allocation not found.');
        }
        
        if($request->approval_status == 'approve') {
            $task_allocation->is_approved = 1;
        } elseif($request->approval_status == 'decline') {
            $task_allocation->is_approved = -1;
        } else {
            return redirect()->back()->with('error', 'Invalid approval status.');
        }

        $task_allocation->task_approved_remark = $request->remark;
        
        $task_allocation->save();
        
        return redirect()->back()->with('success', 'Task approval updated successfully.');
    }

    public function not_approving_task($id)
    {
        $task_allocation = task_allocation::find($id);
        
        if(!$task_allocation) {
            return redirect()->back()->with('error', 'Task allocation not found.');
        }
        
        $task_allocation->is_approved = 0;
        $task_allocation->task_approved_remark = null;
        
        $task_allocation->save();
        
        return redirect()->back()->with('success', 'Task approval updated successfully.');
    }

    public function approving_task_again(Request $request,$id)
    {

        try{
            $validatedData = $request->validate([
                'task_approved_remark' => 'required|string|max:50',
            ], 
            [
                'task_approved_remark.max' => 'Remark text must be less than 50 characters',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }
        
        $task_allocation = task_allocation::find($id);
        
        if(!$task_allocation) {
            return redirect()->back()->with('error', 'Task allocation not found.');
        }
        
        $task_allocation->is_approved = 1;
        $task_allocation->task_approved_remark = $request->task_approved_remark;
        
        $task_allocation->save();
        
        return redirect()->back()->with('success', 'Task approval updated successfully.');
    }
}
