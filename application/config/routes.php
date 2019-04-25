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
$route['default_controller'] = 'Postulante';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'Login';
$route['login/recoverpassword'] = 'Login/recuperarPassword';
$route['login/restorepassword/(:any)/([A-Za-z0-9]+)'] = 'Login/restablecerPassword/$1/$2';
$route['login/updatePassword'] = 'Login/updatePassword';


$route['registro'] = 'Registro';
$route['registro/enviar'] = 'Registro/guardar';
$route['postulante'] = 'Postulante';
$route['postulante/verificacion'] = 'Postulante/verificacion';


$route['public/api/programas'] = 'Programa/allActives';
$route['public/api/programas/(:num)'] = 'Programa/allActives/$1';
$route['public/api/tipos'] = 'Programa/getTypes';
/*Actualizacion de datos de postulante*/
$route['postulante/guardar/personal'] = 'Postulante/cargaPersonal';
$route['postulante/guardar/laboral'] = 'Postulante/cargaLaboral';
$route['postulante/guardar/academico'] = 'Postulante/cargaAcademico';
$route['postulante/guardar/salud'] = 'Postulante/cargaSalud';
$route['postulante/guardar/referencia'] = 'Postulante/cargaReferencia';
$route['postulante/guardar/otros'] = 'Postulante/cargaOtros';
$route['postulante/salir'] = 'Postulante/cerrarSession';
$route['postulante/solicitar'] = 'Postulante/solicitud';
$route['postulante/pdf/(:num)'] = 'Solicitud/pdf/$1';
$route['postulante/pdf/html/(:num)'] = 'Solicitud/html/$1';
$route['postulante/pdf/data/(:num)'] = 'Solicitud/data/$1';
$route['postulante/solicitud/eliminar/(:num)'] = 'Solicitud/delete/$1';
$route['postulante/password/cambiar'] = 'Usuario/cambiarContraseña';
$route['postulante/upload/cv'] = 'Postulante/uploadCv';
$route['postulante/upload/dj'] = 'Postulante/uploadDeclaracionJurada';
$route['postulante/upload/cp'] = 'Postulante/uploadCopiaDni';
$route['postulante/upload/bach'] = 'Postulante/uploadCopiaBachiller';
$route['postulante/upload/maes'] = 'Postulante/uploadCopiaMaestria';
$route['postulante/upload/doct'] = 'Postulante/uploadCopiaDoctorado';
$route['postulante/upload/sins'] = 'Postulante/uploadSolicitudInscripcion';

$route['postulante/download/cv'] = 'Postulante/downloadCv';
$route['postulante/stateProfileFiles'] = 'Postulante/stateOfProfileFiles';
$route['solicitud/upload/(:num)'] = 'Solicitud/uploadHojaDeDatos/$1';
$route['soladmision/upload/(:num)'] = 'Solicitud/upload_sol_admision/$1';
$route['solicitud/stateFile/(:num)'] = 'Solicitud/stateFile/$1';
$route['soladmision/stateFile/(:num)'] = 'Solicitud/stateFile_sol_admision/$1';

/**
 *  Proyecto de investigacion
 */
$route['proinves/upload/(:num)'] = 'Solicitud/upload_pro_inves/$1';
$route['proinves/stateFile/(:num)'] = 'Solicitud/stateFile_spro_inves/$1';

$route['file/delete/([a-zA-Z]+)/(:num)'] = 'admin/FilesController/eliminar/$1/$2';
$route['file/info/([a-zA-Z]+)'] = 'admin/FilesController/info/$1';

$route['api/alumno'] = 'ApiAlumno';
$route['api/programas'] = 'ApiPrograma';
$route['api/programas/tipos'] = 'ApiPrograma/tipos';
$route['api/solicitudes'] = 'ApiAlumno/solicitudes';
$route['api/pais'] = 'ApiPais/listar';
$route['api/documents'] = 'ApiAlumno/documents';

$route['mensaje'] = 'Mensajes';

$route['administracion'] = 'admin/Panel';
$route['administracion/home'] = 'admin/Panel/home';
$route['administracion/salir'] = 'admin/Panel/cerrarSession';
$route['administracion/login'] = 'admin/Panel/login';
$route['administracion/validacion'] = 'admin/Panel/validacion';
$route['administracion/perfil'] = 'admin/Panel';
$route['administracion/programa/(:num)'] = 'admin/Programa/get/$1';
$route['secure/alumno/(:num)'] = 'admin/Solicitud/getResumenSolicitudById/$1';
$route['secure/inscrito/(:num)'] = 'admin/InscripcionController/getResumenSolicitudById/$1';

/*send id for post*/
$route['administracion/programa/activar'] = 'admin/Programa/activar';
$route['administracion/programa/desactivar'] = 'admin/Programa/desactivar';
$route['administracion/programa/actualizar'] = 'admin/Programa/actualizar';
$route['administracion/programa/insertar'] = 'admin/Programa/insertar';

$route['admin/api/solicitud'] = 'admin/api/Solicitud';

