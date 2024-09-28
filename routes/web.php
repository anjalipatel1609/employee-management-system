<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\TaskAllocationController;
use App\Http\Controllers\PasswordRecoveryController;
use App\Http\Controllers\AuthenticatingUserController;
use App\Http\Controllers\CreateAdminController;


/* ---------------------------- admin data entry ------------------------ */
Route::get('/secret_url_to_create_admin', [CreateAdminController::class, 'createAdmin']);

/* ---------------------------- views of website ------------------------ */

Route::get('/', [ViewsController::class, 'index'])->name('index');
Route::get('/login', [ViewsController::class, 'login'])->name('login')->middleware('logoutAuth');
Route::get('/forget_password', [ViewsController::class, 'forget_password'])->name('forget_password');
Route::get('/password_reset/{user_id}', [ViewsController::class, 'password_reset'])->name('password_reset');
Route::get('/dashboard', [ViewsController::class, 'dashboard'])->name('home');
Route::get('/dashboard/task_details', [ViewsController::class, 'task_details'])->name('task_details')->middleware('adminHRAuth');
Route::get('/services', [ViewsController::class, 'services'])->name('services')->middleware('adminHRAuth');
Route::get('/client', [ViewsController::class, 'client'])->name('client')->middleware('adminHRAuth');
Route::get('/client/{id}', [ViewsController::class, 'client_details'])->name('client_details')->middleware('adminHRAuth');
Route::get('/employee', [ViewsController::class, 'employee'])->name('employee')->middleware('adminHRAuth');
Route::get('/employee/{id}', [ViewsController::class, 'employee_details'])->name('employee_details')->middleware('adminHRAuth');
Route::get('/task_allocation', [ViewsController::class, 'task_allocation'])->name('task_allocation')->middleware('adminHRAuth');
Route::get('/task_report', [ViewsController::class, 'task_report'])->name('task_report');
Route::get('/client_report', [ViewsController::class, 'client_report'])->name('client_report')->middleware('adminHRAuth');
Route::get('/activity_log', [ViewsController::class, 'activity_log'])->name('activity_log')->middleware('adminHRAuth');
Route::get('/password_reset_page_in_dashabord/{email}', [ViewsController::class, 'password_reset_page_in_dashabord'])->name('password_reset_page_in_dashabord');
Route::get('/password_updated', [ViewsController::class, 'password_updated'])->name('password_updated');

Route::get('/task_approv', [ViewsController::class, 'task_approv'])->name('task_approv');
Route::get('/approved_tasks', [ViewsController::class, 'approved_tasks'])->name('approved_tasks');
Route::get('/declined_tasks', [ViewsController::class, 'declined_tasks'])->name('declined_tasks');
Route::get('/task_vice_report', [ViewsController::class, 'task_vice_report'])->name('task_vice_report');
Route::post('/task_vice_specific_report', [ViewsController::class, 'task_vice_specific_report'])->name('task_vice_specific_report');
Route::get('/service_report', [ViewsController::class, 'service_report'])->name('service_report');
Route::get('/generate_invoice/{id}', [ViewsController::class, 'generate_invoice'])->name('generate_invoice');
Route::post('/generating_invoice', [ViewsController::class, 'generating_invoice'])->name('generating_invoice');
Route::post('/printing_generated_invoice', [ViewsController::class, 'printing_generated_invoice'])->name('printing_generated_invoice');

/* ---------------------------- login ------------------------ */
Route::post('/authenticating_user', [AuthenticatingUserController::class, 'authenticating_user'])->name('authenticating_user');

/* ---------------------------- sending mail to reset the password ------------------------ */
Route::post('/sending_mail_to_reset_password', [PasswordRecoveryController::class, 'sending_mail_to_reset_password'])->name('sending_mail_to_reset_password');
Route::post('/updating_user_password/{id}', [PasswordRecoveryController::class, 'updating_user_password'])->name('updating_user_password');

/* ---------------------------- CRUD on services ------------------------ */
Route::post('/service_C', [ServicesController::class, 'service_C'])->name('service_C');
Route::post('/service_U/{id}', [ServicesController::class, 'service_U'])->name('service_U');
Route::get('/deactivating_service/{id}', [ServicesController::class, 'deactivating_service'])->name('deactivating_service');
Route::get('/activating_service/{id}', [ServicesController::class, 'activating_service'])->name('activating_service');
Route::get('/service_details/{id}', [ServicesController::class, 'service_details'])->name('service_details');

