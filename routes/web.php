<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@welcome');

Route::group(['middleware' => ['auth']], function () {

    //Tasks
    Route::get('tasks', 'TaskController@index')->name('tasks.index')->middleware('teacher'); //haal de taken op van github
    Route::get('tasks/retrieve', 'AdminController@tasks')->name('tasks.retrieve')->middleware('teacher'); //haal de taken op van github
    Route::get('tasks/{task}', 'TaskController@show')->name('tasks.show')->middleware('student'); //haal de taken op van github
    
    //Users
    Route::get('users/{user}/module/{module}/task/code/{path?}', 'AdminController@show_code')->where('path', '.*')->name('tasks.code')->middleware('teacher'); //docent mag gebruiker details bekijken
    Route::get('users/upload_data', 'AdminController@select_file')->name('users.select_file')->middleware('admin');
    Route::post('users/upload_data', 'AdminController@upload_data')->name('users.upload_data')->middleware('admin');
    Route::post('users/change_passwords', 'AdminController@change_password')->name('users.change_password')->middleware('admin');

    Route::get('users/create', 'AdminController@create')->name('users.create')->middleware('admin');
    Route::get('users', 'AdminController@index')->name('users.index')->middleware('teacher'); //docent mag gebruikers lijst zien
    Route::post('users', 'AdminController@store')->name('users.store')->middleware('admin');
    Route::get('users/{user}', 'AdminController@show')->name('users.show')->middleware('teacher'); //docent mag gebruiker details bekijken

    Route::get('users/{user}/module/{module}', 'AdminController@show_module')->name('users.repo')->middleware('teacher'); //docent mag gebruiker details bekijken
    Route::get('users/{user}/module/{module}/task/{path?}', 'AdminController@show_task')->where('path', '.*')->name('users.task')->middleware('teacher'); //docent mag gebruiker details bekijken
    
    Route::get('users/{user}/edit', 'AdminController@edit')->name('users.edit')->middleware('admin');
    Route::put('users/{user}', 'AdminController@update')->name('users.update')->middleware('admin');
    
    
    

    //Classrooms
    Route::get('classrooms', 'ClassroomController@index')->name('classrooms.index')->middleware('teacher');
    Route::get('classrooms/{classroom}/student_level', 'ClassroomController@show_levels')->name('classrooms.show_levels')->middleware('teacher');

    //DASHBOARDS
    Route::get('/student', 'StudentController@dashboard')->name('student')->middleware('student'); //1
    Route::get('/admin', 'AdminController@dashboard')->name('admin')->middleware('admin');
    Route::get('/teacher', 'TeacherController@dashboard')->name('teacher')->middleware('teacher');

    //Modules
    Route::get('modules', 'ModuleController@index')->name('modules.index');
    Route::get('modules/retrieve', 'AdminController@modules')->name('modules.retrieve')->middleware('teacher'); //haal de taken op van github
    Route::get('modules/{module}', 'ModuleController@show')->name('modules.show');
    
    // Route::get('modules/{repo}/file/{path}', 'ModuleController@show')->where('path', '.*')->name('tasks.show');

    // Route::get('modules/{repo}/{path?}', 'StudentController@show_module')->where('path', '.*')->name('modules-students.show');

    //Github
    // Route::get('github', 'GithubController@index')->name('github.index');
    // Route::get('github/{repo}/fork', 'GithubController@fork')->name('github.fork');
    // Route::get('github/{repo}/{path?}', 'GithubController@show')->name('github.show');
    // Route::get('github/{repo}/edit-file/{path}', 'GithubController@edit')->where('path', '.*')->name('github.edit-file');
    Route::get('github-call', 'GithubController@redirectToProvider')->name('github.call');
    Route::get('github-callback', 'GithubController@handleProviderCallback')->name('github.callback');

    //LOGOUT
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
