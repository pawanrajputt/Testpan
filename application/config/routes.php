<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = "AuthController";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ===========CMS===========
$route['cms/(:any)']='AuthController/cmsPage/$1';

// ==============Center Owner====================
$route['center-owner-dashboard'] = 'AuthController/centerOwnerDashabord';
$route['select-center/(:num)'] = 'AuthController/selectCenter/$1';
$route['do-login']='AuthController/login';
$route['logout']='AuthController/logout';
$route['reset-forgot-mpin']='AuthController/resetForgotMpin';
$route['send-reset-forgot-mpin-otp']='AuthController/sendResetForgotMpinOtp';
$route['reset-forgot-mpin-otp']='AuthController/resetForgotMpinOtp';
$route['verify-reset-forgot-mpin-otp']='AuthController/verifyResetForgotMpinOtp';
$route['new-mpin-set']='AuthController/newMpinSet';
$route['update-new-mpin-set']='AuthController/updateNewMpinSet';
$route['owner-profile']         = 'AuthController/profile';
$route['owner-profile-update']  = 'AuthController/updateProfile';
$route['owner-reset-mpin']      = 'AuthController/resetMpin';
$route['owner-help-support']    = 'AuthController/helpAndSupport';
$route['owner-center-calendar']             = 'AuthController/center_calendar';
$route['owner-get-calendar']                = 'AuthController/get_calendar';
$route['owner-get-bookings-by-date']        = 'AuthController/get_bookings_by_date';
$route['owner-all-notifications']           = 'AuthController/ownerAllCentersNotification';

// ======================== Create Center =========================
$route['create-center'] = 'CenterManagementController/index';
$route['store-exam-center-data']='CenterManagementController/storeExamCenterData';

// Basic route
$route['signup']='AuthController/index';
$route['check-phone-exists']='AuthController/checkPhoneExists';
$route['send-otp']='AuthController/sendOtp';
$route['resend-otp']='AuthController/resendOtp';
$route['verify-otp']='AuthController/verifyOtp';
$route['store-mpin']='AuthController/storeMpin';
$route['center-logout'] = 'AuthController/centerLogout';
$route['fetch-state-by-country-id']='AuthController/fetchStateByCountryId';
$route['fetch-city-by-state-id']='AuthController/fetchCityByStateId';
$route['delete-owner-account'] = 'AuthController/deleteOwnerAccount';

// Subscription
$route['subscription-plans'] = 'SubscriptionPackage/subscriptionPlans';

$route['purchase-package/(:num)']
    = 'SubscriptionPackage/purchasePackage/$1';

$route['payment-success']
    = 'SubscriptionPackage/paymentSuccess';

$route['payment-failed']
    = 'SubscriptionPackage/paymentFailed';

$route['payment-callback']
    = 'SubscriptionPackage/paymentCallback';

$route['subscription-history']
    = 'SubscriptionPackage/subscriptionHistory';


// Center Dashboard
$route['dashboard']='booking/DashboardController/dashboard';


$route['my-calendar']='booking/DashboardController/myCalendar';
$route['update-exam-center-data']='booking/DashboardController/updateExamCenterData';
$route['remove-images']='booking/DashboardController/removeImages';
$route['detail-project']='booking/DashboardController/detailProject';
$route['update-booking-status']='booking/DashboardController/updateBookingStatus';
$route['fetch-reject-booking-content']='booking/DashboardController/fetchRejectBookingContent';
$route['fetch-negotiate-booking-content']='booking/DashboardController/fetchNegotiateBookingContent';
$route['reject-booking-status']='booking/DashboardController/rejectBookingStatus';
$route['get_booking_details']='booking/DashboardController/get_booking_details';
$route['get_calendar']='booking/DashboardController/get_calendar';


