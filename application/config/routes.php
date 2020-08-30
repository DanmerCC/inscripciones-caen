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
$route['postulante/answers'] = 'Postulante/answersorigin';


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
$route['postulante/misdescuentos'] = 'Postulante/getAllDiscountsCurrentUser';//yony
$route['postulante/misdescuentos/(:num)'] = 'Postulante/getDiscountsCurrentUser/$1';//yony


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
$route['file/deleteadmin/([a-zA-Z]+)/(:num)'] = 'admin/FilesController/eliminarPorAdmin/$1/$2';
$route['file/info/([a-zA-Z]+)'] = 'admin/FilesController/info/$1';

$route['api/alumno'] = 'ApiAlumno';
$route['api/programas'] = 'ApiPrograma';
$route['api/programas/all'] = 'ApiPrograma/all';
$route['api/programas/allSolicitud'] = 'ApiPrograma/allBySolicitud';
$route['api/programas/allInscripciones'] = 'ApiPrograma/allByIncripciones';
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
$route['administracion/programa/postergar'] = 'admin/Programa/postergar';
$route['administracion/programa/discount/(:num)'] = 'admin/Programa/byDiscount/$1';
$route['administracion/programa/discountrestante/(:num)'] = 'admin/Programa/byDiscountRestante/$1';

$route['admin/api/solicitud'] = 'admin/api/Solicitud';

$route['admin/dataTable/matricula'] = 'admin/Matricula/dataTable';
$route['admin/dataTable/solicitud'] = 'admin/Solicitud/dataTable';
$route['admin/dataTable/solicitudaceptada'] = 'admin/Solicitud/dataTableAtendidas';
$route['admin/dataTable/inscritos'] = 'admin/Alumno/datatable';
$route['admin/dataTable/informes'] = 'admin/InformeController/dataTable';
$route['admin/dataTable/inscripciones'] = 'admin/InscripcionController/datatable_dashboard';
$route['admin/dataTable/evaluaciones'] = 'admin/EvaluacionesController/datatable';

$route['admin/dataTable/programa'] = 'admin/Programa/dataTable';
$route['admin/pdf/(:num)'] = 'admin/Solicitud/pdf/$1';
$route['admin/solicitud/marcar'] = 'admin/Solicitud/marcar';
$route['admin/solicitud/quitarMarca'] = 'admin/Solicitud/quitarMarca';

$route['admin/solicitud/marcarPago'] = 'admin/Solicitud/marcarPago';
$route['admin/solicitud/quitarMarcaPago'] = 'admin/Solicitud/quitarMarcaPago';
$route['admin/solicitud/addRequirement'] = 'admin/RequirementSolicitud/save';

$route['admin/informes/marcarInfo'] = 'admin/InformeController/marcaInfo';
$route['admin/informes/quitarMarcaInfo'] = 'admin/InformeController/quitarMarcaInfo';

$route['admin/solicitud/(:num)'] = 'admin/Solicitud/get/$1';
$route['admin/comentario/(:num)'] = 'admin/Solicitud/getComentario/$1';
$route['admin/comentario/guardar/(:num)'] = 'admin/Solicitud/setComentario/$1';

$route['administracion/vista/solicitantes'] = 'admin/Solicitud';
$route['administracion/vista/matriculas'] = 'admin/Matricula';
$route['administracion/vista/programas'] = 'admin/Programa';
$route['administracion/vista/programascalendar'] = 'admin/Programa/viewCalendar';
$route['administracion/vista/alumnos'] = 'admin/Alumno';
$route['administracion/vista/solicitudes'] = 'admin/Solicitud';
$route['administracion/solicitud/changestatefinan']='admin/Solicitud/changeEstadoFinanzas';
$route['administracion/vista/informes'] = 'admin/InformeController';
$route['administracion/vista/reportes'] = 'admin/ReportesController';
$route['administracion/vista/inscripciones'] ='admin/InscripcionController/index';
$route['administracion/vista/dowloadFilter'] ='admin/InscripcionController/dowloadFilter';
$route['administracion/vista/evaluaciones'] ='admin/EvaluacionesController/index';
$route['administracion/solicitud/alumno/(:num)']='admin/Solicitud/getAlumnoBySolicitud/$1';

$route['admin/parts/nuevoprograma'] = 'admin/Programa/newPrograma';
$route['admin/notifications'] = 'admin/NotificationController/index';
$route['admin/read'] = 'admin/NotificationController/read';


$route['admin/inscripcion/changestatefinan']='admin/InscripcionController/changeEstadoFinanzas';
$route['admin/finobservacion/inscripcion/(:num)']='admin/FinanzasObservacionController/get_by_inscripcion_id/$1';
$route['admin/details/inscripcion/(:num)']='admin/InscripcionController/get_details/$1';
$route['admin/tipoAutorizaciones']='admin/FinanzasTipoAutorizacionController/all';
$route['admin/finobservacion/solicitud/(:num)']='admin/FinanzasObservacionController/get_by_solicitud_id/$1';

