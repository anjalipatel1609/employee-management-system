<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients_service;
use App\Models\clientTask;
use App\Models\Client;
use App\Models\Employee;
use App\Models\task_allocation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class TaskAllocationController extends Controller
{
    public function single_client_task_allocation($id)
    {
        $client = Client::where('id', $id)->first();
        $Clients_service = Clients_service::where('client_id', $id)->where('is_completed', "0")->get();
        
        $ClientsTasks = clientTask::where('client_id', $id)->where('is_completed', "0")->get();

        $allClient = Client::where('is_active', "1")->get();
        $allEmployee = Employee::where('is_active', 1)->where('user_type', '!=', 'ADMIN')->get();

        $clientsWithUnallocatedTasks = Client::whereHas('task', function($query) {
            $query->where('is_allocated', 0);
        })->where('is_active', 1)->get();

        $clientsWithIncompleteTasks = Client::whereHas('task', function($query) {
            $query->where('is_completed', 0);
        })->where('is_active', 1)->get();

        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        return view('single_client_task_allocation', compact('client', 'ClientsTasks','Clients_service', 'allClient', 'allEmployee', 'clientsWithUnallocatedTasks', 'clientsWithIncompleteTasks', 'HR__ADMIN__session'));
    }

    public function allocating_task(Request $request)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $Task_allocation = new task_allocation();
        $Task_allocation->task_id = $request->input('task_id');
        $Task_allocation->employee_id = $request->input('employee_id');
        $Task_allocation->allocated_date = $formattedDateTime;
        $Task_allocation->deadLine = $request->input('deadLine');
        $Task_allocation->save();


        $task_id = $request->input('task_id');
        $task_to_update = clientTask::where('id', $task_id)->first();
        $task_to_update->is_allocated = "1";
        $task_to_update->allocated_date = $formattedDateTime;
        $task_to_update->employee_id = $request->input('employee_id');
        $task_to_update->save();

        $subServiceId = $task_to_update->CS_id;
        $allTasksAllocated = clientTask::where('CS_id', $subServiceId)
                                        ->where('is_allocated', 0)
                                        ->doesntExist();

        if ($allTasksAllocated) {
            $clientService = Clients_service::find($subServiceId);
            $clientService->is_allocated = "1";
            $clientService->allocated_date = $formattedDateTime;
            $clientService->save();
        }

        return redirect()->back()->with('success', 'Task allocated successfully !');
    }

    public function reallocating_task(Request $request)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $task_id = $request->input('task_id');
        $record_to_update = task_allocation::where('task_id', $task_id)->first();

        $record_to_update->employee_id = $request->input('employee_id');
        $record_to_update->task_id = $request->input('task_id');
        $record_to_update->allocated_date = $formattedDateTime;
        $record_to_update->deadLine = $request->input('deadLine');
        $record_to_update->save();

        $task_to_update = clientTask::where('id', $task_id)->first();
        $task_to_update->is_allocated = "1";
        $task_to_update->allocated_date = $formattedDateTime;
        $task_to_update->employee_id = $request->input('employee_id');
        $task_to_update->save();

        $subServiceId = $task_to_update->CS_id;
        $allTasksAllocated = clientTask::where('CS_id', $subServiceId)
                                        ->where('is_allocated', 0)
                                        ->doesntExist();

        if ($allTasksAllocated) {
            $clientService = Clients_service::find($subServiceId);
            $clientService->is_allocated = "1";
            $clientService->allocated_date = $formattedDateTime;
            $clientService->save();
        }

        return redirect()->back()->with('success', 'Task reallocated successfully !');
    }
}
