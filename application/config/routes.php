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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home/error_view';
$route["administrator/login"] = "AuthAdmin/index" ;
$route["administrator/forgot-password"] = "ForgotPassword/index" ;
$route["administrator/reset-password"] = "ForgotPassword/tm_password_view" ;
$route["Home/Settings"] = "AdminSettings/index" ;
$route["Home/Classes"] = "admin_classes/index" ;
$route["Home/Classes/(:num)"] = "admin_classes/index/$1";
$route["Home/SubClasses"] = "admin_sub_classes/index" ;
$route["Home/New-Students"] = "admin_student_details/index";
$route["Home/View-Students"] = "admin_student_details/view_students";
$route["Home/SubClasses/(:num)"] = "admin_sub_classes/index/$1" ;
$route["Home/View-Students/(:num)"] = "admin_student_details/view_students/$1";
$route["Home/Full-Profile/(:num)"] = "admin_student_details/students_profile/$1";
$route["Home/Update-Student/(:num)"] = "admin_student_details/update_students/$1";
$route["Home/Class-Upgrade"] = "admin_student_details/upgrade_class";
$route["Home/Class-Upgrade/(:num)"] =  "admin_student_details/upgrade_class/$1";
$route["Home/Student-Courses"] = "admin_student_courses/index";
$route["Home/Student-Courses/(:num)"] = "admin_student_courses/index/$1";
$route["Home/Merged-Students"] = "admin_student_courses/manage_merged_courses";
$route["Home/Manage-Sessions"] = "admin_student_courses/manage_sessions";
$route["Home/Manage-Sessions/(:num)"] = "admin_student_courses/manage_sessions/$1";
$route["Home/Manage-Results"] = "admin_student_results/index";
$route["Home/Manage-Results/(:num)"] = "admin_student_results/index/$1";
$route["Home/Add-Results/(:num)"] = "admin_student_results/add_results/$1";
$route["Home/View-Results/(:num)"] = "admin_student_results/view_results/$1";
$route["Home/View-Results/(:num)/(:num)"] = "admin_student_results/view_results/$1/$1";
$route["Home/Manage-Grade"] = "admin_student_results/grade_system";
$route["Home/Manage-Grade/(:num)"] = "admin_student_results/grade_system/$1";
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
