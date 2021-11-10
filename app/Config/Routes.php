<?php

namespace Config;

use CodeIgniter\Router\Router;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers\Front');
$routes->setDefaultController('Front/Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');proyectosrods['namespace' => 'App\Controllers\Front'],

$routes->group('/', ['namespace' => 'App\Controllers\Front'], function ($routes) {
	$routes->add('', 'Home::index', ['as' => 'home']);
	$routes->add('recuperarPassword', 'Home::recoverPassword', ['as' => 'recuperarPassword']);
	$routes->post('validarPassword', 'Home::validateRecoverPassword', ['as' => 'validarPassword']);
	$routes->get('resetPassword', 'Home::resetPassword');
	$routes->post('newPassword', 'Home::validateResetPassword');
	$routes->post('check', 'Home::signIn', ['as' => 'signIn']);
});
$routes->group('menu', function ($routes) {
	$routes->group('bebida', function ($routes) {
		$routes->post('buscarBebida', 'Bebida::buscarBebida', ['namespace' => 'App\Controllers\Menu']);
		$routes->post('listarBebidas', 'Bebida::listarBebidas', ['namespace' => 'App\Controllers\Menu']);
		$routes->post('editarBebida', 'Bebida::editarBebida', ['namespace' => 'App\Controllers\Menu', 'as' => 'editarBebida']);
		$routes->post('agregarBebida', 'Bebida::agregarBebida', ['namespace' => 'App\Controllers\Menu', 'as' => 'agregarBebida']);
	});

	$routes->group('plato', function ($routes) {
		$routes->post('listarPlatos', 'Plato::listarPlatos', ['namespace' => 'App\Controllers\Menu']);
		$routes->post('buscarPlato', 'Plato::buscarPlato', ['namespace' => 'App\Controllers\Menu']);
		$routes->post('agregarPlato', 'Plato::agregarPlato', ['namespace' => 'App\Controllers\Menu', 'as' => 'agregarPlato']);
		$routes->post('modificarPlato', 'Plato::modificarPlato', ['namespace' => 'App\Controllers\Menu', 'as' => 'modificarPlato']);
	});




	$routes->group('promocion', function ($routes) {
		$routes->post('buscarPromocion', 'Promocion::buscarPromocion', ['namespace' => 'App\Controllers\Menu', 'as' => 'buscarPromocion']);
		$routes->post('editarPromocion', 'Promocion::editarPromocion', ['namespace' => 'App\Controllers\Menu', 'as' => 'editarPromocion']);
		$routes->post('agregarPromocion', 'Promocion::agregarPromocion', ['namespace' => 'App\Controllers\Menu', 'as' => 'agregarPromocion']);
		$routes->post('consultarPromocion', 'Promocion::consultarPromocion', ['namespace' => 'App\Controllers\Menu', 'as' => 'consultarPromocion']);
	});
});
$routes->group('auth', ['namespace' => 'App\Controllers\Auth',], function ($routes) {
	$routes->add('register', 'Signup::index');
	$routes->post('store', 'Signup::store');
});

