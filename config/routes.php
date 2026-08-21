<?php
defined('BASEPATH') or exit('No direct script access allowed');
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

// ==============Login====================
$route['login'] = 'AuthController/index';
$route['do-login'] = 'AuthController/doLogin';
$route['admin/logout'] = 'AuthController/logout';
$route['cms/(:any)'] = 'AuthController/viewCms/$1';


/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
// Dashboard
$route['admin/dashboard'] = 'dashboard/DashboardController/index';
$route['admin/profile']        = 'dashboard/DashboardController/profile';
$route['admin/profile-update'] = 'dashboard/DashboardController/updateProfile';

// Clients
$route['admin/clients']              = 'dashboard/ClientController/index';
$route['admin/clients/ajax-list']    = 'dashboard/ClientController/ajaxList';
$route['admin/clients/bulk-action']  = 'dashboard/ClientController/bulkAction';
$route['admin/clients/export']       = 'dashboard/ClientController/export';
$route['admin/client-view/(:any)']   = 'dashboard/ClientController/viewClientDetail/$1';
$route['admin/clients/change-status'] = 'dashboard/ClientController/changeStatus';
$route['admin/clients/restore-client'] = 'dashboard/ClientController/restoreClient';

// Client Project
$route['admin/client-projects']           = 'dashboard/ClientProjectController/index';
$route['admin/client-projects/ajax-list'] = 'dashboard/ClientProjectController/ajaxList';
$route['admin/client-projects/export']    = 'dashboard/ClientProjectController/export';
$route['admin/client-project-detail-list/(:any)'] = 'dashboard/ClientProjectController/clientProjectDetailList/$1';
$route['admin/update-admin-seat-price'] = 'dashboard/ClientProjectController/updateAdminSeatPrice';
$route['admin/find-exam-center/(:any)/(:num)'] = 'dashboard/ClientProjectController/findExamCenter/$1/$2';
$route['admin/send-booking-request/(:any)/(:num)/(:num)'] = 'dashboard/ClientProjectController/sendBookingRequest/$1/$2/$3';
$route['admin/view-project-detail/(:any)/(:any)'] = 'dashboard/ClientProjectController/viewProjectDetails/$1/$2';
$route['admin/project-overview/(:any)/(:any)'] = 'dashboard/ClientProjectController/projectOverview/$1/$2';
$route['admin/update-client-project-status'] = 'dashboard/ClientProjectController/updateProjectStatus';
$route['admin/update-project-book-flag'] = 'dashboard/ClientProjectController/updateProjectBookFlag';


// Client Booking
$route['admin/booking-request-status/(:any)/(:num)'] = 'dashboard/ClientProjectBookingController/checkBookingRequestStatus/$1/$2';
$route['admin/update-admin-booking-status'] =
  'dashboard/ClientProjectBookingController/updateAdminBookingStatus';
$route['admin/bulk-approve-booking'] =
  'dashboard/ClientProjectBookingController/bulkApproveBooking';
$route['admin/update-send-booking-price'] = 'dashboard/ClientProjectBookingController/updateSendBookingPrice';
$route['admin/save-client-negotiation'] = 'dashboard/ClientProjectBookingController/saveClientNegotiation';
$route['admin/client-negotiation-history'] = 'dashboard/ClientProjectBookingController/getClientNegotiationHistory';
$route['admin/reset-client-negotiation'] = 'dashboard/ClientProjectBookingController/resetClientNegotiation';
$route['admin/client-counter-negotiation'] = 'dashboard/ClientProjectBookingController/clientCounterNegotiation';
$route['admin/client-finalize-negotiation'] = 'dashboard/ClientProjectBookingController/clientFinalizeNegotiation';
$route['admin/client-negotiation-management/(:any)'] =
  'dashboard/ClientProjectBookingController/clientNegotiationManagement/$1';
$route['dashboard/accept-client-negotiation'] =
  'dashboard/ClientProjectBookingController/acceptClientNegotiation';
$route['admin/get-allocation-modal'] =
  'dashboard/ClientProjectBookingController/getAllocationModal';
  $route['admin/update-allocation'] =
  'dashboard/ClientProjectBookingController/updateAllocation';


// Client Planner
$route['admin/project-planner'] = 'dashboard/ClientProjectPlannerController/index';
$route['admin/project-planner/ajax-list'] =
  'dashboard/ClientProjectPlannerController/ajaxPlannerList';
$route['admin/project-planner/stats']
  = 'dashboard/ClientProjectPlannerController/getPlannerStats';

