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