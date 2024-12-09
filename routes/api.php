<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\EnsureUser;
use App\Http\Middleware\EnsureProducer;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProducerController;
use App\Http\Controllers\CartProductController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentMethodController;



Route::post('/users', [UserController::class, 'store']);
Route::post('/producers', [ProducerController::class, 'store']);


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // Listar productos
    Route::get('/{product}', [ProductController::class, 'show']); // Detalle de producto
});


Route::post('/v1/login', [App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('api.login');
Route::middleware(['auth:sanctum'])->post('/v1/logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('api.logout');


Route::middleware(['auth:sanctum', EnsureUser::class])->group(function () {
    // Suscripciones: suscribirse a una caja mensual
    Route::prefix('subscriptions')->group(function () {
        Route::post('/', [SubscriptionController::class, 'store']);
        Route::delete('/{subscription}', [SubscriptionController::class, 'destroy']);
        Route::delete('/{subscription}', [SubscriptionController::class, 'destroy']);
    });

    // Reseñas: dejar una reseña de un producto
    Route::prefix('reviews')->group(function () {
        Route::post('/', [ReviewController::class, 'store']);
        Route::put('/{review}', [ReviewController::class, 'update']);
        Route::delete('/{review}', [ReviewController::class, 'destroy']);
    });

    // Usuarios: actualizar información propia
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    // Carrito: agregar productos al carrito
    Route::prefix('carts')->group(function () {
        Route::post('/', [CartController::class, 'store']);
        Route::post('/{cart}/products/{product}', [CartProductController::class, 'store']); //crear los productos d eun carrito
        Route::delete('/{cart}/products/{product}', [CartProductController::class, 'destroy']); //eliminar el producto de un carrito
        Route::get('/{cart}/products/', [CartProductController::class, 'index']); //mostrar todos los productos d eun carrito
        Route::delete('/{cart}', [CartController::class, 'destroy']);
    });

    // Método de pago: agregar métodos de pago
    Route::post('/users/payments-methods', [PaymentMethodController::class, 'store']);
    Route::put('/users/payments-methods/{paymentMethod}', [PaymentMethodController::class, 'update']);
    Route::delete('/users/payments-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy']);
    Route::get('/users/payments-methods', [PaymentMethodController::class, 'index']);
});


// Rutas protegidas para productores
Route::middleware(['auth:sanctum', EnsureProducer::class])->group(function () {
    // Productos: eliminar un producto
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);


    Route::post('/payments-methods', [PaymentMethodController::class, 'store']);
    Route::put('/payments-methods/{paymentMethod}', [PaymentMethodController::class, 'update']);
    Route::delete('/payments-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy']);


    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);
   
    Route::delete('/producers/{producer}', [UserController::class, 'destroy']);
});