// Center
$route['admin/centers']           = 'dashboard/CenterController/index';
$route['admin/centers/ajax-list'] = 'dashboard/CenterController/ajaxList';
$route['admin/centers/export']    = 'dashboard/CenterController/export';
$route['admin/center-edit-request'] = 'dashboard/CenterController/getCenterEditRequests';
$route['admin/approve-center-edit/(:num)'] = 'dashboard/CenterController/approveCenterEdit/$1';
$route['admin/reject-center-edit/(:num)']  = 'dashboard/CenterController/rejectCenterEdit/$1';
$route['admin/view-exam-center/(:any)'] = 'dashboard/CenterController/viewExamCenter/$1';
$route['admin/view-exam-center-history/(:any)'] = 'dashboard/CenterController/viewExamCenterHistory/$1';
$route['admin/center-self-booking/(:any)'] = 'dashboard/CenterController/centerSelfBookingList/$1';
$route['admin/self-booking/ajax-list'] = 'dashboard/CenterController/selfBookingAjaxList';
$route['admin/center-self-booking/view/(:any)'] = 'dashboard/CenterController/viewCenterSelfBookingList/$1';
$route['admin/center/delete'] = 'dashboard/CenterController/deleteCenter';
$route['admin/center/toggle-approval'] = 'dashboard/CenterController/toggleApprovalStatus';
$route['admin/center/upload-audit'] = 'dashboard/CenterController/uploadAuditFile';

$route['admin/center/get-states'] = 'dashboard/CenterController/getStates';
$route['admin/center/get-cities'] = 'dashboard/CenterController/getCities';
$route['admin/export-center-pdf/(:any)'] = 'dashboard/CenterController/exportCenterPdf/$1';
$route['admin/download-center-images/(:num)'] = 'dashboard/CenterController/downloadCenterImages/$1';
$route['admin/center-logs/(:num)'] = 'dashboard/CenterController/centerLogs/$1';
$route['admin/download-center-image'] = 'dashboard/CenterController/downloadCenterImage';
$route['admin/view-assign-manpower'] = 'dashboard/CenterController/getAssignedManpower';
$route['admin/center-history-export-excel/(:num)'] = 'dashboard/CenterController/centerHistoryExportExcel/$1';
$route['admin/center-history-export-pdf/(:num)']   = 'dashboard/CenterController/centerHistoryExportPdf/$1';


// Center Owners
$route['admin/center-owners']           = 'dashboard/CenterOwnerController/index';
$route['admin/center-owners/ajax-list'] = 'dashboard/CenterOwnerController/ajaxList';
$route['admin/center-owners/export']    = 'dashboard/CenterOwnerController/export';
$route['admin/center-owner/change-status'] = 'dashboard/CenterOwnerController/changeStatus';
$route['admin/center-owner/bulk-action']  = 'dashboard/CenterOwnerController/bulkAction';

$route['admin/center-owners/delete-owner']  = 'dashboard/CenterOwnerController/deleteOwner';
$route['admin/center-owners/restore-owner']  = 'dashboard/CenterOwnerController/restoreOwner';

// Delted Center
$route['admin/deleted-centers']           = 'dashboard/DeletedCenterController/index';
$route['admin/deleted-centers/ajax-list'] = 'dashboard/DeletedCenterController/ajaxList';
$route['admin/deleted-centers/retrieve']  = 'dashboard/DeletedCenterController/retrieveCenter';

// Center Calendar
$route['admin/center-calendar']                 = 'dashboard/CenterCalendarController/center_calendar';
$route['admin/center-calendar/view/(:num)']     = 'dashboard/CenterCalendarController/view_center_calendar/$1';
$route['admin/center-calendar/(:any)']          = 'dashboard/CenterCalendarController/viewCenterCalendar/$1';
$route['admin/view-get-center-calendar']        = 'dashboard/CenterCalendarController/viewGetCenterCalendar';
$route['admin/view-get-center-bookings-by-date']        = 'dashboard/CenterCalendarController/viewGetCenterBookingsByDate';

// New
$route['admin/get-calendar-summary'] = 'dashboard/CenterCalendarController/get_calendar_summary';
$route['admin/get-month-counts'] = 'dashboard/CenterCalendarController/get_month_counts';

// AJAX
$route['admin/get-calendar']                   = 'dashboard/CenterCalendarController/get_calendar';
$route['admin/get-bookings-by-date']           = 'dashboard/CenterCalendarController/get_bookings_by_date';
$route['admin/get-booking-statistics']         = 'dashboard/CenterCalendarController/get_booking_statistics';

// Calendar View
$route['admin/view-get-calendar']              = 'dashboard/CenterCalendarController/view_get_center_calendar';
$route['admin/view-get-bookings-by-date']      = 'dashboard/CenterCalendarController/view_get_center_bookings_by_date';