// Self Booking
$route['my-self-booking']='booking/SelfBookingController/mySelfBooking';
$route['export-self-booking']='booking/SelfBookingController/exportSelfBooking';
$route['create-self-booking']='booking/SelfBookingController/createSelfBooking';
$route['fetch-booking-view-by-id']='booking/SelfBookingController/fetchBookingViewById';
$route['fetch-edit-self-booking-by-id']='booking/SelfBookingController/editSelfBookingById';
$route['update-self-booking']='booking/SelfBookingController/updateSelfBooking';
$route['delete-self-booking']='booking/SelfBookingController/deleteSelfBooking';

// My Center
$route['my-center']='booking/MyCenterController/myCenter';
$route['request-profile-edit']='booking/MyCenterController/requestProfileEdit';

// My Setting
$route['help-support']='booking/SettingController/helpSupport';
$route['settings']='booking/SettingController/settings';
$route['update-setting']='booking/SettingController/updateSetting';
$route['delete-account']='booking/SettingController/deleteAccount';
$route['update-center-logo']='booking/SettingController/updateCenterLogo';

// Notification
$route['center-all-notifications']='booking/NotificationController/centerAllNotification';
$route['center-notification-mark-all-read'] = 'booking/NotificationController/markAllRead';
$route['center-remove-notification/(:num)'] = 'booking/NotificationController/removeNotification/$1';

// ==================================API===============================

// =========================
// OWNER AUTH API ROUTES (v1)
// =========================
$route['api/v1/owner/check-phone-exists']        = 'api/v1/OwnerAuthController/checkPhoneExists';
$route['api/v1/owner/send-otp']                  = 'api/v1/OwnerAuthController/sendOtp';
$route['api/v1/owner/resend-otp']                = 'api/v1/OwnerAuthController/resendOtp';
$route['api/v1/owner/verify-otp']                = 'api/v1/OwnerAuthController/verifyOtp';
$route['api/v1/owner/forgot-mpin/send-otp']      = 'api/v1/OwnerAuthController/sendForgotMpinOtp';
$route['api/v1/owner/forgot-mpin/verify-otp']    = 'api/v1/OwnerAuthController/verifyForgotMpinOtp';
$route['api/v1/owner/forgot-mpin/reset']         = 'api/v1/OwnerAuthController/resetForgotMpin';
$route['api/v1/owner/register']                  = 'api/v1/OwnerAuthController/doRegister';
$route['api/v1/owner/login']                     = 'api/v1/OwnerAuthController/login';
$route['api/v1/owner/logout']                    = 'api/v1/OwnerAuthController/logout';

// =========================
// OWNER API ROUTES (v1)
// =========================
$route['api/v1/owner/dashboard']                 = 'api/v1/OwnerController/dashboard';
$route['api/v1/owner/all-center-list']           = 'api/v1/OwnerController/allCenterListing';
$route['api/v1/owner/profile']                   = 'api/v1/OwnerController/profile';
$route['api/v1/owner/update-profile']            = 'api/v1/OwnerController/updateProfile';
$route['api/v1/owner/reset-mpin']                = 'api/v1/OwnerController/resetMpin';
$route['api/v1/owner/view-center-detail/(:num)'] = 'api/v1/OwnerController/viewCenterDetail/$1';
$route['api/v1/delete-owner-account']            = 'api/v1/OwnerController/deleteOwnerAccountApi';

// Owner Calendar
$route['api/v1/owner/calendar']          = 'api/v1/OwnerCalendarController/get_calendar';
$route['api/v1/owner/bookings-by-date']  = 'api/v1/OwnerCalendarController/get_bookings_by_date';
$route['api/v1/owner/calendar/summary']  = 'api/v1/OwnerCalendarController/get_summary';



