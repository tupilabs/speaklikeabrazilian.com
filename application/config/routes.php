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

$route['default_controller'] = "home";
$route['404_override'] = '';

$route['captcha/(:any)'] = 'captcha/index/$1';

$route['new'] = 'home';
$route['expression/define'] = 'expression/defines/index';
$route['expression/letter/(:any)'] = 'expression/letter/index/$1';
$route['expression/approve/(:num)'] = 'expression/approve/index/$1';
$route['expression/reject/(:num)'] = 'expression/reject/index/$1';
$route['expression/(:num)/video'] = 'expression/video/index/$1';
$route['expression/(:num)/embed'] = 'expression/embed/index/$1';
$route['expression/(:num)/display_embedded'] = 'expression/display_embedded/index/$1';
$route['expression/(:num)/share'] = 'expression/share/index/$1';
$route['terms-of-service'] = 'terms_of_service';

/* End of file routes.php */
/* Location: ./application/config/routes.php */