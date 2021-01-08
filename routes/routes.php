<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get('/', 'FrontController@home');
Router::form('/diagnosa', 'FrontController@diagnosa')->name('diagnosa.page');
Router::get('/diagnosa/start', 'FrontController@startDiagnosa')->name('diagnosa.start');
Router::get('/diagnosa/boom', 'FrontController@diagnosaBoom')->name('diagnosa.boom');
Router::get('/diagnosa/fail', 'FrontController@diagnosaFail')->name('diagnosa.fail');
Router::get('/diagnosa/start/id/{id}', 'FrontController@DiagnosaRenderView')->name('diagnosa.render');;
Router::get('/logout', 'FrontController@logout')->name('logout');
Router::form('/login', 'FrontController@login', array( 'middleware' => \Middlewares\AuthMiddleware::class ))->name('login.page');
Router::form('/register', 'FrontController@register', array( 'middleware' => \Middlewares\AuthMiddleware::class ))->name('register.page');
Router::get('/loginbaru', 'FrontController@loginbaru');