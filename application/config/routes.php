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

$route['default_controller'] = "colloquy";
$route['404_override'] = '';
$route['conference/(:num)'] = "conference/view_where/$1";
$route['attendee/(:num)'] = "attendee/view_where/$1";
$route['admin/(:num)'] = "admin/view_where/$1";
$route['admin/conference/(:num)'] = "admin/change_conference/$1";
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
$route['abstract/approve'] = "abstractc/approve";
$route['abstract/publish'] = "abstractc/publish";
$route['abstract/schedule/(:num)'] = "abstractc/schedule/$1";
$route['abstract/alert_selected_attendees'] = "abstractc/alert_selected_attendees";
$route['abstract/alert_rejected_attendees'] = "abstractc/alert_rejected_attendees";
$route['abstract/add_bursary'] = "abstractc/add_bursary";
$route['abstract/pdf/(:num)'] = "abstractc/pdf/$1";
$route['reviewer/abstract/(:num)'] = "reviewer/abstract_view/$1";
$route['reviewer/abstract/assigned/(:num)'] = "reviewer/reviewer_abstracts_by_id/$1";
$route['attendee/abstract'] = "attendee/abstract_view";
$route['page/(:num)'] = "page/view_where/$1";
$route['page/view'] = "page/select_where";
$route['page/schedule/(:num)'] = "page/schedule/$1";
$route['image/(:num)'] = "image/view_where/$1";
$route['doattend/verify/(:num)'] = "attendee/check_ticket/$1";
$route['export/(:any)'] = "csv/generator/$1";
$route['participate'] = "signup";
$route['viewpage/(:num)'] ="colloquy/viewpage/$1";
$route['workshops'] ="colloquy/viewtype/3";
$route['plenaries'] ="colloquy/viewtype/2";
$route['specialsessions'] ="colloquy/viewtype/4";
$route['viewabstracts'] = "colloquy/viewabstracts";
$route['forgot'] = "colloquy/forgot";
$route['reset/(:num)/(:any)'] = "attendee/reset_view/$1/$2";
$route['image/delete/(:num)'] = "image/delete/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