//**Models with inscription */
$route['admin/inscr/create'] = 'admin/InscripcionController/create';
$route['admin/inscr/cancel'] = 'admin/InscripcionController/delete';

$route['test/(:num)'] = 'admin/Solicitud/test/$1';


$route['mdf/api/programa'] = 'apiMindef/Programa';
$route['mdf/api/alumno'] = 'apiMindef/Alumno';

$route['int/api/solicitud/(:num)/(:num)'] = 'intranetCaen/Solicitud/inf/$1/$2';
$route['int/solicitud/(:num)'] = 'intranetCaen/Solicitud/pdf/$1';

///CASEDE
$route['casede/datatable/listar'] = 'CasedeController/listarComoDatatable';
$route['administracion/vista/casede'] = 'CasedeController';
$route['casede/marcaAsistenciaq'] = 'CasedeController/marcarAsistenciaQ';
$route['casede/marcaAsistenciad'] = 'CasedeController/marcarAsistenciaD';
$route['certifica']='CertificadoController/verificar';


//$route['correo']='CorreoController/sendMailGmail';

//$route['admin/view/pdf']='admin/Alumno/viewPdfDocument';
//$route['admin/view/pdf/:any']='admin/Alumno/viewPdfDocument';
$route['admin/view/pdf/([a-zA-Z]+)/(:num)']='admin/FilesController/get_file_view_as_data';
$route['admin/download/pdf/([a-zA-Z]+)/(:num)']='admin/FilesController/download_pdf';
$route['solicitud/view/pdf/([a-zA-Z]+)/(:num)']='admin/FilesController/get_fileSolicitud_view_as_data';

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
$route['api/v1/solicitudes'] = 'apiRest/SolicitudesController/get';
$route['api/v1/inscritos'] = 'apiRest/Inscritos_Controller/get';
$route['api/v1/inscritos/programa/(:num)'] = 'apiRest/Inscritos_Controller/byPrograma/$1';
$route['api/v1/inscrito/(:num)'] = 'apiRest/Inscritos_Controller/getById/$1';
$route['api/v1/personas'] = 'apiRest/Persona_Controller/get';
$route['api/v1/persona/(:num)'] = 'apiRest/Persona_Controller/getById/$1';
$route['api/v1/programas'] = 'apiRest/Programa_Controller/get';
$route['api/v1/programa/(:num)'] = 'apiRest/Programa_Controller/getById/$1';
$route['api/v1/tipoProgramas'] = 'apiRest/Programa_Controller/listTipos';
$route['api/v1/tipoPrograma/(:num)'] = 'apiRest/Programa_Controller/tipo/$1';
$route['api/v1/files/([a-zA-Z]+)/(:num)'] = 'apiRest/Files_Controller/getFile';

///Danger
$route['api/v1/inscrito/(:num)/changestate'] = 'apiRest/Inscritos_Controller/changeStateInscripcion/$1';
///Danger

/***
* Chart estadistics
*/

$route['chart/alumno'] = 'ChartsController/alumno_columns';
$route['chart/alumno/metadata'] = 'ChartsController/alumno_get_group_data';
$route['chart/alumno/count'] = 'ChartsController/get_count_data_alumno';


/**
 * ugly code for static query
 *
 */
$route['chart/inscrito'] = 'ChartsController/get_chart';


$route['chart/inscrito'] = 'ChartsController/get_chart';

/***
 * documentos autogenerados v2
 */
$route['generator/solad/(:num)'] = 'Solicitud/generate_document/$1';

$route['admin/upload/page/([a-zA-Z]+)/(:num)'] = 'admin/FilesController/uploads_page';
$route['admin/uploading'] = 'admin/FilesController/recive_file';


$route['use/inscripcion'] = 'InfoForUseController/index';
$route['use/inscripciones'] = 'dashboard/EstadisticInscripcionesController/report';

/** Inscripciones por dia*/
$route['stadistics/inscritos'] = 'dashboard/EstadisticInscripcionesController/report';

/** Inscripciones por programa*/
$route['stadistics/inscritos/programa'] = 'dashboard/EstadisticInscripcionesController/inscritosPorPrograma';

//**Exalumnos */
$route['stadistics/inscritos/exalumnos/programa'] = 'dashboard/EstadisticInscripcionesController/exalumnosInscritosPorPrograma';

/** Inscripciones por genero*/
$route['stadistics/inscritos/genero'] = 'dashboard/EstadisticInscripcionesController/porGenero';

/***Segun edades */
$route['stadistics/inscritos/edades'] = 'dashboard/EstadisticInscripcionesController/getInscritosPorCicloDeVida';

/** Militares civiles */
$route['stadistics/inscritos/militares'] = 'dashboard/EstadisticInscripcionesController/getDataMilitars';

