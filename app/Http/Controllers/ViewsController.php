<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/*   models   */
use App\Models\Service;
use App\Models\SubService;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Clients_service;
use App\Models\clientTask;
use App\Models\SubServiceTask;
use App\Models\task_allocation;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordRecoveryMail;
use PDF;

class ViewsController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }

    public function forget_password()
    {
        return view('forget_password');
    }

    public function password_reset($user_id)
    {
        $userToResetPassword = Employee::with('systemUser')->find($user_id);
        return view('password_reset', compact('userToResetPassword'));
    }

    public function password_updated()
    {
        return view('password_updated');
    }

    public function dashboard()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        $employee_session = Session::get('employee_session');

        return view('dashboard', compact('HR__ADMIN__session', 'employee_session'));
    }

    public function task_details()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        return view('task_details', compact('HR__ADMIN__session'));
    }

    public function services()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allServices = Service::all();
        return view('services', compact('allServices', 'HR__ADMIN__session'));
    }

    public function client()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allServices = Service::where('is_active', "1")->get();
        $allClient = Client::all();

        $allSubServicesWithMainService = SubService::with('mainService')->where('is_active', "1")->get();

        return view('client', compact('allServices', 'allClient', 'HR__ADMIN__session', 'allSubServicesWithMainService'));

    }

    public function client_details($id)
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $clientToShow = Client::find($id);
        $allServices = Service::where('is_active', "1")->get();
        $allSubServicesWithMainService = SubService::with('mainService')->where('is_active', "1")->get();
        $Clients_service = Clients_service::where('client_id', $id)->get();
        return view('client_details', compact('allServices','clientToShow', 'Clients_service', 'HR__ADMIN__session', 'allSubServicesWithMainService'));
    }

    public function employee()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allEmployees = Employee::where('user_type', "Employee")->get();
        $allHRs = Employee::where('user_type', "HR")->get();
        return view('employee', compact('allEmployees', 'allHRs', 'HR__ADMIN__session'));
    }

    public function employee_details($id)
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $employeeToShow = Employee::find($id);
        $allTaskOfParticullarEmployee = task_allocation::where('employee_id', $id)->get();
        return view('employee_details', compact('employeeToShow', 'allTaskOfParticullarEmployee', 'HR__ADMIN__session'));
    }

    public function task_allocation()
    {
        $allServices = Service::where('is_active', "1")->get();
        $allClient = Client::where('is_active', "1")->get();

        $clientsWithUnallocatedTasks = Client::whereHas('task', function($query) {
            $query->where('is_allocated', 0);
        })->where('is_active', 1)->get();

        $clientsWithIncompleteTasks = Client::whereHas('task', function($query) {
            $query->where('is_completed', 0);
        })->where('is_active', 1)->get();

        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
    
        return view('task_allocation', compact('allServices', 'allClient', 'clientsWithUnallocatedTasks', 'clientsWithIncompleteTasks', 'HR__ADMIN__session'));
    }

    public function task_report()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allTasks = task_allocation::with('employee', 'ClientsTasks')->get();
        return view('task_report', compact('allTasks', 'HR__ADMIN__session'));
    }

    public function client_report()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allClient = Client::all();
        return view('client_report', compact('allClient', 'HR__ADMIN__session'));
    }

    public function activity_log()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $AllClients_service = Clients_service::all();
        return view('activity_log', compact('AllClients_service', 'HR__ADMIN__session'));
    }

    public function Not_Allocated_Task()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allNotAllocatedTask = clientTask::with('client')->where('is_allocated', "0")->get();
        return view('Not_Allocated_Task', compact('allNotAllocatedTask', 'HR__ADMIN__session'));
    }

    public function completed_task()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allcompleted_task = task_allocation::with('employee', 'ClientsTasks')->where('is_completed', "1")->where('is_approved', "1")->get();
        return view('completed_task', compact('allcompleted_task', 'HR__ADMIN__session'));
    }

    public function in_progress_task()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $currentDate = date('Y-m-d');
        $currentDateTime = date('Y-m-d\TH:i');
        $all_In_progress_task = task_allocation::with('employee', 'ClientsTasks')->where('is_completed', "0")->where('deadLine', '>', $currentDateTime)->get();
        return view('in_progress_task', compact('all_In_progress_task', 'HR__ADMIN__session'));
    }

    public function deadline_crossed_task()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $currentDate = date('Y-m-d');
        $currentDateTime = date('Y-m-d\TH:i');
        $all_deadline_crossed_task = task_allocation::with('employee', 'ClientsTasks')->where('is_completed', "0")->where('deadLine', '<', $currentDateTime)->get();

        return view('deadline_crossed_task', compact('all_deadline_crossed_task', 'HR__ADMIN__session'));
    }

    public function dashboard_E()
    {
        $employee_session = Session::get('employee_session');
        return view('dashboard_E', compact('employee_session'));
    }

    public function allocated_task()
    {
        $currentDate = date('Y-m-d');
        $currentDateTime = date('Y-m-d\TH:i');
        $employee_session = Session::get('employee_session');
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        if($employee_session)
        {
            $allAllocatedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $employee_session->employees->first()->id)->where('is_completed', "0")->where('deadLine', '>', $currentDateTime)->get();
            return view('allocated_task', compact('employee_session', 'allAllocatedTaskOfSpecificEmployee'));
        }

        if($HR__ADMIN__session)
        {
            $allAllocatedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $HR__ADMIN__session->employees->first()->id)->where('is_completed', "0")->where('deadLine', '>', $currentDateTime)->get();
            return view('allocated_task', compact('HR__ADMIN__session', 'allAllocatedTaskOfSpecificEmployee'));
        }
    }

    public function deadline_crossed_task_of_specific_employee()
    {
        $currentDate = date('Y-m-d');
        $currentDateTime = date('Y-m-d\TH:i');
        $employee_session = Session::get('employee_session');
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        if($employee_session)
        {
            $allAllocatedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $employee_session->employees->first()->id)->where('is_completed', "0")->where('deadLine', '<', $currentDateTime)->get();
            return view('deadline_crossed_task_of_specific_employee', compact('employee_session', 'allAllocatedTaskOfSpecificEmployee'));
        }

        if($HR__ADMIN__session)
        {
            $allAllocatedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $HR__ADMIN__session->employees->first()->id)->where('is_completed', "0")->where('deadLine', '<', $currentDateTime)->get();
            return view('deadline_crossed_task_of_specific_employee', compact('HR__ADMIN__session', 'allAllocatedTaskOfSpecificEmployee'));
        }

    }

    public function completed_task_of_specific_employee()
    {
        $employee_session = Session::get('employee_session');
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        if($employee_session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $employee_session->employees->first()->id)->where('is_completed', "1")->where('is_approved', "0")->get();
            return view('completed_task_of_specific_employee', compact('employee_session', 'allCompletedTaskOfSpecificEmployee'));
        }

        if($HR__ADMIN__session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $HR__ADMIN__session->employees->first()->id)->where('is_completed', "1")->where('is_approved', "0")->get();
            return view('completed_task_of_specific_employee', compact('HR__ADMIN__session', 'allCompletedTaskOfSpecificEmployee'));
        }
    }

    public function accepted_task_of_specific_employee()
    {
        $employee_session = Session::get('employee_session');
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        if($employee_session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $employee_session->employees->first()->id)->where('is_approved', "1")->get();
            return view('accepted_task_of_specific_employee', compact('employee_session', 'allCompletedTaskOfSpecificEmployee'));
        }

        if($HR__ADMIN__session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $HR__ADMIN__session->employees->first()->id)->where('is_approved', "1")->get();
            return view('accepted_task_of_specific_employee', compact('HR__ADMIN__session', 'allCompletedTaskOfSpecificEmployee'));
        }
    }

    public function unapproved_task_of_specific_employee()
    {
        $employee_session = Session::get('employee_session');
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        if($employee_session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $employee_session->employees->first()->id)->where('is_approved', "-1")->get();
            return view('unapproved_task_of_specific_employee', compact('employee_session', 'allCompletedTaskOfSpecificEmployee'));
        }

        if($HR__ADMIN__session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $HR__ADMIN__session->employees->first()->id)->where('is_approved', "-1")->get();
            return view('unapproved_task_of_specific_employee', compact('HR__ADMIN__session', 'allCompletedTaskOfSpecificEmployee'));
        }
    }

    public function approvement_pending_task_of_specific_employee()
    {
        $employee_session = Session::get('employee_session');
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        if($employee_session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $employee_session->employees->first()->id)->where('is_completed', "1")->get();
            return view('approvement_pending_task_of_specific_employee', compact('employee_session', 'allCompletedTaskOfSpecificEmployee'));
        }

        if($HR__ADMIN__session)
        {
            $allCompletedTaskOfSpecificEmployee = task_allocation::with('employee', 'ClientsTasks')->where('employee_id', $HR__ADMIN__session->employees->first()->id)->where('is_completed', "1")->get();
            return view('approvement_pending_task_of_specific_employee', compact('HR__ADMIN__session', 'allCompletedTaskOfSpecificEmployee'));
        }
    }

    public function password_reset_page_in_dashabord($email)
    {

        $user = Employee::where('employee_email', $email)->first();

        if ($user) {
            $userType = $user->user_type;

            Mail::to($email)->send(new PasswordRecoveryMail($email));

            if($userType == "Employee")
            {
                return redirect()->route('home')->with('emailHasBeenSent', 'Password reset link is sent on your registered email: ' . $email);
            }

            if($userType == "HR" || $userType == "ADMIN")
            {
                return redirect()->route('home')->with('emailHasBeenSent', 'Password reset link is sent on your registered email: ' . $email);
            }

        }
    }

    public function task_approv()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $completedTask = task_allocation::with('employee', 'ClientsTasks')->where('is_completed', "1")->where('is_approved', "0")->get();
        return view('task_approv', compact('HR__ADMIN__session', 'completedTask'));
    }

    public function approved_tasks()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $completedTask = task_allocation::with('employee', 'ClientsTasks')->where('is_completed', "1")->where('is_approved', "1")->get();
        return view('approved_tasks', compact('HR__ADMIN__session', 'completedTask'));
    }

    public function declined_tasks()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $completedTask = task_allocation::with('employee', 'ClientsTasks')->where('is_approved', "-1")->get();
        return view('declined_tasks', compact('HR__ADMIN__session', 'completedTask'));
    }

    public function task_vice_report()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $allMainServices = Service::where('is_active', "1")->get();
        return view('task_vice_report', compact('HR__ADMIN__session', 'allMainServices'));
    }

    public function service_report()
    {
        $HR__ADMIN__session = Session::get('HR__ADMIN__session');
        $clients = Clients_service::with(['client', 'SubServiceTaken'])->get();
        return view('service_report', compact('HR__ADMIN__session', 'clients'));
    }

    public function task_vice_specific_report(Request $request)
    {
        $sub_service_id = $request->input('sub_service_id');

        $clients = Clients_service::where('sub_service_id', $sub_service_id)->with('client')->get();

        $tasks = SubServiceTask::where('sub_service_id', $sub_service_id)->get();
        $allMainServices = Service::where('is_active', "1")->get();

        $subService = SubService::findOrFail($sub_service_id);
        $subServiceName = $subService->sub_service_name;
        $mainServiceName = $subService->mainService->service_name;

        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        return view('task_vice_report', compact('clients', 'tasks', 'subServiceName', 'allMainServices', 'mainServiceName', 'HR__ADMIN__session'));
    }

    public function generate_invoice($id)
    {
        $client = Client::findOrFail($id);

        $clientAllSubServices = Clients_service::with('SubServiceTaken')->where('client_id', $client->id)->get();
        $clientAllSubServices_ForGeneratingInvoice = Clients_service::with('SubServiceTaken')->where('client_id', $client->id)->where('is_invoice_generated', "0")->get();
        $clientAllSubServices_InvoiceGenerated = Clients_service::with('SubServiceTaken')->where('client_id', $client->id)->where('is_invoice_generated', "1")->get();

        $Paid_services = Clients_service::with('SubServiceTaken')->where('client_id', $client->id)->where('payment_status', "paid")->get();
        $Unpaid_services = Clients_service::with('SubServiceTaken')->where('client_id', $client->id)->where('payment_status', "unpaid")->get();

        $InvoiceGeneratedServices = Clients_service::with('SubServiceTaken')->where('client_id', $client->id)->whereNotNull('payment_status')->whereIn('payment_status', ['paid', 'unpaid'])->get();

        $HR__ADMIN__session = Session::get('HR__ADMIN__session');

        return view('generate_invoice', compact('InvoiceGeneratedServices', 'Unpaid_services', 'Paid_services', 'client', 'HR__ADMIN__session', 'clientAllSubServices', 'clientAllSubServices_ForGeneratingInvoice', 'clientAllSubServices_InvoiceGenerated'));
    }

    public function generating_invoice(Request $request)
    {
        $serviceIds = explode(',', $request->input('service_ids')[0]); 
        $subServicePrices = $request->input('sub_service_price');

        $paymentStatus = $request->input('payment_status');

        if (!empty($paymentStatus) && end($paymentStatus) === ',') {
            array_pop($paymentStatus);
        }

        foreach ($serviceIds as $index => $serviceId) {
            $clientService = Clients_service::findOrFail($serviceId);

            $clientService->payment_amount = $subServicePrices[$index];
            $clientService->payment_status = $paymentStatus[$index]; 
            $clientService->bill_number = uniqid(); 
            $clientService->is_invoice_generated = 1; 

            $clientService->save();
        }

        return redirect()->back()->with('success', 'Invoice generated successfully !');

    }

    public function printing_generated_invoice(Request $request)
    {
        $selectedServices = $request->input('selected_services');
        $clientId = $request->input('client_id');

        $client = Client::with('services', 'task')->where('id', $clientId)->first();

        $clientServices = $client->services->whereIn('id', $selectedServices);

        $pdfContent = view('pdf.invoice', [
            'client' => $client,
            'clientServices' => $clientServices,
        ])->render();

        $pdf = PDF::loadHTML($pdfContent);
        $pdfFileName = $client->client_name . '__' . $client->id . '.pdf';

        return $pdf->download($pdfFileName);

    }
    
  
}