Route::get('/deleting_sub_service/{id}', [ServicesController::class, 'deleting_sub_service'])->name('deleting_sub_service');
Route::get('/deleting_task/{id}', [ServicesController::class, 'deleting_task'])->name('deleting_task');
Route::post('/updateService/{id}', [ServicesController::class, 'updateService'])->name('updateService');

/* ---------------------------- CRUD on Employees ------------------------ */
Route::post('/Employee_C', [EmployeesController::class, 'Employee_C'])->name('Employee_C');
Route::post('/employee_U/{id}', [EmployeesController::class, 'employee_U'])->name('employee_U');
Route::get('/deactivating_employee/{id}', [EmployeesController::class, 'deactivating_employee'])->name('deactivating_employee');
Route::get('/activating_employee/{id}', [EmployeesController::class, 'activating_employee'])->name('activating_employee');

/* ---------------------------- CRUD on client ------------------------ */
Route::post('/client_C', [ClientController::class, 'client_C'])->name('client_C');
Route::post('/client_U/{id}', [ClientController::class, 'client_U'])->name('client_U');
Route::post('/updating_client_service_details/{id}', [ClientController::class, 'updating_client_service_details'])->name('updating_client_service_details');
Route::get('/deactivating_client/{id}', [ClientController::class, 'deactivating_client'])->name('deactivating_client');
Route::get('/activating_client/{id}', [ClientController::class, 'activating_client'])->name('activating_client');
Route::post('/marking_client_service_payment_status_as_paid/{id}', [ClientController::class, 'marking_client_service_payment_status_as_paid'])->name('marking_client_service_payment_status_as_paid');

/* ---------------------------- Task allocation ----------------------- */
Route::get('/single_client_task_allocation/{id}', [TaskAllocationController::class, 'single_client_task_allocation'])->name('single_client_task_allocation')->middleware('adminHRAuth');
Route::post('/allocating_task', [TaskAllocationController::class, 'allocating_task'])->name('allocating_task');
Route::post('/reallocating_task', [TaskAllocationController::class, 'reallocating_task'])->name('reallocating_task');

/* ---------------------------- Dashboard Pages ----------------------- */
Route::get('/Not_Allocated_Task', [ViewsController::class, 'Not_Allocated_Task'])->name('Not_Allocated_Task')->middleware('adminHRAuth');
Route::get('/completed_task', [ViewsController::class, 'completed_task'])->name('completed_task')->middleware('adminHRAuth');
Route::get('/in_progress_task', [ViewsController::class, 'in_progress_task'])->name('in_progress_task')->middleware('adminHRAuth');
Route::get('/deadline_crossed_task', [ViewsController::class, 'deadline_crossed_task'])->name('deadline_crossed_task')->middleware('adminHRAuth');


/* ---------------------------- Employee Dashboard ----------------------- */
Route::get('/dashboard_E', [ViewsController::class, 'dashboard_E'])->name('home_E')->middleware('employeeAuth');
Route::get('/employee_logout', [EmployeesController::class, 'employee_logout'])->name('employee_logout');
Route::get('/HR__ADMIN__logout', [EmployeesController::class, 'HR__ADMIN__logout'])->name('HR__ADMIN__logout');

Route::get('/allocated_task', [ViewsController::class, 'allocated_task'])->name('allocated_task');
Route::get('/deadline_crossed_task_of_specific_employee', [ViewsController::class, 'deadline_crossed_task_of_specific_employee'])->name('deadline_crossed_task_of_specific_employee');
Route::post('/mark_task_as_completed', [EmployeesController::class, 'mark_task_as_completed'])->name('mark_task_as_completed');
Route::get('/completed_task_of_specific_employee', [ViewsController::class, 'completed_task_of_specific_employee'])->name('completed_task_of_specific_employee');
Route::get('/accepted_task_of_specific_employee', [ViewsController::class, 'accepted_task_of_specific_employee'])->name('accepted_task_of_specific_employee');
Route::get('/unapproved_task_of_specific_employee', [ViewsController::class, 'unapproved_task_of_specific_employee'])->name('unapproved_task_of_specific_employee');
Route::get('/approvement_pending_task_of_specific_employee', [ViewsController::class, 'approvement_pending_task_of_specific_employee'])->name('approvement_pending_task_of_specific_employee');

Route::post('/update_task_approval/{id}', [EmployeesController::class, 'update_task_approval'])->name('update_task_approval');
Route::get('/not_approving_task/{id}', [EmployeesController::class, 'not_approving_task'])->name('not_approving_task');
Route::post('/approving_task_again/{id}', [EmployeesController::class, 'approving_task_again'])->name('approving_task_again');