//Center Availability
$route['admin/center-availability'] = 'dashboard/CenterAvailabilityController/index';
$route['admin/center-availability/ajaxList'] = 'dashboard/CenterAvailabilityController/ajaxList';

// Custom News
$route['admin/custom-news']                 = 'dashboard/CustomNewsController/index';
$route['admin/custom-news/ajax-list']       = 'dashboard/CustomNewsController/ajaxList';
$route['admin/custom-news/store']           = 'dashboard/CustomNewsController/store';
$route['admin/custom-news/edit/(:num)']     = 'dashboard/CustomNewsController/edit/$1';
$route['admin/custom-news/update/(:num)']   = 'dashboard/CustomNewsController/update/$1';
$route['admin/custom-news/delete/(:num)']   = 'dashboard/CustomNewsController/delete/$1';
$route['admin/custom-news/link-preview']    = 'dashboard/CustomNewsController/linkPreview';
$route['admin/custom-news/change-status']   = 'dashboard/CustomNewsController/changeStatus';

// Custom Setting
$route['admin/custom-settings'] = 'dashboard/CustomSettingsController/index';
$route['admin/custom-settings/add-company-logo'] = 'dashboard/CustomSettingsController/addCompanyLogo';
$route['admin/custom-settings/delete-company-logo/(:num)'] = 'dashboard/CustomSettingsController/deleteCompanyLogo/$1';

// Notification
$route['admin/mark-read'] = 'dashboard/NotificationsController/mark_read';
$route['admin/remove'] = 'dashboard/NotificationsController/remove';
$route['admin/mark-all'] = 'dashboard/NotificationsController/mark_all';
$route['admin/notifications'] = 'dashboard/NotificationsController/allNotificationList';

// CMS
$route['admin/cms']                 = 'dashboard/CmsController/index';
$route['admin/cms/ajax-list']       = 'dashboard/CmsController/ajaxList';
$route['admin/cms/create']          = 'dashboard/CmsController/create';
$route['admin/cms/store']           = 'dashboard/CmsController/store';
$route['admin/cms/edit/(:num)']     = 'dashboard/CmsController/edit/$1';
$route['admin/cms/update/(:num)']   = 'dashboard/CmsController/update/$1';
$route['admin/cms/change-status']   = 'dashboard/CmsController/changeStatus';

//Roles
$route['admin/roles']                = 'dashboard/RoleController/index';
$route['admin/role/ajax-list']       = 'dashboard/RoleController/ajaxList';
$route['admin/role/create']          = 'dashboard/RoleController/create';
$route['admin/role/store']           = 'dashboard/RoleController/store';
$route['admin/role/edit/(:num)']     = 'dashboard/RoleController/edit/$1';
$route['admin/role/update/(:num)']   = 'dashboard/RoleController/update/$1';
$route['admin/role/change-status']   = 'dashboard/RoleController/changeStatus';
$route['admin/role/delete/(:num)']   = 'dashboard/RoleController/delete/$1';

//Subadmin
$route['admin/subadmins']                = 'dashboard/SubadminController/index';
$route['admin/subadmin/ajax-list']       = 'dashboard/SubadminController/ajaxList';
$route['admin/subadmin/create']          = 'dashboard/SubadminController/create';
$route['admin/subadmin/store']           = 'dashboard/SubadminController/store';
$route['admin/subadmin/edit/(:num)']     = 'dashboard/SubadminController/edit/$1';
$route['admin/subadmin/update/(:num)']   = 'dashboard/SubadminController/update/$1';
$route['admin/subadmin/change-status']   = 'dashboard/SubadminController/changeStatus';
$route['admin/subadmin/delete/(:num)']   = 'dashboard/SubadminController/delete/$1';


/*
|--------------------------------------------------------------------------
| Subscription Packages
|--------------------------------------------------------------------------
*/

$route['admin/subscription-packages']             = 'admin/SubscriptionPackage/index';
$route['admin/subscription-packages/create']      = 'admin/SubscriptionPackage/create';
$route['admin/subscription-packages/store']       = 'admin/SubscriptionPackage/store';

$route['admin/subscription-packages/edit/(:num)'] = 'admin/SubscriptionPackage/edit/$1';
$route['admin/subscription-packages/update']      = 'admin/SubscriptionPackage/update';

$route['admin/subscription-packages/delete/(:num)'] = 'admin/SubscriptionPackage/delete/$1';


/*
|--------------------------------------------------------------------------
| Transaction Package
|--------------------------------------------------------------------------
*/
$route['admin/transaction-package']            = 'admin/TransactionPackage/index';
$route['admin/transaction-package/ajax-list']  = 'admin/TransactionPackage/ajaxList';
$route['admin/transaction-package/view/(:num)'] = 'admin/TransactionPackage/view/$1';
