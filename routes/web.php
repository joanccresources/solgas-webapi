<?php

use App\Http\Controllers\API\v1\Helpers\CmsController;
use App\Http\Controllers\WEB\v1\LayoutController;
use App\Http\Controllers\WEB\v1\PageController;
use App\Http\Controllers\WEB\v1\PostController;
use Illuminate\Support\Facades\Route;
// SQL SERVER
use App\Http\Controllers\WEB\v1\Seal\SealVerificationController;
use App\Http\Controllers\WEB\v1\Client\ClientRegistrationController;

Route::middleware(['throttle:web'])->group(function () {
    Route::prefix('page')->group(function () {
        Route::get('{page:slug}', [PageController::class, 'getPageContent']);
    });

    Route::prefix('blog')->group(function () {
        Route::prefix('post')->group(function () {
            Route::get('', [PageController::class, 'getPosts']);
            Route::get('{post:slug}', [PageController::class, 'getPost'])->name('web.blog.post.slug');
        });

        Route::middleware(['throttle:webBlogAction'])->prefix('action')->group(function () {
            Route::get('like/{post:slug}', [PageController::class, 'likePost']);
            Route::get('dislike/{post:slug}', [PageController::class, 'dislikePost']);
            Route::get('shared/{post:slug}', [PageController::class, 'sharedPost']);
        });

        Route::middleware(['throttle:webBlogComment'])->group(function () {
            Route::post('save-comment-post/{post:slug}', [PageController::class, 'saveCommentPost']);
            Route::post('reply-comment-post/{post:slug}/{comment}', [PageController::class, 'replyCommentPost']);
        });
    });

    Route::prefix('sitemap')->group(function () {
        Route::get('posts', [PageController::class, 'getSitemapPosts']);
        Route::get('pages', [PageController::class, 'getSitemapPages']);
    });

    Route::prefix('layout')->group(function () {
        Route::get('hierarchy', [LayoutController::class, 'showHierarchy']);
        Route::get('header', [LayoutController::class, 'getDataHeader']);
        Route::get('footer', [LayoutController::class, 'getDataFooter']);
    });

    Route::middleware(['throttle:webLead'])->prefix('post')->group(function () {
        Route::post('lead', [PostController::class, 'createLead']);
        Route::post('lead-work-with-us', [PostController::class, 'createLeadWorkWithUs']);
        Route::post('lead-service-station', [PostController::class, 'createLeadServiceStation']);
        Route::post('lead-distributor', [PostController::class, 'createLeadDistributor']);
    });

    Route::middleware(['throttle:cookieConsent'])->prefix('post')->group(function () {
        Route::post('cookie-consent', [PostController::class, 'createCookieConsent']);
    });

    Route::prefix('json')->group(function () {
        Route::get('departments', [CmsController::class, 'getDepartments']);
        Route::get('provinces/{department}', [CmsController::class, 'getProvinces']);
        Route::get('districts/{department}/{province}', [CmsController::class, 'getDistricts']);
        Route::get('get-categories', [CmsController::class, 'getParamsCategoriesCreatePost']);
        Route::get('get-reporte-de-sostenibilidad', [CmsController::class, 'getSustainabilityReport']);
        Route::get('get-map-distributor', [CmsController::class, 'getMapDistributor']);
        Route::get('get-map-service-station', [CmsController::class, 'getMapServiceStation']);
    });
});


// SQL SERVER
Route::post('seal/verify', SealVerificationController::class);
Route::post('clients/register', ClientRegistrationController::class);
Route::prefix('test')->group(function () {
    Route::get('/sqlsrv', function () {
        try {
            $registros = \App\Models\Seal::limit(15)->get();
            return response()
                ->json($registros)
                ->header("Cache-Control", "no-store")
                ->header("X-Content-Type-Options", "nosniff");
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
});
