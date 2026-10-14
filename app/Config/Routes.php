<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// 1. Auth & Public Routes
// ==========================================
$routes->get('/', 'Home::index');
$routes->get('/', 'Auth::index'); // Route utama disatukan ke Login
$routes->get('paslon', 'Home::paslon');
$routes->get('informasi', 'Home::informasi');

$routes->get('login', 'Auth::index');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');

// ==========================================
// 2. Dashboard Redirect Utama
// ==========================================
$routes->get('dashboard', 'Dashboard::index');

// ==========================================
// 3. Admin Routes (Akses Penuh ke Semua Tabel)
// ==========================================
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // CRUD Users (Tabel: users)
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:segment)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:segment)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:segment)', 'Admin\Users::delete/$1');

    // CRUD Paslon (Tabel: paslon)
    $routes->get('paslon', 'Admin\Paslon::index');
    $routes->get('paslon/create', 'Admin\Paslon::create');
    $routes->post('paslon/store', 'Admin\Paslon::store');
    $routes->get('paslon/edit/(:segment)', 'Admin\Paslon::edit/$1');
    $routes->post('paslon/update/(:segment)', 'Admin\Paslon::update/$1');
    $routes->get('paslon/delete/(:segment)', 'Admin\Paslon::delete/$1');

    // CRUD Wilayah (Tabel: wilayah)
    $routes->get('wilayah', 'Admin\Wilayah::index');
    $routes->get('wilayah/create', 'Admin\Wilayah::create');
    $routes->post('wilayah/store', 'Admin\Wilayah::store');
    $routes->get('wilayah/edit/(:segment)', 'Admin\Wilayah::edit/$1');
    $routes->post('wilayah/update/(:segment)', 'Admin\Wilayah::update/$1');
    $routes->get('wilayah/delete/(:segment)', 'Admin\Wilayah::delete/$1');

    // CRUD Pemilih (Tabel: pemilih)
    $routes->get('pemilih', 'Admin\Pemilih::index');
    $routes->get('pemilih/create', 'Admin\Pemilih::create');
    $routes->post('pemilih/store', 'Admin\Pemilih::store');
    $routes->get('pemilih/export', 'Admin\Pemilih::export');
    $routes->get('pemilih/exportExcel', 'Admin\Pemilih::exportExcel');
    $routes->get('pemilih/exportPdf', 'Admin\Pemilih::exportPdf');
    $routes->get('pemilih/exportCsv', 'Admin\Pemilih::exportCsv');
    $routes->post('pemilih/import', 'Admin\Pemilih::import');
    $routes->get('pemilih/edit/(:segment)', 'Admin\Pemilih::edit/$1');
    $routes->post('pemilih/update/(:segment)', 'Admin\Pemilih::update/$1');
    $routes->post('pemilih/delete/(:segment)', 'Admin\Pemilih::delete/$1');

    // CRUD Logistik Master (Tabel: logistik)
    $routes->get('logistik', 'Admin\Logistik::index');
    $routes->get('logistik/create', 'Admin\Logistik::create');
    $routes->post('logistik/store', 'Admin\Logistik::store');
    $routes->get('logistik/edit/(:segment)', 'Admin\Logistik::edit/$1');
    $routes->post('logistik/update/(:segment)', 'Admin\Logistik::update/$1');
    $routes->get('logistik/delete/(:segment)', 'Admin\Logistik::delete/$1');

    // CRUD Distribusi Logistik (Tabel: distribusi_logistik)
    $routes->get('distribusi', 'Admin\Distribusi::index');
    $routes->get('distribusi/create', 'Admin\Distribusi::create');
    $routes->post('distribusi/store', 'Admin\Distribusi::store');
    $routes->get('distribusi/edit/(:segment)', 'Admin\Distribusi::edit/$1');
    $routes->post('distribusi/update/(:segment)', 'Admin\Distribusi::update/$1');
    $routes->get('distribusi/delete/(:segment)', 'Admin\Distribusi::delete/$1');

    // Management Hasil TPS & Validasi C1 (Tabel: hasil_tps)
    $routes->get('hasil-tps', 'Admin\HasilTps::index');
    $routes->get('hasil-tps/create', 'Admin\HasilTps::create');
    $routes->post('hasil-tps/store', 'Admin\HasilTps::store');
    $routes->post('hasil-tps/update-status/(:segment)', 'Admin\HasilTps::updateStatus/$1');
    $routes->get('hasil-tps/delete/(:segment)', 'Admin\HasilTps::delete/$1');
});

