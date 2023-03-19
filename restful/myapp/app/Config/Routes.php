<?php

namespace Config;
use App\Controllers\Blog;
use App\Controllers\Months;


// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('blog', [Blog::class, 'index']);
$routes->get('blog/comments/(:any)?', 'Blog::comments/$1');
// $routes->get('blog/(:segment)', [Blog::class, 'comments']);
$routes->get('month/(:num)?', 'Months::month/$1');
$routes->get('customers', 'Customers::index');
$routes->get('customers/customer/(:any)?', 'Customers::customer_get');
$routes->get('customers/paginate/(:any)?', 'Customers::paginate_get/$1');

//PUT
$routes->put('customers/customer/(:any)?', 'Customers::customer_put/$1');

//POST
$routes->post('customers/customer/(:any)?', 'Customers::customer_post/$1');

//DELETE
$routes->delete('customers/customer/(:any)?', 'Customers::customer_delete/$1');


$routes->get('testdb/customers', 'Testdb::customers_beta');
$routes->get('testdb/customer/(:any)?', 'Testdb::customer/$1');
$routes->get('testdb/table', 'Testdb::table');
$routes->get('testdb/test_insert', 'Testdb::insert');
$routes->get('testdb/test_insert_many', 'Testdb::insert_many');
$routes->get('testdb/test_update', 'Testdb::update');
$routes->get('testdb/test_delete', 'Testdb::delete');


$routes->get('students_count', 'Homework::alumnos_conteo');
$routes->get('students_list', 'Homework::alumnos_listado');

//Billing routes
$routes->get('billing/(:any)?', 'Billing::invoice/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
