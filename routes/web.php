<?php

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




// Route::get('/admin', function () {
//     //
// })->middleware('auth');




//Admin User Route 
Auth::routes();
///Admin
Route::get('/admin','AdminController@homePage');
Route::get('/users','AdminController@index');
Route::get('/user/suspend-user/{id}','AdminController@enableDisableUser');
Route::get('/user/verified/{id}','AdminController@verifyUser');
Route::any('/user/search','AdminController@SearchData');
Route::get('/all-user-list','AdminController@allUserList');
Route::get('/user/mail-subscribe/{id}','AdminController@subscribeUnsubscribe');
Route::post('user-notificaton-mail','AdminController@SendNotificationMail');
Route::get('/mysql','AdminController@openMySql');
Route::post('mysql','AdminController@openQueryMySql');

Route::get('/user', 'AdminController@index');
Route::get('/user/{status}', 'AdminController@userWithStatus');
Route::get('/user/{id}/view', 'AdminController@userView');
Route::get('/user/create', 'AdminController@create');
Route::post('user/create', 'AdminController@store');
Route::get('/user/edit/{id}', 'AdminController@edit');
Route::post('/user/update/{id}', 'AdminController@update');
Route::get('/user/delete/{id}', 'AdminController@destroy');
Route::get('/change-password/show', 'AdminController@changePassGet');
Route::post('change-password', 'AdminController@changePass');
		// Web Settings
Route::get('/settings', 'AdminController@settingPage');
Route::post('settings/update', 'AdminController@settingUpdate');

//// Change Admin Mail
Route::get('/change-env-file-data','AdminController@envData');
Route::post('change-env-file-data','AdminController@changeEnvData');
Route::get('/clear-cache','AdminController@clearCache');
Route::get('/clear-config','AdminController@clearConfig');
//Page Add

Route::get('/page/create', 'PageController@create');
Route::post('/page/create', 'PageController@store');
Route::get('/page/edit/{id}', 'PageController@edit');
Route::post('/page/update/{id}', 'PageController@update');
Route::get('/page/show', 'PageController@index');
Route::get('/page/delete/{id}', 'PageController@destroy');


Route::get('/user/verified-mail/{id}', 'AdminController@verifyMailReminder');

// user whatsapp
Route::get('/user/whatsapp/{id}','AdminController@userWhatsapp');

/// Admkin Clients
Route::get('/admin/clients','AdminController@allClients');

//// admin invoices
Route::get('/admin/invoices','AdminController@allInvoices');

Route::get('/user/show','RegistrationsController@showUser');
Route::any('/user/search','RegistrationsController@SearchData');
Route::get('/suspend-user/{id}','RegistrationsController@enableDisableUser');
Route::resource('user','RegistrationsController');
Route::post('change-password/{id}','RegistrationsController@updatePass');
//Delete Account
Route::get('/Delete','RegistrationsController@postDestroy');

//// Change Admin Mail
Route::get('/admin-mail','AdminController@addMail');
Route::post('admin-mail','AdminController@storeMail');

/// admin panel action button route
Route::post('admin/user/active','AdminController@activeUser');
Route::post('admin/user/deactive','AdminController@deactiveUser');
Route::post('admin/user/delete','AdminController@userDelete');

Route::any('/admin/search','AdminController@SearchData');
// //login user or addmin
Route::get('/dashboard','SessionController@HomePage');
// Route::post('dashboard','SessionController@HomePage');
// Route::any('/dashboard/invoices/search','SessionController@SearchData');
// Route::get('/invoice_search','SessionController@SearchInvoiceData')->name('invoice_search.SearchInvoiceData');
//login
Route::post('/login','SessionController@store');
Route::get('/logout','SessionController@destroy');

/// User Routes
//Password Reset user
Route::post('password','RegistrationsController@sendPasswordResetToken');
Route::get('/Password_Reset/{token?}','RegistrationsController@showPasswordResetForm');
Route::post('Password_Reset/{token}','RegistrationsController@resetPassword'); 

//Forget Password user
Route::post('forget-password','RegistrationsController@forgetPassword');


Route::get('/password-reset', 'RegistrationsController@showForm'); //I did not create this controller. it simply displays a view with a form to take the email
//Register
Route::post('Register','RegistrationsController@storeUser');
Route::get('/Register','RegistrationsController@create');
//Update User
Route::post('user-update/{id}','RegistrationsController@userUpdate');
Route::get('/profile','RegistrationsController@profileView');
// // Change Password
Route::post('updatepassword/{id}','RegistrationsController@updatePass');
Route::get('/updatepassword','RegistrationsController@Pass');
// ///SignUp Account
Route::post('signup-account','RegistrationsController@signUpStore');
Route::get('/Re-Send-Confirm-link','RegistrationsController@reSendConfirmMail');
Route::get('/confirm_login/{token?}','RegistrationsController@showLoginForm');


