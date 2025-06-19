<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ChatController;

// Authentication routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->middleware(['web'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Department routes
    Route::get('/departments', [AdminController::class, 'manageDepartments'])->name('admin.departments');
    Route::match(['get', 'post'], '/departments/add', [AdminController::class, 'addDepartment'])->name('admin.departments.add');
    Route::get('/departments/delete/{id}', [AdminController::class, 'deleteDepartment'])->name('admin.departments.delete');
    Route::match(['get', 'post'], '/departments/edit/{id}', [AdminController::class, 'editDepartment'])->name('admin.departments.edit');
    
    // Employee routes
    Route::get('/employees', [AdminController::class, 'manageEmployees'])->name('admin.employees');
    Route::match(['get', 'post'], '/employees/add', [AdminController::class, 'addEmployee'])->name('admin.employees.add');
    Route::match(['get', 'post'], '/employees/edit/{id}', [AdminController::class, 'editEmployee'])->name('admin.employees.edit');
    Route::get('/employees/delete/{id}', [AdminController::class, 'deleteEmployee'])->name('admin.employees.delete');
    
    // DataTables routes
    Route::get('/employees/data', [AdminController::class, 'getEmployeesData'])->name('admin.employees.data');
    Route::get('/department/employees', [AdminController::class, 'getDepartmentEmployees'])->name('admin.department.employees');
    
    // Batch processing
    Route::match(['get', 'post'], '/employees/batch', [AdminController::class, 'batchProcess'])->name('admin.employees.batch');
    
    // Department Tree Report
    Route::get('/department-tree', [AdminController::class, 'departmentTreeReport'])->name('admin.department.tree');
});

// Employee routes
Route::prefix('employee')->middleware(['web'])->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::match(['get', 'post'], '/edit-profile', [EmployeeController::class, 'editProfile'])->name('employee.edit.profile');
});

// Chat routes
Route::get('/chat', [ChatController::class, 'index'])->name('chat');
Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