// =========================
// API ROUTES (v1)
// =========================
$route['api/v1/get-country-list'] = 'api/v1/CommmonController/getCountryList';
$route['api/v1/get-state-list'] = 'api/v1/CommmonController/getStateList';
$route['api/v1/get-city-list'] = 'api/v1/CommmonController/getCityList';
$route['api/v1/get-center-type'] = 'api/v1/CommmonController/getCenterType';
$route['api/v1/get-news-list'] = 'api/v1/CommmonController/getNewsList';
$route['api/v1/get-setting-list'] = 'api/v1/CommmonController/getSettingList';
$route['api/v1/get-bank-name'] = 'api/v1/CommmonController/getBankName';


// =========================
// AUTH API ROUTES (v1)
// =========================
$route['api/v1/logout']            = 'api/v1/AuthController/logout';
$route['api/v1/store-exam-center'] = 'api/v1/AuthController/storeExamCenterData';


// =========================
// DASHBOARD API ROUTES (v1)
// =========================
$route['api/v1/dashboard'] = 'api/v1/AuthController/dashboard';
$route['api/v1/my-center'] = 'api/v1/AuthController/myCenterApi';
$route['api/v1/request-profile-edit'] = 'api/v1/AuthController/requestProfileEditApi';
$route['api/v1/my-calendar'] = 'api/v1/AuthController/myCalendarApi';
$route['api/v1/my-self-booking'] = 'api/v1/AuthController/mySelfBookingApi';

$route['api/v1/search-booking-request'] = 'api/v1/AuthController/searchBookingRequestApi';
$route['api/v1/get-booking-details'] = 'api/v1/AuthController/getBookingDetailsApi';
$route['api/v1/get-calendar']       = 'api/v1/AuthController/getCalendarApi';
$route['api/v1/project-detail'] = 'api/v1/AuthController/detailProjectApi';
$route['api/v1/update-booking-status'] = 'api/v1/AuthController/updateBookingStatusApi';
$route['api/v1/reject-booking-status'] = 'api/v1/AuthController/rejectBookingStatusApi';


$route['api/v1/self-booking/create'] = 'api/v1/AuthController/createSelfBookingApi';
$route['api/v1/self-booking/view']   = 'api/v1/AuthController/fetchBookingViewByIdApi';
$route['api/v1/self-booking/edit']   = 'api/v1/AuthController/editSelfBookingByIdApi';
$route['api/v1/self-booking/update'] = 'api/v1/AuthController/updateSelfBookingApi';
$route['api/v1/self-booking/delete'] = 'api/v1/AuthController/deleteSelfBookingApi';

$route['api/v1/delete-account'] = 'api/v1/AuthController/deleteAccountApi';

$route['api/v1/update-center']   = 'api/v1/AuthController/updateExamCenterDataApi';
$route['api/v1/settings']        = 'api/v1/AuthController/getSettingsApi';
$route['api/v1/update-settings'] = 'api/v1/AuthController/updateSettingApi';
$route['api/v1/remove-images']   = 'api/v1/AuthController/removeImages';
$route['api/v1/notifications'] = 'api/v1/AuthController/getNotificationsApi';
$route['api/v1/notifications/mark-all-read'] = 'api/v1/AuthController/markAllNotificationsReadApi';
$route['api/v1/notifications/remove'] = 'api/v1/AuthController/removeNotificationApi';


// Visitors
$route['api/v1/increase-visitor-count'] = 'api/v1/Visitor/increaseCount';
$route['api/v1/get-visitor-count'] = 'api/v1/Visitor/getCount';


// Subscription
$route['api/v1/fetch-subscription-packages'] = 'api/v1/SubscriptionPackage/fetchSubscriptionPackages';

$route['api/v1/subscription-packages']
        = 'api/v1/SubscriptionPackage/getPackages';

$route['api/v1/create-subscription-order']
        = 'api/v1/SubscriptionPackage/createOrder';

$route['api/v1/check-subscription-payment']
        = 'api/v1/SubscriptionPackage/checkPaymentStatus';

$route['api/v1/my-subscription']
        = 'api/v1/SubscriptionPackage/mySubscription';

$route['api/v1/subscription-history']
    = 'api/v1/SubscriptionPackage/subscriptionHistory';