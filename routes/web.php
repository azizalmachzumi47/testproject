<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Data_mhsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

// use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('auth');
});

Route::middleware(['guest'])->group(function(){
    Route::get('auth',[AuthController::class,'auth'])->name('auth');

    Route::post('login',[AuthController::class,'login'])->name('login');
    Route::post('register',[AuthController::class,'register'])->name('register');
});

Route::get('admin', [AdminController::class, 'index'])
    ->name('admin')
    ->middleware('role:1');

Route::get('user', [UserController::class, 'index'])
    ->name('user')
    ->middleware('role:2');


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Admin routes
    Route::get('admin',[AdminController::class, 'index'])->name('admin.index');
    Route::put('admin/edituser/{id}', [AdminController::class, 'edituser'])->name('admin.edituser');
    Route::delete('admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('admin/role',[AdminController::class, 'role'])->name('admin.role');
    Route::post('admin/addrole', [AdminController::class, 'addrole'])->name('admin.addrole');
    Route::get('admin/role_edit/{id}', [AdminController::class, 'role_edit'])->name('admin.role_edit');
    Route::post('admin/role_update/{id}', [AdminController::class, 'role_update'])->name('admin.role_update');
    Route::get('admin/role_delete/{id}', [AdminController::class, 'role_delete'])->name('admin.role_delete');
    Route::get('admin/roleaccess/{id}', [AdminController::class, 'roleAccess'])->name('admin.roleaccess');
    Route::post('admin/changeAccess', [AdminController::class, 'changeAccess'])->name('admin.changeAccess');

    //Menu
    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('menu/addmenu', [MenuController::class, 'addmenu'])->name('menu.addmenu');
    Route::get('menu/editmenu/{id}', [MenuController::class, 'editmenu'])->name('menu.editmenu');
    Route::post('menu/editmenu_action/{id}', [MenuController::class, 'editmenu_action'])->name('menu.editmenu_action');
    Route::get('menu/delete/{id}', [MenuController::class, 'delete'])->name('menu.delete');

    //SubMenu
    Route::get('menu/submenu', [MenuController::class, 'submenu'])->name('menu.submenu');
    Route::post('menu/submenu', [MenuController::class, 'addSubMenu'])->name('menu.addSubMenu');
    Route::put('menu/editSubMenu/{id}', [MenuController::class, 'editSubMenu'])->name('menu.editSubMenu');
    Route::delete('menu/deleteSubMenu/{id}', [MenuController::class, 'deleteSubMenu'])->name('menu.deleteSubMenu');

    //Data Mahasiswa
    Route::get('data_mhs', [Data_mhsController::class, 'index'])->name('data_mhs.index');
    Route::post('data_mhs/adddatamhs', [Data_mhsController::class, 'adddatamhs'])->name('data_mhs.adddatamhs');
    Route::get('data_mhs/editdata/{id}', [Data_mhsController::class, 'editdata'])->name('data_mhs.editdata');
    Route::post('data_mhs/editdata_action/{id}', [Data_mhsController::class, 'editdata_action'])->name('data_mhs.editdata_action');
    Route::get('data_mhs/delete/{id}', [Data_mhsController::class, 'delete'])->name('data_mhs.delete');
    Route::get('data_mhs/dataapi', [Data_mhsController::class, 'dataapi'])->name('data_mhs.dataapi');
    Route::post('data_mhs/savedataapi', [Data_mhsController::class, 'savedataapi'])->name('data_mhs.savedataapi');
    Route::delete('data_mhs/destroy-all', [Data_mhsController::class, 'destroyAll'])->name('data_mhs.destroyAll');

});

Route::middleware(['auth', UserMiddleware::class])->group(function () {
    // User routes
    Route::get('user', [UserController::class, 'index'])->name('user.index');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


// Route::middleware(['auth'])->group(function(){
    
// });



Route::post('logout',[AuthController::class,'logout'])->name('logout');

Route::get('email/verify/{id}/{hash}',[AuthController::class,'verify'])->name('verification.verify');

Route::get('/auth/google/redirect', function() {
    return Socialite::driver('google')->redirect();
})->name('google');

Route::get('/auth/google/callback', function() {
    // dd(Socialite::driver('google'));
    $googleUser = Socialite::driver('google')->user();
    // dd($googleUser);
    $user = User::where('email',$googleUser->getEmail())->first();

    if($user){
        if(empty($user->image) || !str_starts_with($user->image, 'images/')){
            $user->image = $googleUser->getAvatar();
        }

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
        }

        $user->save();
    }else{
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make($googleUser->password),
            'image' => $googleUser->getAvatar(),
            'google_id' => $googleUser->getId()
        ]);
    }

    Auth::login($user);
    return redirect()->route('user.index');
});

// Route::get('/test-email', function () {
//     Mail::raw('Ini adalah tes pengiriman email dari Laravel', function ($message) {
//         $message->to('azizalmachzumi21@gmail.com')
//                 ->subject('Tes Pengiriman Email dari Laravel');
//     });

//     return 'Cek email untuk memastikan pengiriman berhasil!';
// });