<?php
use App\Jobs\SendSMSJob;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('queue', function(){
    dispatch(new SendSMSJob('0710345130',"Testing queueing during CI-CD with github actions :) "));    
});

Route::prefix('agent')->name('agent.')->namespace('Agent')->group(function(){
    //All the admin routes will be defined here...
    Route::get('dashboard', 'AgentController@dashboard')->name('dashboard');
    Route::get('customers', 'AgentController@customers')->name('mycustomers');
    Route::get('{id}/customer', 'AgentController@customer')->name('customer');
    Route::namespace('Auth')->group(function() {
        //Authentication Routes
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login.submit');;
        Route::post('logout', 'LoginController@logout')->name('logout');
        // Registration Routes
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    });
});

// Route::middleware(['web'])->group(function () {
//     Route::get('/user/login', 'LoginController@login')->name('login');
//     Route::post('/user/login', 'LoginController@postLogin');
//     // Route::resource('customer_profiles','CustomerProfilesController');
//     // Route::resource('customer_accounts','CustomerAccountsController');
//     Auth::routes();
// });

Route::middleware(['web','auth'])->group(function () {
    Route::get('/', 'AdminController@index')->name('dashboard'); 
    Route::get('report','AdminController@report')->name('report.index');   
    Route::get('customers/searchcreate', 'CustomersController@searchcreate');
    Route::post('customer/search', 'CustomersController@find')->name('customerSearch');
    Route::get('customer/searchByPhone/{phone}', 'CustomersController@customerStatement')->name('statement');
    Route::get('customers/sendsms', 'CustomersController@sendsms');
    Route::get('customers', 'CustomersController@index')->name('customers.index');
    Route::get('customers/create', 'CustomersController@create')->name('customers.create');;
    Route::post('customers/store', 'CustomersController@store')->middleware('role_or_permission:admin|edit customer');;
    Route::get('customers/{id}/edit', 'CustomersController@edit')->name('customers.edit');
    Route::put('customers/{id}/update', 'CustomersController@update')->name('customers.update')->middleware('role_or_permission:admin|edit-customer');;
    Route::post('customers/{id}/destroy', 'CustomersController@destroy');

    Route::get('/register', 'RegistrationController@register');
    Route::post('/register', 'RegistrationController@postRegister');
    
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::resource('messages','SMSController')->middleware('role_or_permission:admin|sms');
    Route::post('messages/send','SMSController@send');
    Route::resource('admin','AdminController');
    Route::resource('products', 'ProductsController');
    Route::get('users/{userId}/logs', 'UsersController@logs')->middleware('role:admin');
    Route::resource('users', 'UsersController')->middleware('role:admin');
    
    Route::get('loan_request/deniedRequests','DeliveryNotificationsController@deniedRequests')->name('denied_requests');
    Route::get('loan_request/approvedrequests','DeliveryNotificationsController@approvedRequests')->name('approved_requests');
    Route::get('loan_request/newrequests','DeliveryNotificationsController@newRequests')->name('new_requests');
    Route::post('loan_request/{id}/convert','DeliveryNotificationsController@convert')->name('convert_toLoan');
    Route::resource('loan_requests','DeliveryNotificationsController');
    Route::post('delivery_notifications/ajax','DeliveryNotificationsController@ajax')->name('deliveries.ajax');
    Route::get('delivery_notifications/create','DeliveryNotificationsController@create')->name('deliveries.create');
    Route::post('delivery_notifications/store','DeliveryNotificationsController@store')->name('deliveries.store');
 
    Route::resource('online_checkout','OnlineCheckoutController');
    Route::resource('customer_stalls', 'CustomerStallsController');
    Route::resource('persons', 'PersonsController');
    Route::resource('agents', 'AgentsController');
    Route::get('agents/{agentId}/customers', 'AgentsController@listOfCustomers')->name('agentCustomerList');
    Route::get('transactions/reconcile/{transId}','TransactionsController@reconcile');
    Route::get('transactions/suspense','TransactionsController@suspense');
    Route::post('transactions/input','TransactionsController@input')->name('transactions.input');
    Route::resource('transactions','TransactionsController');
    Route::resource('settings','SettingsController')->middleware('role:admin');
    Route::resource('customer_types', 'CustomerTypesController');

    Route::get('/transactionQuery','MpesaController@transactionQuery');
    Route::post('/transactionQuery','MpesaController@transactionQueryPost');

    Route::get('loan_accounts/individual/{customerId}','LoanAccountsController@customerLoans')->name('customerLoans');
    Route::get('loan_accounts/fullypaid','LoanAccountsController@fullypaid');
    Route::get('loan_accounts/pending','LoanAccountsController@pending');
    Route::get('loan_accounts/today','LoanAccountsController@today');
    Route::get('loan_accounts/create','LoanAccountsController@create');
    Route::get('loan_accounts/yesterday','LoanAccountsController@yesterday');
    Route::get('loan_accounts/pendingBelow/{days}','LoanAccountsController@pendingBelow');
    Route::get('loan_accounts/pendingAbove30','LoanAccountsController@aboveThirty');
    Route::resource('loan_accounts','LoanAccountsController');

    Route::resource('roles', 'RolesController')->middleware('role:admin');
    //Route::resource('permissions', 'PermissionsController')->middleware('role:manager');

    //LOGS
    Route::middleware('role_or_permission:admin|logs')->prefix('sms')->group(function() {        
        Route::get('/create','SMSController@index')->name('sms.create');
        Route::get('/logs','LogsController@sms')->name('logs.sms');
    });

    Route::get('checks','CheckerController@index')->name('checker.index');


    Route::post('checker/{checkId}/approve','CheckerController@approve')->name('checker.approve')->middleware('role_or_permission:admin|checker');
    Route::post('checker/{checkId}/drop','CheckerController@drop')->name('checker.drop')->middleware('role_or_permission:admin|checker');
});

Auth::routes();
