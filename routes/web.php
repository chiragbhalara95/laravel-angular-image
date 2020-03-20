<?php


Route::get("/", "FilesController@files");

Route::post("upload/file", "FilesController@upload");

Route::get('/file/list', 'FilesController@listFiles');

Route::post("/delete/file", 'FilesController@delete');

Route::get('/admin/product', 'ProductController@index');
Route::get('/admin/product/list', 'ProductController@getProductList');
Route::post('/admin/product/createPrduct', 'ProductController@store');
Route::post('/admin/api/imageUpload', 'ProductController@imageUpload');
Route::post('/admin/product/{id}/update', 'ProductController@update');
Route::delete('/admin/product/{id}', 'ProductController@destroy');

Route::get('/admin/category/list', 'CategoryController@getCategoryList');