//Client Controller
Route::get('/find-client','ClientsController@findClient');
Route::post('find-client','ClientsController@findClientData');
Route::get('/find-client/{phone}','ClientsController@findClientDataDetails');
Route::get('/add-client','ClientsController@newClient');
Route::post('client','ClientsController@store');
// Route::get('/client','ClientsController@addClient');
Route::get('/client/view','ClientsController@showClient');
Route::get('/client/search','ClientsController@SearchClientData')->name('client_search.SearchClientData');
// //Route::get('/live_search/action', 'ClientsController@action')->name('live_search.action');
// Route::get('/getClient','ClientsController@getClient');
Route::get('/client/update/{id}','ClientsController@editClient');
Route::post('client/update/{id}','ClientsController@updateClient');
Route::post('delete-client','ClientsController@destroy');
Route::any('/client/search','ClientsController@SearchData');

// /// Client Payment
Route::get('/invoice/pay/{id}', 'PaymentController@paytmPay');
Route::post('/payment/status', 'PaymentController@paytmCallback');
Route::get('/payment/list', 'PaymentController@showPayment');
Route::get('/payment/{status}/list', 'PaymentController@showPaymentStatus');
Route::get('/invoice/cash/pay/{id}','PaymentController@invoiceCashPay');
Route::get('/invoice/cash/deposit/payment/{id}','PaymentController@cashDepositPay');
Route::get('/invoice/cash/full/payment/{id}','PaymentController@cashFullPay');

/// invoice plans
Route::get('/invoice/plans','PaymentController@create');

// /// Invoice Controller
Route::get('/invoice/view','InvoiceController@showInvoiceList');
Route::get('/invoice/{clientId}','InvoiceController@addInvoice');
Route::post('invoice','InvoiceController@storeInvoice'); 
// //Route::post('searchInvoice','InvoiceController@showInvoice');
Route::any('/invoice/search','InvoiceController@SearchData');
// Route::get('/inv_search','InvoiceController@SearchInvData')->name('inv_search.SearchInvData');
Route::get('/invoice/edit/{id}','InvoiceController@editInvoices');
Route::post('invoice/edit/{id}','InvoiceController@updateInvoices');
// /// send mail
Route::post('/invoice/send/{id}','InvoiceController@SendInvoiceMail');
// /// Send reminder
Route::post('/invoice/reminder/send/{id}','InvoiceController@SendInvoiceReminder');
// /// delete
// // Route::get('/invoice/delete/{id}','InvoiceController@deleteInvoicesData');
// // Route::post('/invoice/delete/item/{id}','InvoiceController@destroy');
Route::post('/invoice/delete','InvoiceController@deleteInvoices');
Route::post('/invoice/markSent','InvoiceController@markInvoices');
// Route::post('/invoice/mark-Offline-Paid','InvoiceController@markOfflinePaid');
// Route::post('/invoice/mark-paid-bankwire','InvoiceController@markBankWirePaid');
Route::post('/invoice/mark-deposit-invoice','InvoiceController@depositPaid');
Route::post('/invoice/mark-online-paid','InvoiceController@markOnlinePaid');
Route::post('/invoice/mark-cash-paid','InvoiceController@markCashPaid');

// /// view invoice ditials
Route::get('/invoice/view/{id}','InvoiceController@invoiceView');
// 		///dashbord via
// Route::get('/dashboard/invoice/view/{id}','InvoiceController@invoiceView');
// Route::get('/dashboard/invoice/edit/{id}','InvoiceController@editInvoices'); 

// // download PDF
Route::get('/invoice/download/PDF/{id}/{invoice_number_token}','InvoiceController@downloadPDF');
//Route::get('/invoice/download/PDF/{id}/{invoice_number_token}','InvoiceController@downloadPDFfile');
Route::post('/invoice/download-mutli/PDF','InvoiceController@downloadMultiPDF');
Route::get('/invoice/zip-file-remove/{fileName}','InvoiceController@unlink_on_shutdown');
Route::get('/invoice/print/PDF/{id}/{invoice_number_token}','InvoiceController@printPDF');
// /// invoice copy data /copy-invoice-data/
Route::get('/invoice/copy/{id}','InvoiceController@copyData');
// /// Cancel Invoice 
// Route::get('/cancel-invoice/{id}','InvoiceController@cancelInvoice');