$routes->group('chef', ['namespace' => 'App\Controllers\Chef', 'filter' => 'auth:Chef'], function ($routes) {
	$routes->add('home', 'Chef::index', ['as' => 'homeChef']);
	$routes->add('infoChef', 'Chef::infoChef', ['as' => 'infoChef']);
	$routes->add('signout', 'Chef::signout', ['as' => 'signoutChef']);
	$routes->add('report', 'Chef::report', ['as' => 'reportChef']);
	$routes->add('reportePlato', 'Chef::crearReporteChef');
	$routes->post('imprimirReporteChef', 'Chef::imprimirReporteChef');
	// $routes->add('food', 'Chef::foodManager',['as'=>'foodManager']);
	$routes->add('foodAdd', 'Chef::foodAdd', ['as' => 'foodAdd']);
	$routes->add('foodEdit', 'Chef::foodEdit', ['as' => 'foodEdit']);
	$routes->post('guardarInfoPersonal', 'Chef::guardarInfoPersonalChef', ['as' => 'guardarInfoPersonalChef']);
	$routes->post('guardarPassword', 'Chef::guardarPasswordChef', ['as' => 'guardarPasswordChef']);
});
//'namespace' => 'App\Controllers\Admin', 
$routes->group('admin', ['filter' => 'auth:Administrador'], function ($routes) {
	$routes->add('', 'Admin::index', ['as' => 'homeAdmin', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('infoAdmin', 'Admin::infoAdmin', ['as' => 'infoAdmin', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('signout', 'Admin::signout', ['as' => 'signoutAdmin', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('promocionEdit', 'Admin::promocionEdit', ['as' => 'promocionEdit', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('promocionAdd', 'Admin::promocionAdd', ['as' => 'promocionAdd', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('encuesta', 'Admin::encuesta', ['as' => 'encuesta', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('drinkAdd', 'Admin::drinkAdd', ['as' => 'drinkAdd', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('drinkEdit', 'Admin::drinkEdit', ['as' => 'drinkEdit', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('report', 'Admin::report', ['as' => 'reportAdmin', 'namespace' => 'App\Controllers\Admin']);
	$routes->add('reporteRanking', 'Admin::crearReporte', ['namespace' => 'App\Controllers\Admin']);
	$routes->post('imprimirReporte', 'Admin::imprimirReporte', ['as' => 'imprimirReporte', 'namespace' => 'App\Controllers\Admin']);
	$routes->post('verificarPenalidades', 'Admin::verificarPenalidades', ['namespace' => 'App\Controllers\Admin']);
	$routes->group('reporte', function ($routes) {
		$routes->post('validarReporte', 'Reporte::validarReporte', ['as' => 'validarReporte', 'namespace' => 'App\Controllers\Reporte']);
		$routes->post('validarReportepas', 'Reporte::validarReportePas', ['as' => 'validarReportepas', 'namespace' => 'App\Controllers\Reporte']);
	});
	$routes->post('cargarDatosCliente', 'Admin::cargarDatosCliente', ['namespace' => 'App\Controllers\Admin']);
	$routes->post('validarModificarCliente', 'Admin::validarModificarCliente', ['namespace' => 'App\Controllers\Admin']);
	$routes->post('guardarCliente', 'Admin::guardarCliente', ['namespace' => 'App\Controllers\Admin']);
	$routes->post('borrarCliente', 'Admin::borrarCliente', ['namespace' => 'App\Controllers\Admin']);
	$routes->post('habilitarCliente', 'Admin::habilitarCliente', ['namespace' => 'App\Controllers\Admin']);
	$routes->post('modificarEncuesta', 'Admin::modificarEncuesta', ['namespace' => 'App\Controllers\Admin']);
	// $routes->add('tableEdit', 'Admin::tableEdit',['as'=>'tableEdit']);
	$routes->add('listadoClientes', 'Admin::listadoClientes', ['as' => 'listadoClientes', 'namespace' => 'App\Controllers\Admin']);
	$routes->post('guardarInfoPersonal', 'Admin::guardarInfoPersonal', ['as' => 'guardarInfoPersonalAdmin', 'namespace' => 'App\Controllers\Admin']);
	$routes->post('guardarPassword', 'Admin::guardarPassword', ['as' => 'guardarPasswordAdmin', 'namespace' => 'App\Controllers\Admin']);
});
//'namespace' => 'App\Controllers\Client',
$routes->group('clients', ['filter' => 'auth:Cliente'], function ($routes) {
	$routes->add('', 'Client::index', ['as' => 'homeClient', 'namespace' => 'App\Controllers\Client']);
	$routes->add('infoClient', 'Client::infoClient', ['as' => 'infoClient', 'namespace' => 'App\Controllers\Client']);
	$routes->add('signout', 'Client::signout', ['as' => 'signoutClient', 'namespace' => 'App\Controllers\Client']);
	$routes->group('listado', function ($routes) {
		$routes->add('bebidas', 'Bebida::index', ['as' => 'listado_bebidas_cliente', 'namespace' => 'App\Controllers\Menu']);
		$routes->add('platos', 'Plato::index', ['as' => 'listado_platos_cliente', 'namespace' => 'App\Controllers\Menu']);
	});
	$routes->group('mis-reservas', function ($routes) {
		$routes->add('reservasCanceladas', 'Client::reservasCanceladas', ['as' => 'reservasCanceladasClient', 'namespace' => 'App\Controllers\Client']);
		$routes->add('reservasEnCurso', 'Client::reservasEnCurso', ['as' => 'reservasEnCursoClient', 'namespace' => 'App\Controllers\Client']);
		$routes->add('reservasRealizadas', 'Client::reservasRealizadas', ['as' => 'reservasRealizadasClient', 'namespace' => 'App\Controllers\Client']);
	});
	$routes->group('reservar', function ($routes) {
		$routes->add('', 'Client::reserva', ['as' => 'reservarClient', 'namespace' => 'App\Controllers\Client']);
		$routes->post('consultarReserva', 'Client::consultarReserva', ['as' => 'consultarReserva', 'namespace' => 'App\Controllers\Client']);
		$routes->post('guardarReserva', 'Client::guardarReserva', ['as' => 'guardarReserva', 'namespace' => 'App\Controllers\Client']);
		$routes->post('cancelarReserva', 'Client::cancelarReserva', ['as' => 'cancelarReserva', 'namespace' => 'App\Controllers\Client']);
		$routes->post('obtenerReservaCliente', 'Client::obtenerReservaCliente', ['as' => 'obtenerReservaCliente', 'namespace' => 'App\Controllers\Client']);
		$routes->post('modificarDatosReserva', 'Client::modificarDatosReserva', ['as' => 'modificarDatosReserva', 'namespace' => 'App\Controllers\Client']);
		$routes->post('modificarPedidoPlatoBebidaCliente', 'Client::modificarPedidoPlatoBebidaCliente', ['as' => 'modificarPedidoPlatoBebidaCliente', 'namespace' => 'App\Controllers\Client']);
	});

	$routes->post('guardarInfoPersonal', 'Client::guardarInfoPersonal', ['as' => 'guardarInfoPersonalClient', 'namespace' => 'App\Controllers\Client']);
	$routes->post('guardarPassword', 'Client::guardarPassword', ['as' => 'guardarPasswordClient', 'namespace' => 'App\Controllers\Client']);

	$routes->add('encuesta', 'Client::completarEncuesta', ['as' => 'completarEncuesta', 'namespace' => 'App\Controllers\Client']);
	$routes->add('enviarEncuesta', 'Client::enviarEncuesta', ['as' => 'enviarEncuesta', 'namespace' => 'App\Controllers\Client']);
});
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
