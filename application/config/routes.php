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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['portaladmin']								= 'backend/login/index';
$route['portaladmin/auth']							= 'backend/login/auth';

$route['admin/akun']								= 'backend/akun/index';
$route['admin/logout']								= 'backend/logout';
$route['admin/dashboard']							= 'backend/dashboard';
$route['admin/dashboard/stats']						= 'backend/dashboard/stats';

$route['admin/manajemen-user']						= 'backend/manajemen_user/index';
$route['admin/tambah-user']							= 'backend/manajemen_user/tambah';
$route['admin/ubah-user']							= 'backend/manajemen_user/ubah';
$route['admin/hapus-user']							= 'backend/manajemen_user/hapus';

$route['admin/grup-user']							= 'backend/grup_user/index';
$route['admin/tambah-grup']							= 'backend/grup_user/tambah';
$route['admin/ubah-grup']							= 'backend/grup_user/ubah';
$route['admin/hapus-grup']							= 'backend/grup_user/hapus';
$route['admin/grup-user/menu']						= 'backend/grup_user/menu';
$route['admin/grup-user/update-index']				= 'backend/grup_user/update_index';

$route['admin/slide']								= 'backend/slide/index';
$route['admin/tambah-gambar']						= 'backend/slide/tambah';
$route['admin/ubah-gambar']							= 'backend/slide/ubah';
$route['admin/hapus-gambar']						= 'backend/slide/hapus';

$route['admin/running-text']						= 'backend/running_text/index';
$route['admin/tambah-teks']							= 'backend/running_text/tambah';
$route['admin/ubah-teks']							= 'backend/running_text/ubah';
$route['admin/hapus-teks']							= 'backend/running_text/hapus';

$route['admin/operator']							= 'backend/operator/index';
$route['admin/tambah-operator']						= 'backend/operator/tambah';
$route['admin/ubah-operator']						= 'backend/operator/ubah';
$route['admin/hapus-operator']						= 'backend/operator/hapus';

$route['admin/loket']								= 'backend/loket/index';
$route['admin/tambah-loket']						= 'backend/loket/tambah';
$route['admin/ubah-loket']							= 'backend/loket/ubah';
$route['admin/hapus-loket']							= 'backend/loket/hapus';
$route['admin/loket/status']						= 'backend/loket/status';
$route['admin/masuk-loket/([a-zA-Z0-9]+)']			= 'backend/loket/masuk/$1';

$route['admin/transaksi']							= 'backend/transaksi/index';

$route['admin/pengaturan-aplikasi']					= 'backend/pengaturan_aplikasi/index';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