/** Militares civiles */
$route['stadistics/inscritos/procedencia'] = 'dashboard/EstadisticInscripcionesController/porLugarDeProcedencia';

$route['solicitud/files_state/(:num)'] = 'admin/InscripcionController/get_estado_archivos_solicitud_include_person_files/$1';

$route['admin/entrevista/byinscripcion/(:num)'] = 'admin/EntrevistaController/byInscripcion/$1';
$route['admin/entrevista/create'] = 'admin/EntrevistaController/create';
$route['admin/entrevistas'] = 'admin/EntrevistaController/list';
$route['admin/entrevista/change/date'] = 'admin/EntrevistaController/changeDate';
$route['admin/entrevista/buildable'] = 'admin/EntrevistaController/getBuildable';
$route['admin/entrevista/delete'] = 'admin/EntrevistaController/delete';
$route['admin/entrevista/(:num)'] = 'admin/EntrevistaController/getFullDatails/$1';
$route['admin/entrevista/update'] = 'admin/EntrevistaController/update';


$route['administracion/vista/entrevistas'] = 'admin/EntrevistaController/index';
$route['administracion/vista/exportarData'] = 'admin/EntrevistaController/exportarDataInterview';

$route['informes/form'] = 'InformesController/index';
$route['informes/save'] = 'InformesController/save';


$route['admin/evaluables'] = 'admin/InscripcionController/getEvaluables';
$route['admin/evaluacion/save'] = 'admin/EvaluacionesController/guardar';
$route['prueba'] = 'admin/EvaluacionesController/prueba';

//ALL LOGIG NEW DISCOUNT
$route['postulante/solicitud/discount/store'] = 'Solicitud/storeSolicitudDiscount/$1';

//modulos beneficios
$route['administracion/vista/discounts'] = 'admin/Discount';
$route['admin/dataTable/discounts'] = 'admin/Discount/dataTable';
$route['administracion/discounts/save'] = 'admin/Discount/save';
$route['administracion/discounts/update'] = 'admin/Discount/update';
$route['administracion/discounts/edit/(:num)'] = 'admin/Discount/edit/$1';
$route['administracion/discounts/delete'] = 'admin/Discount/delete';
$route['administracion/discounts/programas/(:num)'] = 'admin/Discount/byCurso/$1';
$route['administracion/discounts/solicitud/(:num)'] = 'admin/Discount/bySolicitud/$1';

//modulo Requirements
$route['administracion/vista/requirements'] = 'admin/Requirement';
$route['admin/dataTable/requirements'] = 'admin/Requirement/dataTable';
$route['administracion/requirements/save'] = 'admin/Requirement/save';
$route['administracion/requirements/update'] = 'admin/Requirement/update';
$route['administracion/requirements/edit/(:num)'] = 'admin/Requirement/edit/$1';
$route['administracion/requirements/delete'] = 'admin/Requirement/delete';
$route['administracion/requirements/solicitud/(:num)'] = 'admin/Requirement/bySolicitud/$1';
$route['administracion/requirements/discount/(:num)'] = 'admin/Requirement/byDiscount/$1';
$route['administracion/requirements/discountrestante/(:num)'] = 'admin/Requirement/byDiscountRestante/$1';
$route['administracion/requirements/document/(:any)'] = 'admin/FilesController/showFileRequirement/$1';

//modulo discount requirement
$route['admin/dataTable/discountrequirement'] = 'admin/DiscountRequirement/dataTable';
$route['administracion/discountrequirement/save'] = 'admin/DiscountRequirement/save';
$route['administracion/discountrequirement/update'] = 'admin/DiscountRequirement/update';
$route['administracion/discountrequirement/edit/(:num)'] = 'admin/DiscountRequirement/edit/$1';
$route['administracion/discountrequirement/delete'] = 'admin/DiscountRequirement/delete';

//cursos descuentos
$route['administracion/vista/cursosdiscount'] = 'admin/Cursosdiscount';
$route['admin/dataTable/cursosdiscount'] = 'admin/Cursosdiscount/dataTable';
$route['administracion/cursosdiscount/save'] = 'admin/Cursosdiscount/save';
$route['administracion/cursosdiscount/update'] = 'admin/Cursosdiscount/update';
$route['administracion/cursosdiscount/edit/(:num)'] = 'admin/Cursosdiscount/edit/$1';
$route['administracion/cursosdiscount/delete'] = 'admin/Cursosdiscount/delete';

//cargar nueva admision
$route['administracion/admidslist'] = 'admin/Admision/create';
$route['administracion/inscripcion/actas/(:num)'] = 'admin/Admision/byinscripcion/$1';//by id inscription
$route['administracion/acta/view/(:num)'] = 'admin/Admision/show/$1';
$route['administracion/acta/details/(:num)'] = 'admin/Admision/details/$1';
