<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/********* para logeo y recupeacion de contrasenas *****/

Route::get('login', [
    'uses'  => 'Auth\AuthController@getLogin',
    'as'    => 'login'
]);
Route::post('login', [
    'uses'  => 'Auth\AuthController@postLogin',
    'as'    => 'login'
]);
Route::get('logout', [
    'uses'  => 'Auth\AuthController@getLogout',
    'as'    => 'logout'
]);

// registration routes
Route::get('registro', [
    'uses'  => 'Auth\AuthController@getRegister',
    'as'    => 'register'
]);
Route::POST('registro', [
    'uses'  => 'Auth\AuthController@POSTRegister',
    'as'    => 'register'
]);


/******************* fin ******************/

Route::group(['middleware' => 'auth'], function() {

    Route::get('/', [
        'uses' => 'UserController@main',
        'as' => 'user.main'
    ]);

});

Route::get('uu',function(){
    return view('layouts.master');
});


//************************ Rutas Cursante ******************


// Ruta calificar docente
Route::get('calificacionDocente', [
    'uses'  => 'CursanteController@calificarDocente',
    'as'    => 'cursante.calificarDocente'
]);

//Ruta seleccionar materia para calificar cursante (cursante a los mismos cursantes de su grupo)
Route::get('selecMateriaCalificacionCursante',
    [
        'uses' => 'CursanteController@selecMateriaCalificarCursante',
        'as'   => 'cursante.selecMateriaCalificarCursante'
    ]);

//Ruta calificar cursante (cursante a los mismos cursantes de su grupo)
Route::post('calificacionCursante',
    [
    'uses' => 'CursanteController@calificarCursante',
    'as'   => 'cursante.calificarCursante'
]);

//Ruta formulario calificar docente
Route::post('formCalifDoc',
    [
    'uses' => 'CursanteController@formCalifDoc',
    'as'   => 'cursante.formCalifDoc'
]);


//Ruta formulario calificar cursante
Route::post('formCalifCursanteC',
    [
        'uses' => 'CursanteController@formCalifCursante',
        'as'   => 'cursante.formCalifCursante'
    ]);


//Ruta ver calificaciones cursante
Route::get('calificaciones',
    [
        'uses' => 'CursanteController@verCalificaciones',
        'as'   => 'cursante.verCalificaciones'
    ]);


//Ruta calificacion cursante exitosa no se usa!!
Route::get('CalificacionExitosa',
    [
        'uses' => 'CursanteController@verCalificacionExitosa',
        'as'   => 'cursante.calificacionExitosa'
    ]);

//Ruta generar pdf de calificaciones interCursatnes
Route::post('imprimirCalificacionCursante',[
    'uses' => 'PdfController@calificacionCursante',
    'as'   => 'pdf.calificacionCursante']);

//Ruta generar pdf de calificaciones docente
Route::post('imprimirCalificacionDocente',[
    'uses' => 'PdfController@calificacionDocente',
    'as'   => 'pdf.calificacionDocente']);

//************************* rutas docente *************

Route::get('calificarCursantes',[
    'uses' => 'DocenteController@calificar',
    'as'   => 'docente.calificar']);

Route::get('verCalificacionesCursantes',[
    'uses' => 'DocenteController@verCalificaciones',
    'as'   => 'docente.verCalificaciones']);



//*********************** rutas excel ****************
//preuba generar excel


Route::get('excel',[
    'uses' => 'ExcelController@generarExcel',
    'as'   => 'excel.generarExcel']);

Route::get('GuardarExcel',[
    'uses' => 'ExcelController@import',
    'as'   => 'excel.generarExcel']);


//Ruta para que el docente reciba plantilla de excel para llenar...direcciona al ExcelController
Route::post('darExcel',[
    'uses' => 'ExcelController@darExcel',
    'as'   => 'excel.darExcel']);


//Ruta para que el docente guarde notas...direcciona al ExcelController
Route::post('guardarNotas',[
    'uses' => 'ExcelController@guardarNotas',
    'as'   => 'excel.guardarNotas']);





//****************************prueba ******************

Route::get('alumno/{id}', [
    'uses'  => 'CursanteController@usuario',
    'as'    => 'usuario'
]);
Route::get('sorteo','PrincipalController@sortearGrupos' );
//rutas del director
Route::get('nuevoCursante',[
    'uses' => 'PrincipalController@index',
    'as'   => 'nuevoCursante']);
Route::post('nuevoCursante',[
    'uses' => 'PrincipalController@store',
    'as'   => 'nuevoCursante']);

Route::get('nuevoDocente',[
    'uses' => 'PrincipalController@insDocente',
    'as'   => 'nuevoDocente']);
Route::post('nuevoDocente',[
    'uses' => 'PrincipalController@newDocente',
    'as'   => 'nuevoDocente']);

Route::get('modificarCursante',[
    'uses' => 'PrincipalController@mostrarCursantes',
    'as'   => 'modificarCursante']);
Route::get('editarCursante{id}',[
    'uses'  =>'PrincipalController@editarCursante',
    'as'    =>'editCursante'
]);
Route::put('actualizarCursante{id}',[
    'uses'  => 'PrincipalController@actualizarCursante',
    'as'    => 'upCursante'
]);

Route::get('modificarDocente',[
    'uses' => 'PrincipalController@mostrarDocentes',
    'as'   => 'modificarDocente']);
