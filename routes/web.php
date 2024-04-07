<?php

use App\Http\Controllers\BackEnd\AuthController;
use App\Http\Controllers\BackEnd\CategoriesController;
use App\Http\Controllers\BackEnd\CategoryPostController;
use App\Http\Controllers\BackEnd\CouponController;
use App\Http\Controllers\BackEnd\DashboardController;
use App\Http\Controllers\BackEnd\ImportsController;
use App\Http\Controllers\BackEnd\OrdersController;
use App\Http\Controllers\BackEnd\PostsController;
use App\Http\Controllers\BackEnd\ProductsController;
use App\Http\Controllers\BackEnd\RoleController;
use App\Http\Controllers\BackEnd\SliderController;
use App\Http\Controllers\BackEnd\TagsController;
use App\Http\Controllers\BackEnd\UsersController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LinkController;
use App\Http\Controllers\User\MailController;
use App\Http\Controllers\User\MyAccountController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\SharedController;
use App\Http\Controllers\User\SocialController;
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
Route::controller(PostController::class)->group(function () {
    Route::get('bai-viet', 'index')->name('post.index');
    Route::get('bai-viet/thang-{id}', 'edit')->name('post.edit');
    Route::get('bai-viet/{id}', 'show')->name('post.show');
});
Route::controller(LinkController::class)->group(function () {
    Route::get('yeu-thich', 'index')->name('links.index');
    Route::get('so-sanh', 'create')->name('link.create');
    Route::get('yeu-thich/{id}', 'show')->name('link.show');
    Route::get('so-sanh/{id}', 'edit')->name('link.edit');
    Route::post('so-sanh/tim-kiem', 'store')->name('link.store');
});
Route::controller(SharedController::class)->group(function () {
    Route::get('lien-he', 'index')->name('contact.index');
    Route::get('gioi-thieu', 'create')->name('about.create');
    Route::post('them-ma-giam-gia', 'store')->name('shared.store');
    Route::get('tag/{id}', 'show')->name('shared.show');
});
Route::controller(MyAccountController::class)->group(function () {
    Route::get('thong-tin-tai-khoan', 'index')->name('myaccount.index');
    Route::post('thong-tin-tai-khoan', 'store')->name('myaccount.store');
    Route::get('thong-tin-tai-khoan/don-hang/{id}', 'show')->name('myaccount.show');
});
Route::controller(AuthUserController::class)->group(function () {
    Route::get('dang-nhap', 'index')->name('authuser.signin.index');
    Route::get('dang-ky', 'index')->name('authuser.signup.index');
    Route::get('quen-mat-khau', 'create')->name('authuser.create');
});
Route::controller(SocialController::class)->group(function () {
    Route::get('dang-nhap/google', 'index')->name('social.google.index');
    Route::get('google/callback', 'create')->name('social.google.create');
    // Route::get('dang-nhap/facebook', 'index')->name('social.facebook.index');
    // Route::get('facebook/callback', 'create')->name('social.facebook.create');
});
Route::prefix('gui-mail')->controller(MailController::class)->group(function () {
    Route::get('loi-phan-hoi', 'index')->name('mail.index');
    Route::get('fake', 'create')->name('mail.create');
    Route::post('member/forget-password', 'store')->name('mail.store');
    Route::get('member/forget-password/{id}', 'show')->name('mail.show');
    Route::put('member/new-password/{id}', 'update')->name('mail.update');
});
Route::middleware('cors')->controller(CartController::class)->group(function () {
    Route::get('gio-hang', 'index')->name('cart.index');
    Route::get('thanh-toan', 'create')->name('cart.create');
    Route::post('thanh-toan', 'store')->name('cart.store');
    Route::get('xoa-gio-hang/{id}', 'show')->name('cart.show');
    Route::get('sua-gio-hang/{id}', 'edit');

    Route::get('paypal', 'getPaymentStatus')->name('status');
});
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('san-pham', 'create')->name('all.create');
    Route::get('tim-kiem', 'create')->name('search.index');
    Route::post('them-gio-hang', 'store')->name('home.store');
    Route::get('/{id}', 'show')->name('home.show');
});