$route['admin/dataTable/matricula'] = 'admin/Matricula/dataTable';
$route['admin/dataTable/solicitud'] = 'admin/Solicitud/dataTable';
$route['admin/dataTable/solicitudaceptada'] = 'admin/Solicitud/dataTableAtendidas';
$route['admin/dataTable/inscritos'] = 'admin/Alumno/datatable';
$route['admin/dataTable/informes'] = 'admin/InformeController/dataTable';
$route['admin/dataTable/inscripciones'] = 'admin/InscripcionController/datatable_dashboard';

$route['admin/dataTable/programa'] = 'admin/Programa/dataTable';
$route['admin/dataTable/beneficio'] = 'admin/Beneficio/dataTable';
$route['admin/pdf/(:num)'] = 'admin/Solicitud/pdf/$1';
$route['admin/solicitud/marcar'] = 'admin/Solicitud/marcar';
$route['admin/solicitud/quitarMarca'] = 'admin/Solicitud/quitarMarca';

$route['admin/solicitud/marcarPago'] = 'admin/Solicitud/marcarPago';
$route['admin/solicitud/quitarMarcaPago'] = 'admin/Solicitud/quitarMarcaPago';

$route['admin/informes/marcarInfo'] = 'admin/InformeController/marcaInfo';
$route['admin/informes/quitarMarcaInfo'] = 'admin/InformeController/quitarMarcaInfo';

$route['admin/solicitud/(:num)'] = 'admin/Solicitud/get/$1';
$route['admin/comentario/(:num)'] = 'admin/Solicitud/getComentario/$1';
$route['admin/comentario/guardar/(:num)'] = 'admin/Solicitud/setComentario/$1';

$route['administracion/vista/solicitantes'] = 'admin/Solicitud';
$route['administracion/vista/matriculas'] = 'admin/Matricula';
$route['administracion/vista/programas'] = 'admin/Programa';
$route['administracion/vista/programascalendar'] = 'admin/Programa/viewCalendar';
$route['administracion/vista/beneficios'] = 'admin/Beneficio';
$route['administracion/vista/alumnos'] = 'admin/Alumno';
$route['administracion/vista/solicitudes'] = 'admin/Solicitud';
$route['administracion/vista/informes'] = 'admin/InformeController';
$route['administracion/vista/reportes'] = 'admin/ReportesController';
$route['administracion/vista/inscripciones'] ='admin/InscripcionController/index';

$route['admin/parts/nuevoprograma'] = 'admin/Programa/newPrograma';

//**Models with inscription */
$route['admin/inscr/create'] = 'admin/InscripcionController/create';
$route['admin/inscr/cancel'] = 'admin/InscripcionController/delete';

$route['test'] = 'admin/Solicitud/test';


$route['mdf/api/programa'] = 'apiMindef/Programa';
$route['mdf/api/alumno'] = 'apiMindef/Alumno';

$route['int/api/solicitud/(:num)/(:num)'] = 'intranetCaen/Solicitud/inf/$1/$2';
$route['int/solicitud/(:num)'] = 'intranetCaen/Solicitud/pdf/$1';

///CASEDE
$route['casede/datatable/listar'] = 'CasedeController/listarComoDatatable';
$route['administracion/vista/casede'] = 'CasedeController';

$route['certifica']='CertificadoController/verificar';


//$route['correo']='CorreoController/sendMailGmail';

//$route['admin/view/pdf']='admin/Alumno/viewPdfDocument';
//$route['admin/view/pdf/:any']='admin/Alumno/viewPdfDocument';
$route['admin/view/pdf/([a-zA-Z]+)/(:num)']='admin/FilesController/get_file_view_as_data';
$route['solicitud/view/pdf/([a-zA-Z]+)/(:num)']='admin/FilesController/get_fileSolicitud_view_as_data';
$route['prueba']='CorreoController/fileTest';


$route['prueba']='CorreoController/fileTest';
//
$route['postulante/checkingfile'] = 'admin/Alumno/set_good_file';


$route['dashboard/reporte/informes'] = 'dashboard/InformesController/report';
$route['dashboard/reporte/solicitudes'] = 'dashboard/SolicitudController/report';
$route['dashboard/reporte/solicitudes/(:num)'] = 'dashboard/SolicitudController/reportFilter/$1';
$route['dashboard/reporte/programas'] = 'dashboard/ProgramasController/report';

//rest
///$route['api/inscrito/inscripciones/'] = 'rest/apiinscrito_Controller/inscripciones/id/$1';
$route['api/inscrito/inscripciones/(:num)'] = 'rest/apiinscrito_Controller/inscripciones/id/$1';
$route['api/inscrito/inscripciones'] = 'rest/apiinscrito_Controller/inscripciones/id/';


/**
 * Persona 
 */
$route['api/inscrito/persona/(:num)'] = 'rest/apipersona_Controller/persona/id/$1';
$route['api/inscrito/persona'] = 'rest/apipersona_Controller/persona/id/';


//**Rest codigo propio  v 0.1*/
$route['api/v1/inscritos'] = 'apiRest/Inscritos_Controller/get';
$route['api/v1/inscrito/(:num)'] = 'apiRest/Inscritos_Controller/getById/$1';


/***
 * Chart estadistics
 */
$route['chart/([a-zA-Z]+)'] = 'ChartsController/get_data_source_names';
$route['chart/([a-zA-Z]+)/data'] = 'ChartsController/get_data_source';