// ==========================================
// 4. Kordes & Kor-RT Routes
// ==========================================
$routes->group('kordes', ['filter' => 'role:kordes,kor_rt,admin'], static function ($routes) {
    $routes->get('dashboard', 'Kordes\Dashboard::index');

    // CRUD Pemilih Tingkat Kordes / RT (Tabel: pemilih)
    $routes->get('pemilih', 'Kordes\Pemilih::index');
    $routes->get('pemilih/create', 'Kordes\Pemilih::create');
    $routes->get('pemilih/tambah', 'Kordes\Pemilih::create');
    $routes->post('pemilih/store', 'Kordes\Pemilih::store');
    $routes->get('pemilih/edit/(:segment)', 'Kordes\Pemilih::edit/$1');
    $routes->post('pemilih/update/(:segment)', 'Kordes\Pemilih::update/$1');
    $routes->post('pemilih/delete/(:segment)', 'Kordes\Pemilih::delete/$1');

    // Route Export Khusus Kordes
    $routes->get('pemilih/exportExcel', 'Kordes\Pemilih::exportExcel');
    $routes->get('pemilih/exportPdf', 'Kordes\Pemilih::exportPdf');
    $routes->get('pemilih/exportCsv', 'Kordes\Pemilih::exportCsv');

    // Monitoring Logistik di Wilayah Kordes (Tabel: distribusi_logistik & logistik)
    $routes->get('logistik', 'Kordes\Logistik::index');
    $routes->get('logistik/create', 'Kordes\Logistik::create');
    $routes->get('logistik/tambah', 'Kordes\Logistik::create');
    $routes->post('logistik/store', 'Kordes\Logistik::store');

    // View Data Wilayah (Tabel: wilayah)
    $routes->get('wilayah', 'Kordes\Wilayah::index');
});

// ==========================================
// 5. Relawan Routes (Tabel: pemilih & distribusi_logistik)
// ==========================================
$routes->group('relawan', ['filter' => 'role:relawan,admin'], static function ($routes) {
    $routes->get('/', 'Relawan\Dashboard::index');
    $routes->get('dashboard', 'Relawan\Dashboard::index');

    // Pendataan Pemilih & Geolocation oleh Relawan
    $routes->get('pemilih', 'Relawan\Pemilih::index');
    $routes->get('pemilih/create', 'Relawan\Pemilih::create');
    $routes->get('pemilih/tambah', 'Relawan\Pemilih::create');
    $routes->post('pemilih/store', 'Relawan\Pemilih::store');
    $routes->get('pemilih/edit/(:segment)', 'Relawan\Pemilih::edit/$1');
    $routes->post('pemilih/update/(:segment)', 'Relawan\Pemilih::update/$1');
});

// ==========================================
// 6. Saksi Routes (Tabel: hasil_tps & paslon)
// ==========================================
$routes->group('saksi', ['filter' => 'role:saksi,admin'], static function ($routes) {
    $routes->get('dashboard', 'Saksi\Dashboard::index');

    // Upload Form C1 & Input Suara TPS
    $routes->get('hasil-tps', 'Saksi\HasilTps::index');
    $routes->get('input-hasil', 'Saksi\HasilTps::create');
    $routes->get('hasil-tps/create', 'Saksi\HasilTps::create');
    $routes->post('simpan-hasil', 'Saksi\HasilTps::store');
    $routes->post('hasil-tps/store', 'Saksi\HasilTps::store');
});
