<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login/index', 'Login::index');
$routes->get('/login/keluar', 'Login::logout');
$routes->post('login/validateuser', 'Login::validateUser');

// Admin
$routes->get('/admin/main/index', 'Admin\Main::index');
// admin -> user
$routes->get('/admin/user/index', 'UserController::index');
$routes->get('/admin/user/getData', 'UserController::getDataAdmin');
$routes->post('/admin/user/save', 'UserController::saveData');
$routes->delete('/admin/user/delete/(:any)', 'UserController::deleteData/$1');
$routes->get('/admin/user/getSelectedData/(:any)', 'UserController::getSelectedUserData/$1');
$routes->put('/admin/user/update', 'UserController::updateData');
// admin -> mata kuliah
$routes->get('/admin/mata-kuliah/index', 'MataKuliahController::index');
$routes->get('/admin/mata-kuliah/getData', 'MataKuliahController::getDataAdmin');
$routes->post('/admin/mata-kuliah/save', 'MataKuliahController::saveData');
$routes->delete('/admin/mata-kuliah/delete/(:any)', 'MataKuliahController::deleteData/$1');
$routes->get('/admin/mata-kuliah/getSelectedData/(:any)', 'MataKuliahController::getSelectedMatkulData/$1');
$routes->put('/admin/mata-kuliah/update', 'MataKuliahController::updateData');
// admin -> dosen
$routes->get('/admin/dosen/index', 'DosenController::index');
$routes->get('/admin/dosen/getData', 'DosenController::getDataAdmin');
$routes->post('/admin/dosen/save', 'DosenController::saveData');
$routes->delete('/admin/dosen/delete/(:any)', 'DosenController::deleteData/$1');
$routes->get('/admin/dosen/getSelectedData/(:any)', 'DosenController::getSelectedDosenData/$1');
$routes->put('/admin/dosen/update', 'DosenController::updateData');
$routes->get('/admin/dosen/getAllEmailData', 'DosenController::getAllEmailData');
// admin -> mahasiswa 
$routes->get('/admin/mahasiswa/index', 'MahasiswaController::index');
$routes->get('/admin/mahasiswa/getData', 'MahasiswaController::getDataAdmin');
$routes->post('/admin/mahasiswa/save', 'MahasiswaController::saveData');
$routes->delete('/admin/mahasiswa/delete/(:any)', 'MahasiswaController::deleteData/$1');
$routes->get('/admin/mahasiswa/getSelectedData/(:any)', 'MahasiswaController::getSelectedMhsData/$1');
$routes->put('/admin/mahasiswa/update', 'MahasiswaController::updateData');
$routes->get('/admin/mahasiswa/getAllEmailData', 'MahasiswaController::getAllEmailData');
$routes->get('/admin/mahasiswa/getAllLevelData', 'MahasiswaController::getAllLevelData');
// admin -> level
$routes->get('/admin/level/index', 'LevelController::index');
$routes->get('/admin/level/getData', 'LevelController::getDataAdmin');
$routes->post('/admin/level/save', 'LevelController::saveData');
$routes->delete('/admin/level/delete/(:any)', 'LevelController::deleteData/$1');
$routes->get('/admin/level/getSelectedData/(:any)', 'LevelController::getSelectedLevelData/$1');
$routes->put('/admin/level/update', 'LevelController::updateData');
// admin -> krs
$routes->get('/admin/krs/index', 'KrsController::index');
$routes->get('/admin/krs/getData', 'KrsController::getDataAdmin');
$routes->post('/admin/krs/save', 'KrsController::saveData');
$routes->delete('/admin/krs/delete/(:any)', 'KrsController::deleteData/$1');
$routes->get('/admin/krs/getSelectedData/(:any)', 'KrsController::getSelectedKrsData/$1');
$routes->put('/admin/krs/update', 'KrsController::updateData');
$routes->get('/admin/krs/getAllMatkulData', 'KrsController::getAllMatkulData');
$routes->get('/admin/krs/getAllDosenData', 'KrsController::getAllDosenData');