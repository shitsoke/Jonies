<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CareerApplicationController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\SupervisorController;
use App\Models\MenuItem;
use App\Models\ContactMessage;
use App\Models\Promotion;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'pageContent' => SiteContent::getPageMap('home'),
        'promotions'  => Promotion::latest()->get(),
        'menuItems'   => MenuItem::latest()->take(6)->get(),
    ]);
})->name('home');

Route::get('/about', function () {
    return view('about', ['pageContent' => SiteContent::getPageMap('about')]);
})->name('about');

Route::get('/location', function () {
    return view('location', ['pageContent' => SiteContent::getPageMap('location')]);
})->name('location');

Route::get('/careers', function () {
    return view('careers', ['pageContent' => SiteContent::getPageMap('careers')]);
})->name('careers');

Route::get('/contact', function () {
    return view('contact', ['pageContent' => SiteContent::getPageMap('contact')]);
})->name('contact');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string|max:10000',
    ]);

    ContactMessage::create($validated);

    return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent.');
})->name('contact.submit');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu-items/{menuItem}', [MenuController::class, 'show'])->name('menu-items.show');
Route::get('/foods/{slug}', [MenuController::class, 'showFeatured'])->name('foods.show');
Route::get('/promotions/{promotion}', [PromotionController::class, 'show'])->name('promotions.show');

Route::get('/admin/login', [MenuController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/admin/login', [MenuController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [MenuController::class, 'adminLogout'])->name('admin.logout');

Route::get('/admin/menu', [MenuController::class, 'adminIndex'])->name('admin.menu');
Route::post('/admin/menu', [MenuController::class, 'store'])->name('admin.menu.store');
Route::get('/admin/menu/{menuItem}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
Route::put('/admin/menu/{menuItem}', [MenuController::class, 'update'])->name('admin.menu.update');
Route::delete('/admin/menu/{menuItem}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');

Route::get('/admin/promotions', [PromotionController::class, 'adminIndex'])->name('admin.promotions');
Route::post('/admin/promotions', [PromotionController::class, 'store'])->name('admin.promotions.store');
Route::get('/admin/promotions/{promotion}/edit', [PromotionController::class, 'edit'])->name('admin.promotions.edit');
Route::put('/admin/promotions/{promotion}', [PromotionController::class, 'update'])->name('admin.promotions.update');
Route::delete('/admin/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('admin.promotions.destroy');

Route::get('/admin/content', [SiteContentController::class, 'adminIndex'])->name('admin.content');
Route::post('/admin/content', [SiteContentController::class, 'save'])->name('admin.content.save');

Route::post('/careers/apply', [CareerApplicationController::class, 'store'])->name('careers.apply');

Route::get('/reservation', [ReservationController::class, 'publicForm'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/success/{reservation}', [ReservationController::class, 'success'])->name('reservation.success');
Route::get('/reservation/status', [ReservationController::class, 'lookup'])->name('reservation.status');
Route::post('/reservation/status', [ReservationController::class, 'lookup'])->name('reservation.status.submit');

Route::get('/supervisor/login', [SupervisorController::class, 'loginForm'])->name('supervisor.login');
Route::post('/supervisor/login', [SupervisorController::class, 'login'])->name('supervisor.login.submit');
Route::post('/supervisor/logout', [SupervisorController::class, 'logout'])->name('supervisor.logout');
Route::middleware('auth')->group(function () {
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
    Route::post('/supervisor/reservations/{reservation}/process', [SupervisorController::class, 'processReservation'])->name('supervisor.reservations.process');
});

Route::get('/admin/branches', [BranchController::class, 'adminIndex'])->name('admin.branches');
Route::post('/admin/branches', [BranchController::class, 'store'])->name('admin.branches.store');
Route::get('/admin/branches/{branch}/edit', [BranchController::class, 'edit'])->name('admin.branches.edit');
Route::put('/admin/branches/{branch}', [BranchController::class, 'update'])->name('admin.branches.update');
Route::post('/admin/branches/{branch}/toggle', [BranchController::class, 'toggleStatus'])->name('admin.branches.toggle');

Route::get('/admin/supervisors', [SupervisorController::class, 'adminIndex'])->name('admin.supervisors');
Route::get('/admin/supervisors/{user}/edit', [SupervisorController::class, 'edit'])->name('admin.supervisors.edit');
Route::post('/admin/supervisors', [SupervisorController::class, 'store'])->name('admin.supervisors.store');
Route::put('/admin/supervisors/{user}', [SupervisorController::class, 'update'])->name('admin.supervisors.update');
Route::post('/admin/supervisors/{user}/toggle', [SupervisorController::class, 'toggleStatus'])->name('admin.supervisors.toggle');

Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('admin.reservations');
Route::get('/admin/reservations/{reservation}', [ReservationController::class, 'details'])->name('admin.reservations.show');
Route::post('/admin/reservations/{reservation}/process', [ReservationController::class, 'process'])->name('admin.reservations.process');