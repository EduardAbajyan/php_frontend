<?php

Route::get('route/{id}/{username}', 'HomeController@showRouteParams')->name('route.params');
Route::get('', 'HomeController@index')->name('home');
Route::get('page1', 'HomeController@page1')->name('page1');
Route::get('page2', 'HomeController@page2')->name('page2');
Route::get('page3', 'HomeController@page3')->name('page3');
Route::get('page4', 'HomeController@page4')->name('page4');
Route::get('page5', 'HomeController@page5')->name('page5');
Route::get('page6', 'HomeController@page6')->name('page6');
Route::post('contact', 'HomeController@submitContact')->name('contact.submit');