Route::get('editarDocente{id}',[
    'uses'  =>'PrincipalController@editarDocente',
    'as'    =>'editDocente'
]);
Route::put('actualizarDocente{id}',[
    'uses'  => 'PrincipalController@actualizarDocente',
    'as'    => 'upDocente'
]);
Route::delete('eliminar{id}',[
    'uses'   => 'PrincipalController@destroyCu',
    'as'     => 'eliminar'
]);
Route::delete('eliminar{id}',[
    'uses'   => 'PrincipalController@destroyDo',
    'as'     => 'eliminar'
]);

Route::get('sortear-index',[
    'uses'  => 'PrincipalController@mostrarGroup',
    'as'    => 'sortearIndex'
]);
Route::post('sortear',[
    'uses'  => 'PrincipalController@sortearGrupos',
    'as'    => 'sortear'
]);

//asigna cursantes a kardex
Route::get('asignar','PrincipalController@asignarCursante');
Route::get('asignar-materia-{id}',[
    'uses'    => 'PrincipalController@asignaMateria',
    'as'      => 'asignarMateria'
]);
Route::post('asignar-materia-{id}',[
    'uses'    => 'PrincipalController@asign',
    'as'      => 'asignarMateria'
]);
//asigna docentes a contratos
Route::get('asignarDocentes','PrincipalController@asignarDocente');
Route::get('asignar-doc{id}',[
    'uses'    => 'PrincipalController@asignaContrado',
    'as'      => 'asignarContrato'
]);
Route::post('asignar-doc{id}',[
    'uses'    => 'PrincipalController@asignaDo',
    'as'      => 'asignarContrado'
]);




/*Route::get('sorteoDeGrupos',[
    'uses'  => 'PrincipalController@sortearGrupos',
    'as'    => 'sortearIndex'
]);*/
Route::get('pdfCursanes', 'PdfController@cursantes');
Route::get('pdfDocentes', 'PdfController@docentes');
Route::get('pdfDocentes{m}', 'PdfController@grupos');
//PRUEBA DOMPDF
Route::get('pruebaPDF',[
    'uses' => 'PdfController@invoice',
    'as'   => 'pruebaPDF']);

Route::get('reporte-Cursante',[
    'uses'  => 'PrincipalController@reportePorCursante',
    'as'    => 'porCursante'
]);

//****************Rutas director************************




//Ruta para mostrar las materias para calificar al cursante
Route::get('calificarCursanteSelecMateria',[
    'uses' => 'PrincipalController@calificarCursanteSelecMateria',
    'as'   => 'director.calificarCursanteSelecMateria']);

//Ruta para seleccionar cursante y calificarlo
Route::post('calificarCursante',[
    'uses' => 'PrincipalController@calificarCursante',
    'as'   => 'director.calificarCursante']);

//Ruta para guardar calificacion al cursante
Route::post('formCalifCursante',[
    'uses' => 'PrincipalController@formCalifCursante',
    'as'   => 'director.formCalifCursante']);

//Ruta para escoger materia para generar reporte por materia
Route::get('reportePorMateria',[
    'uses' => 'PrincipalController@reportePorMateria',
    'as'   => 'director.reportePorMateria']);

//Ruta generar pdf de reporte por Materia
Route::post('reportePorMateria',[
    'uses' => 'PdfController@reportePorMateria',
    'as'   => 'pdf.reportePorMateria']);
Route::post('reportePorAlumno',[
    'uses'  => 'PrincipalController@reporteCursantePdf',
    'as'    => 'porAlumno'
]);
Route::get('pu','PrincipalController@prueba');

/*
 * admin
 */
Route::get('lista_grados',[
    'uses'  => 'AdminController@gradosList',
    'as'    => 'grados'
]);
Route::post('lista_grados',[
    'uses'  => 'AdminController@gradosNew',
    'as'    => 'nuevoGrado'
]);
Route::get('editar_grados_{id}',[
    'uses'  => 'AdminController@gradosEdit',
    'as'    => 'editGrado'
]);
Route::put('actualizar_grados_{id}',[
    'uses'  => 'AdminController@gradosUpdate',
    'as'    => 'updateGrado'
]);
Route::get('eliminar_grados{id}',[
    'uses'  => 'AdminController@destroyGrado',
    'as'    => 'eliminarGrado'
]);

Route::get('lista_directores',[
    'uses'  => 'AdminController@jefesList',
    'as'    => 'directores'
]);
Route::get('editar_cargos_{id}',[
    'uses'  => 'AdminController@cargosEdit',
    'as'    => 'editCargo'
]);
Route::put('actualizar_cargos_{id}',[
    'uses'  => 'AdminController@cargosUpdate',
    'as'    => 'updateCargo'
]);

Route::post('nuevo_jefe',[
    'uses'  => 'AdminController@jefesNew',
    'as'    => 'nuevoJefe'
]);
Route::get('editar_jefe_{id}',[
    'uses'  => 'AdminController@jefesEdit',
    'as'    => 'editJefe'
]);
Route::put('actualizar_jefe_{id}',[
    'uses'  => 'AdminController@jefesUpdate',
    'as'    => 'updateJefe'
]);
Route::get('eliminar_jefe_{id}',[
    'uses'  => 'AdminController@destroyJefe',
    'as'    => 'eliminarJefe'
]);
