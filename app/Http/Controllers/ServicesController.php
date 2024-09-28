<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
/*   models   */
use App\Models\Service;
use App\Models\SubService;
use App\Models\SubServiceTask;

class ServicesController extends Controller
{    

    public function updateService(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([

                'new_sub_services' => 'array', 
                'new_sub_services.*.sub_service_name' => 'nullable|string|max:50',
                'new_sub_services.*.frequency' => 'nullable|string|max:50',
                'new_sub_services.*.new_tasks.*.*' => 'nullable|string|max:70',

                'service_name' => 'required|string|max:20|unique:services,service_name,' . $id,
                'sub_services.*.id' => 'required|exists:sub_services,id',
                'sub_services.*.sub_service_name' => 'required|string|max:50',
                'sub_services.*.frequency' => 'required|string|max:50',
                'sub_services.*.tasks.*.id' => 'nullable|exists:sub_service_tasks,id',
                'sub_services.*.tasks.*.task' => 'required|string|max:70',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();
            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = now()->timezone('Asia/Kolkata')->format('d/m/y h:i:s A');

        if ($request->has('new_sub_services')) {
            foreach ($validatedData['new_sub_services'] as $subServiceData) {
                $subService = SubService::create([
                    'service_id' => $id, 
                    'sub_service_name' => $subServiceData['sub_service_name'],
                    'frequency' => $subServiceData['frequency'],
                    'date_time' => $currentDateTime,
                ]);


                foreach ($subServiceData['new_tasks'] as $taskIndex => $taskData) {
                    foreach ($taskData as $task) {
                        $subService->subServiceTasks()->create([
                            'task' => $task,
                            'date_time' => $currentDateTime,
                        ]);
                    }
                }
               
            }
        }

        $serviceToUpdate = Service::findOrFail($id);

        $serviceToUpdate->update([
            'service_name' => $validatedData['service_name'],
            'date_time' => $currentDateTime,
        ]);

        foreach ($validatedData['sub_services'] as $subServiceData) {
            $subService = SubService::findOrFail($subServiceData['id']);
            $subService->update([
                'sub_service_name' => $subServiceData['sub_service_name'],
                'frequency' => $subServiceData['frequency'],
                'date_time' => $currentDateTime,
            ]);

            if (isset($subServiceData['tasks'])) {
                foreach ($subServiceData['tasks'] as $taskData) {
                    if (isset($taskData['id'])) {
                        $task = SubServiceTask::findOrFail($taskData['id']);
                        $task->update([
                            'task' => $taskData['task'],
                            'date_time' => $currentDateTime,
                        ]);
                    } else {
                        $subService->subServiceTasks()->create([
                            'task' => $taskData['task'],
                            'date_time' => $currentDateTime,
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Service, sub-services, and tasks updated successfully!');
    }

    public function service_C(Request $request)
    {

        try{
            $validatedData = $request->validate([
                'service_name' => 'required|string|max:20|unique:services,service_name',
                'sub_services.*.sub_service_name' => 'required|string|max:50',
                'sub_services.*.frequency' => 'required|string|max:50',
                'sub_services.*.tasks.*.*' => 'required|string|max:70',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            foreach ($request->input('sub_services') as $subService) {
                foreach ($subService['tasks'] as $tasks) {
                    foreach ($tasks as $task) {
                        if (strlen($task) > 70) {
                            $errorMessages[] = "All Task name should be less than 70 characters.";
                            break 3; 
                        }
                    }
                }
            }

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }
    
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');
    
        $service = Service::create([
            'service_name' => $validatedData['service_name'],
            'date_time' => $formattedDateTime,
        ]);
    
        foreach ($validatedData['sub_services'] as $subServiceData) {
            $subService = $service->subServices()->create([
                'sub_service_name' => $subServiceData['sub_service_name'],
                'frequency' => $subServiceData['frequency'],
                'date_time' => $formattedDateTime,
            ]);
    
            foreach ($subServiceData['tasks'] as $taskIndex => $taskData) {
                foreach ($taskData as $task) {
                    $subService->subServiceTasks()->create([
                        'task' => $task,
                        'date_time' => $formattedDateTime,
                    ]);
                }
            }
        }
    
        return redirect()->back()->with('success', 'Service and sub-services added successfully!');
    }  

    public function service_U(Request $request, $id)
    {   
        $service_to_update = Service::find($id);

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        try{
            $validatedData = $request->validate([
                'service_name' => 'required|string|unique:services,service_name,' . $id,
                'description' => 'required',
            ], 
            [
                'service_name.required' => 'Please enter data for service name',
                'service_name.unique' => 'Entered service name is already registered',
                'description.required' => 'Please enter data for service description',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $service_to_update->service_name = $request->input('service_name');
        $service_to_update->description = $request->input('description');
        $service_to_update->date_time = $formattedDateTime;
        $service_to_update->save();
        return redirect()->back()->with('update_success', 'Service updated successfully!');
    }

    public function deactivating_service($id)
    {
        $service_to_deactivate = Service::find($id);
        $service_to_deactivate->is_active = "0";
        $service_to_deactivate->save();

        foreach ($service_to_deactivate->subServices as $subService) {
            $subService->is_active = "0";
            $subService->save();
        }

        return redirect()->route('services')->with('success', 'Service and associated sub-services deactivated successfully');;
    }

    public function activating_service($id)
    {
        $service_to_deactivate = Service::find($id);
        $service_to_deactivate->is_active = "1";
        $service_to_deactivate->save();

        foreach ($service_to_deactivate->subServices as $subService) {
            $subService->is_active = "1";
            $subService->save();
        }

        return redirect()->route('services')->with('success', 'Service and associated sub-services activated successfully');;
    }

    public function service_details($id)
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $service_to_show = Service::with('subServices')->find($id);
        return view('service_details', compact('service_to_show', 'HR__ADMIN__session'));
    }

    public function deleting_sub_service($id)
    {
        $subServiceToDelete = SubService::find($id);
        $subServiceToDelete->delete();
        return redirect()->back()->with('success', 'Sub-service deleted successfully !');
    }

    public function deleting_task($id)
    {
        $TaskToDelete = SubServiceTask::find($id);
        $TaskToDelete->delete();
        return redirect()->back()->with('success', 'Task deleted successfully !');
    }
}
