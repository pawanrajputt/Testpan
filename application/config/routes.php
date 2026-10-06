<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
  | example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
  | https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
  | $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
  | $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
  | $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
    | Examples: my-controller/index -> my_controller/index
      |   my-controller/my-method -> my_controller/my_method
*/

$route['default_controller'] = "AuthController";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ===========CMS===========
$route['cms/(:any)']='AuthController/cmsPage/$1';

// Basic route
$route['signup']='AuthController/index';
$route['check-phone-exists']='AuthController/checkPhoneExists';
$route['send-otp']='AuthController/sendOtp';
$route['resend-otp']='AuthController/resendOtp';
$route['verify-otp']='AuthController/verifyOtp';
$route['store-mpin']='AuthController/storeMpin';
$route['store-ac-data']='AuthController/storeACData';
$route['do-login']='AuthController/login';
$route['logout']='AuthController/logout';
$route['fetch-state-by-country-id']='AuthController/fetchStateByCountryId';
$route['fetch-city-by-state-id']='AuthController/fetchCityByStateId';
$route['reset-forgot-mpin']='AuthController/resetForgotMpin';
$route['send-reset-forgot-mpin-otp']='AuthController/sendResetForgotMpinOtp';
$route['reset-forgot-mpin-otp']='AuthController/resetForgotMpinOtp';
$route['verify-reset-forgot-mpin-otp']='AuthController/verifyResetForgotMpinOtp';
$route['new-mpin-set']='AuthController/newMpinSet';
$route['update-new-mpin-set']='AuthController/updateNewMpinSet';


// Dashboard
$route['dashboard']='dashboard/DashboardController/dashboard';
$route['delete-project']='dashboard/DashboardController/deleteProject';
$route['export-dashboard-project']='dashboard/DashboardController/exportDashboardProject';
$route['my-project-list/(:any)'] = 'dashboard/DashboardController/myProjectList/$1';
$route['my-calendar']='dashboard/DashboardController/myCalendar';
$route['my-settings']='dashboard/DashboardController/mySettings';
$route['update-ac-data']='dashboard/DashboardController/updateACData';
$route['remove-images']='dashboard/DashboardController/removeImages';
$route['delete-account']='dashboard/DashboardController/deleteAccount';
$route['create-project']='dashboard/DashboardController/createProject';
$route['detail-project']='dashboard/DashboardController/detailProject';
$route['export-project-detail-assign-centers']='dashboard/DashboardController/exportProjectDetailAssignCenter';
$route['detail-exam-center']='dashboard/DashboardController/detailExamCenter';
$route['view-project-detail']='dashboard/DashboardController/viewProjectDetail';
$route['update-center-booking-status']='dashboard/DashboardController/upateCenterBookingStatus';
$route['help-support']='dashboard/DashboardController/helpSupport';
$route['update-company-information']='dashboard/DashboardController/updateCompanyInformation';
$route['update-profile-picture']='dashboard/DashboardController/updateProfilePicture';
$route['update-personal-information']='dashboard/DashboardController/updatePersonalInformation';
$route['edit-project/(:any)'] = 'dashboard/DashboardController/editProject/$1';
$route['update-project'] = 'dashboard/DashboardController/updateProject';

$route['dashboard/client-project/client-negotiation'] =
'dashboard/DashboardController/openClientNegotiationModal';
$route['dashboard/client-project/save-client-negotiation'] =
'dashboard/DashboardController/saveClientNegotiation';
$route['dashboard/client-project/negotiation-history'] =
'dashboard/DashboardController/getClientNegotiationHistory';
$route['dashboard/client-project/accept-negotiation'] =
'dashboard/DashboardController/acceptClientNegotiation';



// ==================================API===============================

