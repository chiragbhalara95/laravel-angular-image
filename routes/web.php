<?php

Route::get('/', 'Frontend\HomeController@index');
Route::get('/home', 'Frontend\HomeController@index');

// Admin Route
Route::prefix('admin')->namespace('Admin')->group(function () {

    // File Module
    Route::get("/", "FilesController@files");
    Route::post("/upload/file", "FilesController@upload");
    Route::get('/file/list', 'FilesController@listFiles');
    Route::post("/delete/file", 'FilesController@delete');

    // Product Modules
    Route::get('/product', 'ProductController@index');
    Route::get('/product/list', 'ProductController@getProductList');
    Route::post('/product/createPrduct', 'ProductController@store');
    Route::post('/api/imageUpload', 'ProductController@imageUpload');
    Route::post('/product/{id}/update', 'ProductController@update');
    Route::delete('/product/{id}', 'ProductController@destroy');
    Route::get('/category/list', 'CategoryController@getCategoryList');
});
