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

$route['default_controller'] = "signin";
$route['404_override'] = '';
$route['conference/(:num)'] = "conference/view_where/$1";
$route['attendee/(:num)'] = "attendee/view_where/$1";
$route['admin/(:num)'] = "admin/view_where/$1";
$route['reviewer/(:num)'] = "reviewer/view_where/$1";
$route['comment/(:num)'] = "comment/view_where/$1";
$route['score/abstract/(:num)'] = "score/view_avg/$1";
$route['abstract'] = "abstractc";
$route['abstract/create'] = "abstractc/create";
$route['abstract/upload'] = "abstractc/upload";
$route['abstract/view'] = "abstractc/view";
$route['abstract/(:num)'] = "abstractc/view_where/$1";
$route['abstract/update'] = "abstractc/update";
$route['abstract/delete'] = "abstractc/delete";
$route['abstract/delete_abstractImage'] = "abstractc/delete_abstractImage";
$route['abstract/delete_allAbstractImage'] = "abstractc/delete_allAbstractImage";
$route['abstract/assign'] = "abstractc/assign";
$route['abstract/unassign'] = "abstractc/unassign";
$route['reviewer/abstract/(:num)'] = "reviewer/abstract_view/$1";
$route['reviewer/abstract/assigned/(:num)'] = "reviewer/reviewer_abstracts_by_id/$1";
$route['attendee/abstract'] = "attendee/abstract_view";
$route['page/(:num)'] = "page/view_where/$1";
$route['image/(:num)'] = "image/view_where/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
