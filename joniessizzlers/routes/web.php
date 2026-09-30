<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\CareerApplicationController;
use App\Models\Promotion;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'pageContent' => SiteContent::getPageMap('home'),
        'promotions' => Promotion::latest()->get(),
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
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent.');
})->name('contact.submit');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
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