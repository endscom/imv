<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/******** MIS RUTAS **********/
// LOGIN
$route['login'] = 'login_controller/Acreditar';
$route['salir'] = 'login_controller/Salir';
$route['cambiarPass'] = 'login_controller/cambiarPass';
// FIN LOGIN

// RUTAS MENU
$route['Main'] = 'vista_controller/main';

/* CLIENTES */
$route['Clientes'] = 'clientes_controller/Clientes';


/*USUARIOS*/
$route['Usuarios'] = 'vista_controller/Usuarios'; //cargar usuarios
/*USUARIOS*/

// RUTA FACTURAS
$route['facturas'] = 'facturas_controller';
$route['detallefacturas/(:any)'] = 'facturas_controller/detallefacturas/$1';

// RUTA REPORTES
$route['Reportes'] = 'reportes_controller';
$route['cuentaXcliente'] = 'reportes_controller/cuentaXcliente';
$route['datosCliente/(:any)'] = 'reportes_controller/datosCliente/$1';
$route['masterClientes/(:any)/(:any)'] = 'reportes_controller/masterClientes/$1/$2';
$route['masterCompras/(:any)/(:any)'] = 'reportes_controller/masterCompras/$1/$2';
$route['canjePremios/(:any)/(:any)'] = 'reportes_controller/canjePremios/$1/$2';
$route['masterFacturas/(:any)/(:any)'] = 'reportes_controller/masterFacturas/$1/$2';
$route['reporteXfecha/(:any)/(:any)'] = 'reportes_controller/reporteXfecha/$1/$2';
$route['movimientoProductos/(:any)/(:any)'] = 'reportes_controller/movimientoProductos/$1/$2';
$route['clientes_nuevos/(:any)/(:any)'] = 'reportes_controller/clientes_nuevos/$1/$2';
$route['mas_vendidos/(:any)/(:any)'] = 'reportes_controller/mas_vendidos/$1/$2';
$route['menos_vendidos/(:any)/(:any)'] = 'reportes_controller/menos_vendidos/$1/$2';
$route['puntosXcliente/(:any)/(:any)'] = 'reportes_controller/puntosXcliente/$1/$2';
$route['canjes/(:any)/(:any)'] = 'reportes_controller/canjes/$1/$2';
$route['canje_premios/(:any)/(:any)'] = 'reportes_controller/canje_premios/$1/$2';
$route['detalles_canje/(:any)/(:any)'] = 'reportes_controller/detalles_canje/$1/$2';
$route['CXCprint/(:any)/(:any)/(:any)'] = 'reportes_controller/CXCprint/$1/$2/$3';
$route['informeFactura/(:any)'] = 'reportes_controller/informeFactura/$1';

/*RUTAS DE DATOS*/
$route['datos'] = 'datos_controller/index';
$route['subirdatos'] = 'datos_controller/subir';
$route['descartarDatos'] = 'datos_controller/descartarDatos';
$route['viewDatos/(:any)/(:any)'] = 'datos_controller/viewDatos/$1/$2';


// RUTA IMPRESION
$route['DetalleFRP'] = 'impresion_controller/DetalleFRP';
$route['DetalleFRE/(:any)'] = 'impresion_controller/DetalleFRE/$1';
// FIN IMPRESION

// RUTA EXPORTACIÓN
$route['Exp_Clientes'] = 'exportacion_controller/ExpoClients';
$route['ExpPDF'] = 'exportacion_controller/ExpoPdf';
$route['ExpPDF_PuntosClientes'] = 'exportacion_controller/ExpPDF_PuntosClientes';
$route['ExpEXCEL_PuntosClientes'] = 'exportacion_controller/ExpEXCEL_PuntosClientes';
$route['pdfCTAxCLIENTE/(:any)/(:any)/(:any)'] = 'exportacion_controller/pdfCTAxCLIENTE/$1/$2/$3';
$route['excelCTAxCLIENTE'] = 'exportacion_controller/excelCTAxCLIENTE';
$route['ExpPDFEstadoCuenta'] ='exportacion_controller/ExpPDFEstadoCuenta';
// FIN EXPORTACIÓN