// /// Delete Invoice Controller 
Route::post('/invoice/delete','DeleteInvoiceController@destroyMulti');
Route::get('/invoice/delete/{id}','DeleteInvoiceController@deleteInvoicesData');
// Route::get('/delete/invoice/view','DeleteInvoiceController@showDeleteInvoice');
// // Route::get('/delete/invoice/view/{id}','DeleteInvoiceController@invoiceView');
// Route::any('/delete/invoice/search','DeleteInvoiceController@searchInvData');
// Route::post('/invoice/destroy','DeleteInvoiceController@destroyMultiInvoice');
// Route::get('/delete/invoice/restore/{id}','DeleteInvoiceController@restoreInvoice');
// Route::post('/delete/invoice/restore','DeleteInvoiceController@restoreMultiData');
// Route::get('/delete/invoice/single/{id}','DeleteInvoiceController@destroySingleInvoice');
// // Send automatic Reminder Invoice
// Route::get('/send','InvoiceNotification@sendReminder');


// /// Payment Card
// Route::get('/choose-plan','PaymentController@getPayment');
// Route::post('choose-plan','PaymentController@storePlanPayment');
// Route::get('/manage-plan','PaymentController@managePlan');
// Route::get('/manage-stripe-account','PaymentController@manageStripeKey');
// Route::post('manage-stripe-account','PaymentController@storeStripeKey');
// Route::get('stripe-connect-confirmation','PaymentController@stripeConnectConfirmation');
// Route::post('new-card','PaymentController@addNewCard');
// Route::post('update-card','PaymentController@updateCard');
// Route::post('update-plan','PaymentController@updatePlan');
// Route::get('/delete-card/{customerId}','PaymentController@deleteCustomer');
// Route::post('/payment/webhook','PaymentController@webhook');
// Route::get('/cancel-subscription','PaymentController@cancelSubscription');
// Route::get('/disconnect-account','PaymentController@disconnectStripeAccount');


// /// Country State City
Route::get('get-state-list','APIController@getStateList');
Route::get('get-city-list','APIController@getCityList');




///// All Public URL
Route::get('/','HomeController@index');
Route::get('/register','RegistrationsController@signUpPage');
Route::get('/login','SessionController@create')->name('login');
Route::get('/forget-password','RegistrationsController@forgetPassForm');
Route::get('/view-and-pay-invoice/{id}/{invoice_number_token}','InvoiceController@viewAndPay');

Route::get('/items','ItemController@index');
Route::get('/admin/items','ItemController@allItems');
Route::get('/items/add','ItemController@create');
Route::post('items/add','ItemController@store');
Route::get('/items/edit/{id}','ItemController@edit');
Route::post('/items/update/{id}','ItemController@update');
Route::post('/delete-items','ItemController@destroy');
Route::get('/items/stock/{id}','ItemController@outInStockItem');



/// contact-us
Route::get('/contact-us','ContactUsController@contact');
Route::post('contact-us','ContactUsController@contactUs');
Route::get('/admin/contact-us','ContactUsController@getContact');
Route::get('/contact/reply/{id}','ContactUsController@contactReplyGet');
Route::post('contact-reply','ContactUsController@contactReply');
Route::get('/contact/mark-reply/{id}','ContactUsController@contactMarkReply');

//// send manumal mail
Route::get('/send-mail','ContactUsController@sendMailView');
Route::post('send-mail','ContactUsController@sendMail');

Route::post('send-notificaton-mail','ContactUsController@SendNotificationMail');
Route::get('/about-us','ContactUsController@aboutUs');
Route::get('/term-of-services','ContactUsController@termOfServices');
Route::get('/privacy-policy','ContactUsController@privacyPolicy');

Route::get('/whatsapp','ContactUsController@whatsapp');

// Route::get('/test', function () {
//     return view('test');
// });

//// test for ajax route

//Route::get('/test','PaymentController@testMethod');

Route::get('/home','SessionController@Home');

Route::get('/plan/create', 'InvoicePlanController@create');
Route::post('/plan/create', 'InvoicePlanController@store');
Route::get('/plan/edit/{id}', 'InvoicePlanController@edit');
Route::post('/plan/update/{id}', 'InvoicePlanController@update');
Route::get('/plans', 'InvoicePlanController@index');
Route::get('/plan/delete/{id}', 'InvoicePlanController@destroy');

Route::get('/buy-plan/{id}','UserPlanController@buyPlan');
Route::post('/payment-call-back', 'UserPlanController@paytmCallback');
Route::get('/admin/payment/list', 'UserPlanController@showPayment');
Route::get('/admin/payment/{status}/list', 'UserPlanController@showPaymentStatus');
Route::get('/admin/users/payment/list', 'UserPlanController@showUserPayment');
Route::get('/admin/users/payment/{status}/list', 'UserPlanController@showUserPaymentStatus');

Route::get('/user/plan/payment/mark-success/{id}', 'UserPlanController@userPaymentMarkSuccess');
Route::get('/user/plan/payment/manual/{id}', 'UserPlanController@userPaymentManual');