Route::prefix('admin')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('tongquan', [
            'uses' => 'index',
            'as' => 'tongquan.index',
            'middleware' => 'can:list-dashboard',
        ]);
        Route::get('module', [
            'uses' => 'create',
            'as' => 'tongquan.create',
            'middleware' => 'can:add-dashboard',
        ]);
        Route::post('module/store', [
            'uses' => 'store',
            'as' => 'tongquan.store',
            'middleware' => 'can:add-dashboard',
        ]);
    });
    Route::prefix('taikhoan')->controller(UsersController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'taikhoan.index',
            'middleware' => 'can:list-user',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'taikhoan.create',
            'middleware' => 'can:add-user',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'taikhoan.store',
            'middleware' => 'can:add-user',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'taikhoan.edit',
            'middleware' => 'can:edit-user',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'taikhoan.show',
            // 'middleware' => 'can:edit-user',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'taikhoan.update',
            'middleware' => 'can:edit-user',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'taikhoan.destroy',
            'middleware' => 'can:delete-user',
        ]);

    });
    Route::prefix('theloai')->controller(CategoriesController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'theloai.index',
            'middleware' => 'can:list-category',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'theloai.create',
            'middleware' => 'can:add-category',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'theloai.store',
            'middleware' => 'can:add-category',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'theloai.edit',
            'middleware' => 'can:edit-category',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'theloai.show',
            // 'middleware' => 'can:edit-category',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'theloai.update',
            'middleware' => 'can:edit-category',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'theloai.destroy',
            'middleware' => 'can:delete-category',
        ]);

    });
    Route::prefix('sanpham')->controller(ProductsController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'sanpham.index',
            'middleware' => 'can:list-product',
        ]);
        Route::get('/dienthoai/create', [
            'uses' => 'create',
            'as' => 'sanpham.phone.create',
            'middleware' => 'can:add-product',
        ]);
        Route::get('/phukien/create', [
            'uses' => 'create',
            'as' => 'sanpham.accessory.create',
            'middleware' => 'can:add-product',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'sanpham.store',
            'middleware' => 'can:add-product',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'sanpham.edit',
            'middleware' => 'can:edit-product',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'sanpham.show',
            // 'middleware' => 'can:edit-product',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'sanpham.update',
            'middleware' => 'can:edit-product',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'sanpham.destroy',
            'middleware' => 'can:delete-product',
        ]);

    });
    Route::prefix('donhang')->controller(OrdersController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'donhang.index',
            'middleware' => 'can:list-order',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'donhang.create',
            'middleware' => 'can:add-order',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'donhang.store',
            'middleware' => 'can:add-order',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'donhang.edit',
            'middleware' => 'can:edit-order',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'donhang.show',
            'middleware' => 'can:pdf-order',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'donhang.update',
            'middleware' => 'can:edit-order',
        ]);

    });
    Route::prefix('giamgia')->controller(CouponController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'giamgia.index',
            'middleware' => 'can:list-discount',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'giamgia.create',
            'middleware' => 'can:add-discount',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'giamgia.store',
            'middleware' => 'can:add-discount',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'giamgia.edit',
            'middleware' => 'can:edit-discount',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'giamgia.show',
            // 'middleware' => 'can:edit-discount',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'giamgia.update',
            'middleware' => 'can:edit-discount',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'giamgia.destroy',
            'middleware' => 'can:delete-discount',
        ]);

    });
    Route::prefix('slider')->controller(SliderController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'slider.index',
            'middleware' => 'can:list-slider',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'slider.create',
            'middleware' => 'can:add-slider',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'slider.store',
            'middleware' => 'can:add-slider',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'slider.edit',
            'middleware' => 'can:edit-slider',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'slider.show',
            // 'middleware' => 'can:edit-slider',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'slider.update',
            'middleware' => 'can:edit-slider',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'slider.destroy',
            'middleware' => 'can:delete-slider',
        ]);

    });
    Route::prefix('vaitro')->controller(RoleController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'vaitro.index',
            'middleware' => 'can:list-role',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'vaitro.create',
            'middleware' => 'can:add-role',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'vaitro.store',
            'middleware' => 'can:add-role',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'vaitro.edit',
            'middleware' => 'can:edit-role',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'vaitro.show',
            // 'middleware' => 'can:edit-role',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'vaitro.update',
            'middleware' => 'can:edit-role',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'vaitro.destroy',
            'middleware' => 'can:delete-role',
        ]);

    });
    Route::prefix('baiviet')->controller(PostsController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'baiviet.index',
            'middleware' => 'can:list-post',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'baiviet.create',
            'middleware' => 'can:add-post',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'baiviet.store',
            'middleware' => 'can:add-post',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'baiviet.show',
            'middleware' => 'can:edit-post',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'baiviet.update',
            'middleware' => 'can:edit-post',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'baiviet.destroy',
            'middleware' => 'can:delete-post',
        ]);

    });
    Route::prefix('loai/baiviet')->controller(CategoryPostController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'loaibaiviet.index',
            'middleware' => 'can:list-type',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'loaibaiviet.create',
            'middleware' => 'can:add-type',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'loaibaiviet.store',
            'middleware' => 'can:add-type',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'loaibaiviet.show',
            'middleware' => 'can:edit-type',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'loaibaiviet.update',
            'middleware' => 'can:edit-type',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'loaibaiviet.destroy',
            'middleware' => 'can:delete-type',
        ]);

    });
    Route::prefix('tags')->controller(TagsController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'tags.index',
            'middleware' => 'can:list-tag',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'tags.create',
            'middleware' => 'can:add-tag',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'tags.store',
            'middleware' => 'can:add-tag',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'tags.edit',
            'middleware' => 'can:edit-tag',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'tags.show',
            // 'middleware' => 'can:edit-tag',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'tags.update',
            'middleware' => 'can:edit-tag',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'tags.destroy',
            'middleware' => 'can:delete-tag',
        ]);

    });
    Route::prefix('phieunhap')->controller(ImportsController::class)->group(function () {
        Route::get('/', [
            'uses' => 'index',
            'as' => 'phieunhap.index',
            'middleware' => 'can:list-import',
        ]);
        Route::get('/create', [
            'uses' => 'create',
            'as' => 'phieunhap.create',
            'middleware' => 'can:add-import',
        ]);
        Route::post('/store', [
            'uses' => 'store',
            'as' => 'phieunhap.store',
            'middleware' => 'can:add-import',
        ]);
        Route::get('/{id}/edit', [
            'uses' => 'edit',
            'as' => 'phieunhap.edit',
            'middleware' => 'can:pdf-import',
        ]);
        Route::get('/{id}', [
            'uses' => 'show',
            'as' => 'phieunhap.show',
            'middleware' => 'can:edit-import',
        ]);
        Route::put('/update/{id}', [
            'uses' => 'update',
            'as' => 'phieunhap.update',
            'middleware' => 'can:edit-import',
        ]);
        Route::delete('/delete/{id}', [
            'uses' => 'destroy',
            'as' => 'phieunhap.destroy',
            'middleware' => 'can:delete-import',
        ]);

    });
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', [
            'uses' => 'index',
            'as' => 'auth.index',
        ]);
        Route::get('register', [
            'uses' => 'create',
            'as' => 'auth.create',
        ]);
        Route::post('auth/store', [
            'uses' => 'store',
            'as' => 'auth.store',
        ]);

    });
});