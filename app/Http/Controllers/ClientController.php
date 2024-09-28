<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Client;
use App\Models\Clients_service;
use App\Models\clientTask;
use App\Models\Service;
use App\Models\SubService;
use App\Models\SubServiceTask;
use PDF;

class ClientController extends Controller
{
    public function client_C(Request $request)
    {

        try{
            $validatedData = $request->validate([
                'client_name' => 'required|string|max:50',
                'phone' => 'required|numeric|digits:10|unique:clients,phone',
                'email' => 'required|email|max:60|unique:clients,email',
                'sub_service_id.*' => 'required|string|max:25',
                'starting_period.*' => 'required|string|max:100',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $client = new Client();
        $client->client_name = $validatedData['client_name'];
        $client->phone = $validatedData['phone'];
        $client->email = $validatedData['email'];
        $client->date_time = $formattedDateTime;
        $client->save();

        foreach ($request->sub_service_id as $key => $SubServiceID) {
            $clientService = new Clients_service();
            $clientService->client_id = $client->id;
            $clientService->sub_service_id = $SubServiceID;
            $clientService->starting_period = $validatedData['starting_period'][$key];
            $clientService->entry_date = $formattedDateTime;
            $clientService->save();

            $tasks = SubServiceTask::where('sub_service_id', $SubServiceID)->get();

            foreach ($tasks as $task) {
                $clientTask = new ClientTask();
                $clientTask->client_id = $client->id;
                $clientTask->CS_id = $clientService->id;
                $clientTask->CS_task_id = $task->id;
                $clientTask->entry_date = $formattedDateTime;

                $clientTask->save();
            }

        }

        return redirect()->back()->with('success', 'Client information stored successfully!');
    }

    public function client_U(Request $request, $id)
    {   
        $client_to_update = Client::find($id);

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        try{
            $validatedData = $request->validate([
                'client_name' => 'required|string|max:255',
                'phone' => 'required|numeric|digits:10|unique:clients,phone,' . $id,
                'email' => 'required|email|max:255|unique:clients,email,' . $id,
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $client_to_update->client_name = $request->input('client_name');
        $client_to_update->phone = $request->input('phone');
        $client_to_update->email = $request->input('email');

        $client_to_update->date_time = $formattedDateTime;
        $client_to_update->save();

        return redirect()->back()->with('update_success', 'Client data updated successfully!');
    }

    public function deactivating_client($id)
    {
        $client_to_deactivate = Client::find($id);
        $client_to_deactivate->is_active = "0";
        $client_to_deactivate->save();
        return redirect()->route('client');
    }

    public function activating_client($id)
    {
        $client_to_deactivate = Client::find($id);
        $client_to_deactivate->is_active = "1";
        $client_to_deactivate->save();
        return redirect()->route('client');
    }
    
    public function updating_client_service_details(Request $request, $id)
    {        
        try {
            $validatedData = $request->validate([
                'client_service_ID.*' => 'nullable|exists:clients_services,id',
                'sub_service_id.*' => 'nullable',
                'starting_period.*' => 'nullable',
                'sub_service_id_new.*' => 'nullable|string|max:25',
                'starting_period_new.*' => 'nullable|string|max:100',
            ], [
                'sub_service_id_new.required' => 'service is required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $client = Client::find($id);

        if ($request->has('sub_service_id_new')) {

            foreach ($request->sub_service_id_new as $key => $SubServiceID) {
                $clientService = new Clients_service();
                $clientService->client_id = $client->id;
                $clientService->sub_service_id = $SubServiceID;
                $clientService->starting_period = $validatedData['starting_period_new'][$key];
                $clientService->entry_date = $formattedDateTime;
                $clientService->save();
    
                $tasks = SubServiceTask::where('sub_service_id', $SubServiceID)->get();
    
                foreach ($tasks as $task) {
                    $clientTask = new ClientTask();
                    $clientTask->client_id = $client->id;
                    $clientTask->CS_id = $clientService->id;
                    $clientTask->CS_task_id = $task->id;
                    $clientTask->entry_date = $formattedDateTime;
    
                    $clientTask->save();
                }
    
            }
        }

        return redirect()->back()->with('success', 'Client service information stored successfully!');        
    }

    public function marking_client_service_payment_status_as_paid(Request $request, $id)
    {

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $client_service_to_update = Clients_service::find($id);
        $client_service_to_update->payment_amount = $request->input('payment_amount');
        $client_service_to_update->payment_status = $request->input('payment_status');
        $client_service_to_update->save();

        return redirect()->back()->with('success', 'Client service payment status updated successfully!');        

    }

}
