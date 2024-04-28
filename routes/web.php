<?php

use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\LeaveCategoryController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'perform'])->name('logout.perform');

Auth::routes();


Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // :::::::: Start User Route ::::::::::::::

    Route::get('admin/users/profile/', function () {
        return View::make('admin/users/user_profile');
    });
    Route::post('admin/users/editProfile/', [UsersController::class, 'editProfile']);
    Route::resource('admin/users', UsersController::class, ['except' => ['show']]);
    Route::get('admin/users/activate/{id}/{param?}', [UsersController::class, 'active']);

    // :::::::: End User Route ::::::::::::::


    
    // UserGroupController all routes
    Route::post('admin/userGroup/filter/', [UserGroupController::class, 'filter']);
    Route::get('admin/userGroup', [UserGroupController::class, 'index'])->name('userGroup.index');
    Route::get('admin/userGroup/create', [UserGroupController::class, 'create'])->name('userGroup.create');
    Route::post('admin/userGroup', [UserGroupController::class, 'store'])->name('userGroup.store');
    Route::get('admin/userGroup/{id}/edit', [UserGroupController::class, 'edit'])->name('userGroup.edit');
    Route::patch('admin/userGroup/{id}', [UserGroupController::class, 'update'])->name('userGroup.update');
    Route::delete('admin/userGroup/{id}', [UserGroupController::class, 'destroy'])->name('userGroup.destroy');

    // LeaveCategoryController all routes
    Route::post('admin/leaveCategory/filter/', [LeaveCategoryController::class, 'filter']);
    Route::get('admin/leaveCategory', [LeaveCategoryController::class, 'index'])->name('leaveCategory.index');
    Route::get('admin/leaveCategory/create', [LeaveCategoryController::class, 'create'])->name('leaveCategory.create');
    Route::post('admin/leaveCategory', [LeaveCategoryController::class, 'store'])->name('leaveCategory.store');
    Route::get('admin/leaveCategory/{id}/edit', [LeaveCategoryController::class, 'edit'])->name('leaveCategory.edit');
    Route::patch('admin/leaveCategory/{id}', [LeaveCategoryController::class, 'update'])->name('leaveCategory.update');
    Route::delete('admin/leaveCategory/{id}', [LeaveCategoryController::class, 'destroy'])->name('leaveCategory.destroy');

    // LeaveApplication all routes
    Route::get('admin/leaveApplication', [LeaveApplicationController::class, 'index'])->name('leaveApplication.index');
    Route::get('admin/leaveApplication/create', [LeaveApplicationController::class, 'create'])->name('leaveApplication.create');
    Route::post('admin/leaveApplication', [LeaveApplicationController::class, 'store'])->name('leaveApplication.store');
    Route::get('admin/leaveApplication/{id}/edit', [LeaveApplicationController::class, 'edit'])->name('leaveApplication.edit');
    Route::patch('admin/leaveApplication/{id}', [LeaveApplicationController::class, 'update'])->name('leaveApplication.update');
    Route::delete('admin/leaveApplication/{id}', [LeaveApplicationController::class, 'destroy'])->name('leaveApplication.destroy');
    Route::post('admin/leaveApplication/filter/', [LeaveApplicationController::class, 'filter']);
    
    Route::get('admin/leaveApplication/approve/{id}/{param?}', [LeaveApplicationController::class, 'approve']);
    Route::get('admin/leaveApplication/reject/{id}/{param?}', [LeaveApplicationController::class, 'reject']);
    Route::post('admin/leaveApplication/remarks', [LeaveApplicationController::class, 'remarks']);
    Route::post('admin/leaveApplication/saveRemarks', [LeaveApplicationController::class, 'saveRemarks']);

});

Route::get('/{pathMatch}', function(){
    return redirect('/login');
})->where('pathMatch', ".*");
