<?php

use App\Http\Controllers\Admin\CashBookController;
use App\Http\Controllers\Admin\CashNoteController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasteTypeController;
use App\Models\CashBook;
use App\Models\CashNote;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Jetstream;


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

Route::get('/', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('/dashboard', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('simple-qr-code', function () {
    return view('pdf.product');
});

Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum', 'web', 'verified'])->group(function () {
    Route::post('/summernote-upload', [SupportController::class, 'upload'])->name('summernote_upload');
    Route::view('/dashboard', "dashboard")->name('dashboard');
    Route::resource('wasteType', WasteTypeController::class)->only('index','create','edit');

    Route::get('/user/{id}', [UserController::class, "index"])->name('user');
    Route::get('/user/recap/{id}', [UserController::class, "recap"])->name('user.recap');
    Route::view('/user/new', "pages.user.create")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.edit")->name('user.edit');
    Route::get('/user/deposit-detail/{userId}', [UserController::class, "show"])->name('user.show');

    Route::get('/pickup-history',function (){
        $wasteDeposits=\App\Models\WasteDeposit::orderByDesc('id')->get();
        return view('pages.pickup.index',compact('wasteDeposits'));
    })->name('pickup');

    Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
        Route::group(['middleware' => ['auth', 'verified']], function () {
            // User & Profile...
            Route::get('/user/profile', [UserProfileController::class, 'show'])
                ->name('profile.show');

            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            }

            // Teams...
            if (Jetstream::hasTeamFeatures()) {
                Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
                Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
            }
        });
    });
});
