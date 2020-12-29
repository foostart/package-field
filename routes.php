<?php

use Illuminate\Session\TokenMismatchException;

/**
 * FRONT
 */
Route::get('field', [
    'as' => 'field',
    'uses' => 'Foostart\Field\Controllers\Front\FieldFrontController@index'
]);


/**
 * ADMINISTRATOR
 */
Route::group(['middleware' => ['web']], function () {

    Route::group(['middleware' => ['admin_logged', 'can_see', 'in_context'],
                  'namespace' => 'Foostart\Field\Controllers\Admin',
        ], function () {

        /*
          |-----------------------------------------------------------------------
          | Manage field
          |-----------------------------------------------------------------------
          | 1. List of fields
          | 2. Edit field
          | 3. Delete field
          | 4. Add new field
          | 5. Manage configurations
          | 6. Manage languages
          |
        */

        /**
         * list
         */
        Route::get('admin/fields', [
            'as' => 'fields.list',
            'uses' => 'FieldAdminController@index'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/fields/edit', [
            'as' => 'fields.edit',
            'uses' => 'FieldAdminController@edit'
        ]);

        /**
         * copy
         */
        Route::get('admin/fields/copy', [
            'as' => 'fields.copy',
            'uses' => 'FieldAdminController@copy'
        ]);

        /**
         * field
         */
        Route::post('admin/fields/edit', [
            'as' => 'fields.field',
            'uses' => 'FieldAdminController@post'
        ]);

        /**
         * delete
         */
        Route::get('admin/fields/delete', [
            'as' => 'fields.delete',
            'uses' => 'FieldAdminController@delete'
        ]);

        /**
         * trash
         */
         Route::get('admin/fields/trash', [
            'as' => 'fields.trash',
            'uses' => 'FieldAdminController@trash'
        ]);

        /**
         * configs
        */
        Route::get('admin/fields/config', [
            'as' => 'fields.config',
            'uses' => 'FieldAdminController@config'
        ]);

        Route::post('admin/fields/config', [
            'as' => 'fields.config',
            'uses' => 'FieldAdminController@config'
        ]);

        /**
         * language
        */
        Route::get('admin/fields/lang', [
            'as' => 'fields.lang',
            'uses' => 'FieldAdminController@lang'
        ]);

        Route::post('admin/Fields/lang', [
            'as' => 'Fields.lang',
            'uses' => 'FieldAdminController@lang'
        ]);

    });
});