// =========================
// Client API ROUTES (v1)
// =========================
$route['api/v1/client/check-phone-exists']        = 'api/v1/AuthAPIController/checkPhoneExists';
$route['api/v1/client/send-otp']                  = 'api/v1/AuthAPIController/sendOtp';
$route['api/v1/client/resend-otp']                = 'api/v1/AuthAPIController/resendOtp';
$route['api/v1/client/verify-otp']                = 'api/v1/AuthAPIController/verifyOtp';

$route['api/v1/client/forgot-mpin/send-otp']      = 'api/v1/AuthAPIController/sendForgotMpinOtp';
$route['api/v1/client/forgot-mpin/verify-otp']    = 'api/v1/AuthAPIController/verifyForgotMpinOtp';
$route['api/v1/client/forgot-mpin/reset']         = 'api/v1/AuthAPIController/resetForgotMpin';


$route['api/v1/client/register']                  = 'api/v1/AuthAPIController/doRegister';
$route['api/v1/client/login']                     = 'api/v1/AuthAPIController/login';
$route['api/v1/client/logout']                    = 'api/v1/AuthAPIController/logout';


// =========================
// COMMON API ROUTES (v1)
// =========================
$route['api/v1/get-country-list'] = 'api/v1/CommmonAPIController/getCountryList';
$route['api/v1/get-state-list'] = 'api/v1/CommmonAPIController/getStateList';
$route['api/v1/get-city-list'] = 'api/v1/CommmonAPIController/getCityList';
$route['api/v1/get-bank-name'] = 'api/v1/CommmonAPIController/getBankName';
$route['api/v1/get-all-cities'] = 'api/v1/CommmonAPIController/getAllCities';

// =========================
// DASHBOARD API ROUTES (v1)
// =========================
$route['api/v1/client/dashboard']        = 'api/v1/DashboardAPIController/dashboard';
$route['api/v1/client/delete-account']   = 'api/v1/DashboardAPIController/deleteAccount';


// =========================
// PROJECT API ROUTES (v1)
// =========================
$route['api/v1/client/create-project']   = 'api/v1/ProjectAPIController/createProject';
$route['api/v1/client/edit-project/(:any)'] = 'api/v1/ProjectAPIController/editProject/$1';
$route['api/v1/client/update-project']   = 'api/v1/ProjectAPIController/updateProject';
$route['api/v1/client/get-project-detail']   = 'api/v1/ProjectAPIController/detailProject';
$route['api/v1/client/delete-project']   = 'api/v1/ProjectAPIController/deleteProject';
$route['api/v1/client/view-project-detail']   = 'api/v1/ProjectAPIController/viewProjectDetail';
$route['api/v1/client/view-exam-center-detail']   = 'api/v1/ProjectAPIController/detailExamCenter';
$route['api/v1/client/update-center-booking-status']   = 'api/v1/ProjectAPIController/updateCenterBookingStatus';

// =========================
// CALENDAR API ROUTES (v1)
// =========================
$route['api/v1/client/calendar']   = 'api/v1/CalendarAPIController/myCalendar';


// =========================
// SETTING API ROUTES (v1)
// =========================
$route['api/v1/client/settings']   = 'api/v1/SettingAPIController/mySettings';
$route['api/v1/client/update-profile-picture']   = 'api/v1/SettingAPIController/updateProfilePicture';
$route['api/v1/client/update-company-information']   = 'api/v1/SettingAPIController/updateCompanyInformation';
$route['api/v1/client/update-personal-information']   = 'api/v1/SettingAPIController/updatePersonalInformation';


// =========================
// NEGOTIATION API ROUTES (v1)
// =========================
$route['api/v1/client/fetch-negotiation-data'] = 'api/v1/NegotiationAPIController/fetchNegotiationData';
$route['api/v1/client/save-negotiation'] = 'api/v1/NegotiationAPIController/saveClientNegotiation';
$route['api/v1/client/get-negotiation-history'] = 'api/v1/NegotiationAPIController/getClientNegotiationHistory';
$route['api/v1/client/accept-negotiation'] = 'api/v1/NegotiationAPIController/acceptClientNegotiation';