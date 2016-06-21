<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "fe";

$route['home'] = "fe/index";
	$route['home/(:any)'] = "fe/index";	
	
$route['about_us'] = "fe/about";
	$route['about_us/(:any)'] = "fe/about";	

$route['services'] = "fe/services";
	$route['services/(:any)'] = "fe/services";	

$route['talent'] = "fe/talent";
$route['talent/(:num)'] = "fe/talent/$1";
$route['talent/(:num)/(:any)'] = "fe/talent/$1/$2";
	$route['talent/job/(:any)'] = "fe/view_job/$1";
	$route['talent/apply/(:any)'] = "fe/job_apply/$1";
	$route['talent/register'] = "talent/register";
	$route['talent/register/(:any)'] = "talent/register/$1";
	$route['talent/open_jobs'] = "fe/talent";
$route['forgot_password'] = "fe/forgot_password";

$route['login'] = "talent/login";
$route['logout'] = "talent/logout";
$route['my_account'] = "talent/my_account";
$route['profile'] = "talent/profile";

$route['confirmation/(:any)'] = "talent/confirmation/$1";

$route['thanks'] = "fe/template/thanks";
$route['error'] = "fe/template/error";
$route['create_account'] = "fe/template/create_account";

$route['experiencing_optima'] = "fe/experiencing_optima";
$route['experiencing_optima/(:any)'] = "fe/experiencing_optima";
	#$route['experiencing_optima/(:number)'] = "fe/experiencing_optima";

$route['knowledge_sharing'] = "fe/knowledge_sharing";

$route['contact'] = "fe/contact";	
	$route['contact/(:any)'] = "fe/contact";


$route['admin/login'] = "admin/login";
$route['admin/logout'] = "admin/logout";
$route['admin'] = "admin/panel";
$route['admin/panel'] = "admin/panel";
$route['admin/add_file'] = "admin/add_file";
$route['admin/remove_file/(:num)'] = "admin/remove_file/$1";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
