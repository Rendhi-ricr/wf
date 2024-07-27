<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
# $routes->get('/', 'Home::index');

$routes->get('/', 'Panel\Agenda::index');



$routes->group("panel/agenda", function ($routes) {
    $routes->get('/', 'Panel\Agenda::index');
    $routes->post('fetch-publish', 'Panel\Agenda::fetchAgendaPublish');
    $routes->post('fetch-draft', 'Panel\Agenda::fetchAgendaDraft');
    $routes->post('fetch-trash', 'Panel\Agenda::fetchAgendaTrash');
    $routes->match(["get", "post"], "tambah", "Panel\Agenda::tambah");
    $routes->match(["get", "post"], "(:any)/edit", "Panel\Agenda::edit/$1");
    $routes->post('trash-selected', 'Panel\Agenda::trashSelected');
    $routes->get('(:any)/trash', 'Panel\Agenda::trash/$1');
    $routes->get('(:any)/restore', 'Panel\Agenda::restore/$1');
    $routes->get('(:any)/remove', 'Panel\Agenda::remove/$1');
});

$routes->group("panel/news", function ($routes) {
    $routes->get('/', 'Panel\News::index');
    $routes->post('fetch-publish', 'Panel\News::fetchNewsPublish');
    $routes->post('fetch-draft', 'Panel\News::fetchNewsDraft');
    $routes->post('fetch-trash', 'Panel\News::fetchNewsTrash');
    $routes->match(["get", "post"], "tambah", "Panel\News::tambah");
    $routes->match(["get", "post"], "(:any)/edit", "Panel\News::edit/$1");
    $routes->post('trash-selected', 'Panel\News::trashSelected');
    $routes->get('(:any)/trash', 'Panel\News::trash/$1');
    $routes->get('(:any)/restore', 'Panel\News::restore/$1');
    $routes->get('(:any)/remove', 'Panel\News::remove/$1');
});

$routes->group("panel/faq", function ($routes) {
    $routes->get('/', 'Panel\Faq::index');
    $routes->post('fetch', 'Panel\Faq::fetchFaqPublish');
    // $routes->post('fetch-draft', 'Panel\News::fetchNewsDraft');
    // $routes->post('fetch-trash', 'Panel\News::fetchNewsTrash');
    $routes->match(["get", "post"], "tambah", "Panel\Faq::tambah");
    $routes->match(["get", "post"], "(:any)/edit", "Panel\Faq::edit/$1");
    $routes->post('trash-selected', 'Panel\Faq::trashSelected');
    // $routes->get('(:any)/trash', 'Panel\News::trash/$1');
    // $routes->get('(:any)/restore', 'Panel\News::restore/$1');
    $routes->get('(:any)/remove', 'Panel\Faq::remove/$1');
});

$routes->group("panel/ks", function ($routes) {
    $routes->get('/', 'Panel\Ks::index');
    $routes->post('fetch', 'Panel\Ks::fetchKerjasama');
    // $routes->post('fetch-draft', 'Panel\News::fetchNewsDraft');
    // $routes->post('fetch-trash', 'Panel\News::fetchNewsTrash');
    $routes->match(["get", "post"], "tambah", "Panel\Ks::tambah");
    $routes->match(["get", "post"], "(:any)/edit", "Panel\Ks::edit/$1");
    $routes->post('trash-selected', 'Panel\Ks::trashSelected');
    // $routes->get('(:any)/trash', 'Panel\News::trash/$1');
    // $routes->get('(:any)/restore', 'Panel\News::restore/$1');
    $routes->get('(:any)/remove', 'Panel\Ks::remove/$1');
});

$routes->group("panel/staff", function ($routes) {
    $routes->get('/', 'Panel\Staff::index');
    $routes->post('fetch', 'Panel\Staff::fetchStaff');
    // // $routes->post('fetch-draft', 'Panel\News::fetchNewsDraft');
    // // $routes->post('fetch-trash', 'Panel\News::fetchNewsTrash');
    $routes->match(["get", "post"], "tambah", "Panel\Staff::tambah");
    $routes->match(["get", "post"], "(:any)/edit", "Panel\Staff::edit/$1");
    // $routes->post('trash-selected', 'Panel\Ks::trashSelected');
    // // $routes->get('(:any)/trash', 'Panel\News::trash/$1');
    // // $routes->get('(:any)/restore', 'Panel\News::restore/$1');
    // $routes->get('(:any)/remove', 'Panel\Ks::remove/$1');
});
