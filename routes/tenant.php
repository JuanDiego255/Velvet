<?php

declare(strict_types=1);

use App\Http\Controllers\AddressUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\ClothingCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\MetaTagsController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SocialNetworkController;
use App\Http\Controllers\TenantCarouselController;
use App\Http\Controllers\TenantInfoController;
use App\Http\Controllers\TenantSocialNetworkController;
use App\Models\TenantCarousel;
use App\Models\TenantSocialNetwork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    //Google authentication ----->
    Route::get('/google-auth/redirect', [AuthController::class, 'redirectGoogle']);
    Route::get('/google-auth/callback', [AuthController::class, 'callbackGoogle']);
    //Google authentication <-----

    //Facebook authentication ------>
    Route::get('/facebook-auth/redirect', [AuthController::class, 'redirectFacebook']);
    Route::get('/facebook-auth/callback', [AuthController::class, 'callbackFacebook']);
    //Facebook authentication <------

    Route::get('/', [FrontendController::class, 'index']);
    Route::get('category', [FrontendController::class, 'category']);
    Route::get('clothes-category/{id}', [FrontendController::class, 'clothesByCategory']);
    Route::get('detail-clothing/{id}/{cat_id}', [FrontendController::class, 'DetailClothingById']);
    Route::post('/add-to-cart', [CartController::class, 'store']);
    Route::post('/edit-quantity', [CartController::class, 'updateQuantity']);
    Route::get('/view-cart', [CartController::class, 'viewCart']);
    Route::delete('/delete-item-cart/{id}/{size_id}', [CartController::class, 'delete']);
    Route::post('/payment', [CheckOutController::class, 'payment']);
    Route::get('/paypal/process/{orderId}', [CheckOutController::class, 'process']);
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['auth'], function () {

        Route::get('checkout', [CheckOutController::class, 'index']);
        Route::get('/buys', [BuyController::class, 'index']);
        //::post('cancel/buy/{id}/{status}', [BuyController::class, 'cancelBuy']);
        //Route::post('cancel/buy-item/{id}/{status}', [BuyController::class, 'cancelBuyItem']);
        Route::get('/buy/details/{id}', [BuyController::class, 'buyDetails']);
        Route::post('address/store', [AddressUserController::class, 'store']);
        Route::post('address/status/{id}', [AddressUserController::class, 'status']);
        Route::put('/address/update/{id}', [AddressUserController::class, 'update']);
        Route::get('/address', [AddressUserController::class, 'index']);
        Route::delete('/delete/address/{id}', [AddressUserController::class, 'destroy']);
    });

    Route::group(['middleware' => 'isAdmin'], function () {
        //Routes for Categories
        Route::get('/dashboard', [FrontendController::class, 'index']);
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/add-category', [CategoryController::class, 'add']);
        Route::get('/edit-category/{id}', [CategoryController::class, 'edit']);
        Route::post('/insert-category', [CategoryController::class, 'store']);
        Route::put('/update-category/{id}', [CategoryController::class, 'update']);
        Route::delete('/delete-category/{id}', [CategoryController::class, 'delete']);
        //Routes for ArticleCategory
        Route::get('/add-item/{id}', [ClothingCategoryController::class, 'indexById']);
        Route::get('/new-item/{id}', [ClothingCategoryController::class, 'add']);
        Route::post('/insert-clothing', [ClothingCategoryController::class, 'store']);
        Route::get('/edit-clothing/{id}/{cat_id}', [ClothingCategoryController::class, 'edit']);
        Route::put('/update-clothing/{id}', [ClothingCategoryController::class, 'update']);
        Route::delete('/delete-clothing/{id}', [ClothingCategoryController::class, 'delete']);
        //Routes for Buys
        Route::get('/buys-admin', [BuyController::class, 'indexAdmin']);
        Route::get('/buy/details/admin/{id}', [BuyController::class, 'buyDetailsAdmin']);
        Route::put('/approve/{id}/{approved}', [BuyController::class, 'approve']);
        Route::put('/delivery/{id}/{delivery}', [BuyController::class, 'delivery']);

        //Rutas para tallas
        Route::post('sizes/store', [SizeController::class, 'store']);
        Route::put('/sizes/update/{id}', [SizeController::class, 'update']);
        Route::get('/sizes', [SizeController::class, 'index']);
        Route::delete('/delete/sizes/{id}', [SizeController::class, 'destroy']);
        //Rutas Metatags
        Route::get('/meta-tags/indexadmin', [MetaTagsController::class, 'index']);
        Route::post('/metatag', [MetaTagsController::class, 'store']);
        Route::get('/metatag/agregar', [MetaTagsController::class, 'agregar']);
        Route::get('metatag/edit/{id}', [MetaTagsController::class, 'edit']);
        Route::put('metatags/{id}', [MetaTagsController::class, 'update']);
        Route::delete('delete-metatag/{id}', [MetaTagsController::class, 'destroy']);
        //Rutas para redes sociales seccion
        Route::post('social/store', [SocialNetworkController::class, 'store']);
        Route::put('/social/update/{id}', [SocialNetworkController::class, 'update']);
        Route::get('/social-network', [SocialNetworkController::class, 'index']);
        Route::delete('/delete/social/{id}', [SocialNetworkController::class, 'destroy']);
        //Rutas para información de la empresa
        Route::post('tenant-info/store', [TenantInfoController::class, 'store']);
        Route::put('/tenant-info/update/{id}', [TenantInfoController::class, 'update']);
        Route::get('/tenant-info', [TenantInfoController::class, 'index']);
        Route::delete('/delete/tenant-info/{id}', [TenantInfoController::class, 'destroy']);
        //Rutas para información de las redes sociales de la empresa
        Route::post('tenant-social/store', [TenantSocialNetworkController::class, 'store']);
        Route::put('/tenant-social/update/{id}', [TenantSocialNetworkController::class, 'update']);
        Route::delete('/delete/tenant-social/{id}', [TenantSocialNetworkController::class, 'destroy']);
        //Rutas para carousel de la empresa
        Route::post('tenant-carousel/store', [TenantCarouselController::class, 'store']);
        Route::put('/tenant-carousel/update/{id}', [TenantCarouselController::class, 'update']);
        Route::delete('/delete/tenant-carousel/{id}', [TenantCarouselController::class, 'destroy']);

    });

    //images Tenant
    Route::get('/file/{path}',function($path){
        return response()->file(storage_path());
    })->where('path','.*')->name('file');
    //images tenant
});
