<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Produk::index');

$routes->group('produk', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'Produk::index');
    $routes->get('tambah-produk', 'Produk::create');
    $routes->post('tambah-produk/save', 'Produk::save');
    $routes->get('edit/(:any)', 'Produk::edit/$1');
    $routes->post('edit/save', 'Produk::editSave');
    // $routes->get('hapus-variasi/(:num)/(:num)', 'Produk::hapusVariasi/$1/$2');
    $routes->get('hapus-produk/(:num)', 'Produk::hapusProduk/$1');
});

$routes->group('kategori', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'Kategori::index');
    $routes->add('tambah-kategori', 'Kategori::create');
    $routes->post('tambah-kategori/save', 'Kategori::save');
    $routes->add('edit-kategori/(:num)', 'Kategori::edit/$1');
    $routes->get('hapus-kategori/(:num)', 'Kategori::delete/$1');
});
