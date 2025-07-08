<?php

use App\Http\Controllers\API\v1\Authentication\ForgotPasswordController;
use App\Http\Controllers\API\v1\Authentication\LoginController;
use App\Http\Controllers\API\v1\Authentication\ResetPasswordController;
use App\Http\Controllers\API\v1\Automation\AttributeController;
use App\Http\Controllers\API\v1\Blog\CategoryController;
use App\Http\Controllers\API\v1\Blog\CommentController;
use App\Http\Controllers\API\v1\Content\ContentPageController;
use App\Http\Controllers\API\v1\Content\ContentSeoController;
use App\Http\Controllers\API\v1\Content\ContentSocialNetworkController;
use App\Http\Controllers\API\v1\Helpers\CmsController;
use App\Http\Controllers\API\v1\Helpers\FileController;
use App\Http\Controllers\API\v1\Page\PageController;
use App\Http\Controllers\API\v1\Blog\PostController;
use App\Http\Controllers\API\v1\Blog\TagController;
use App\Http\Controllers\API\v1\Content\ContentFooterController;
use App\Http\Controllers\API\v1\Content\ContentFooterMenuController;
use App\Http\Controllers\API\v1\Content\ContentHeaderController;
use App\Http\Controllers\API\v1\Content\ContentHeaderMenuController;
use App\Http\Controllers\API\v1\Content\SustainabilityReportController;
use App\Http\Controllers\API\v1\Content\SustainabilityReportObjectController;
use App\Http\Controllers\API\v1\Dashboard\DashboardController;
use App\Http\Controllers\API\v1\Employment\EmploymentAreaController;
use App\Http\Controllers\API\v1\Employment\EmploymentController;
use App\Http\Controllers\API\v1\Employment\EmploymentTypeController;
use App\Http\Controllers\API\v1\Lead\LeadController;
use App\Http\Controllers\API\v1\Lead\LeadDistributorController;
use App\Http\Controllers\API\v1\Lead\LeadEmailDestinationController;
use App\Http\Controllers\API\v1\Lead\LeadServiceStationController;
use App\Http\Controllers\API\v1\Lead\LeadWorkWithUsController;
use App\Http\Controllers\API\v1\Map\MapDistributorController;
use App\Http\Controllers\API\v1\Map\MapServiceStationController;
use App\Http\Controllers\API\v1\Setting\Activity\ActivityController;
use App\Http\Controllers\API\v1\Setting\Backup\BackupController;
use App\Http\Controllers\API\v1\Setting\CookieConsent\CookieConsentController;
use App\Http\Controllers\API\v1\Setting\GeneralInformation\GeneralInformationController;
use App\Http\Controllers\API\v1\Setting\Permission\PermissionController;
use App\Http\Controllers\API\v1\Setting\Role\RoleController;
use App\Http\Controllers\API\v1\Setting\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->middleware('throttle:login');

Route::middleware(['throttle:settingPassword'])->group(function () {
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('reset-password', [ResetPasswordController::class, 'reset']);
});

Route::prefix('auth')->middleware(['auth:sanctum', 'throttle:auth'])->group(function () {
    #logout
    Route::post('logout', [LoginController::class, 'logout']);

    #dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('dashboard-filter-cards', [DashboardController::class, 'getDataFilterCards']);


    #Contenido Redes Sociales
    Route::apiResource('content-social-network', ContentSocialNetworkController::class);
    Route::post('content-social-network-order', [ContentSocialNetworkController::class, 'setOrder']);

    #Contenido Header
    Route::apiResource('content-header', ContentHeaderController::class);
    Route::post('content-header-order', [ContentHeaderController::class, 'setOrder']);

    #Contenido Header Menu
    Route::apiResource('content-header-menu', ContentHeaderMenuController::class)->except('index');
    Route::get('content-header-menu-list/{contentHeader}/{contentHeaderMenu?}', [ContentHeaderMenuController::class, 'index']);
    Route::post('content-header-menu-order', [ContentHeaderMenuController::class, 'setOrder']);

    #Contenido Footer
    Route::apiResource('content-footer', ContentFooterController::class);
    Route::post('content-footer-order', [ContentFooterController::class, 'setOrder']);

    #Contenido Footer Menu
    Route::apiResource('content-footer-menu', ContentFooterMenuController::class)->except('index');
    Route::get('content-footer-menu-list/{contentFooter}/{contentFooterMenu?}', [ContentFooterMenuController::class, 'index']);
    Route::post('content-footer-menu-order', [ContentFooterMenuController::class, 'setOrder']);

    #Contenido SEO
    Route::apiResource('content-seo', ContentSeoController::class)->only('index', 'update');

    #Contenido Contenido de los campos de una sección
    Route::get('content-page', [ContentPageController::class, 'index']);
    Route::get('content-page-section/{page}', [ContentPageController::class, 'indexPageSection']);
    Route::get('content-page-section-field/{pageSection}', [ContentPageController::class, 'indexPageSectionField']);
    Route::put('content-page-section-field/{pageSection}', [ContentPageController::class, 'updatePageSectionField']);

    Route::get('content-page-multiple-field-section/{pageSection}', [ContentPageController::class, 'indexPageMultipleFieldSection']);

    Route::get('content-page-multiple-field/{pageMultipleField}', [ContentPageController::class, 'indexPageMultipleField']);
    Route::get('content-page-multiple-field-format/{pageMultipleField}', [ContentPageController::class, 'showPageMultipleFieldFormat']);
    Route::post('content-page-multiple-content/{pageMultipleField}', [ContentPageController::class, 'storePageMultipleContent']);
    Route::get('content-page-multiple-content/{pageMultipleContent}', [ContentPageController::class, 'showPageMultipleContent']);
    Route::put('content-page-multiple-content/{pageMultipleContent}', [ContentPageController::class, 'updatePageMultipleContent']);
    Route::delete('content-page-multiple-content/{pageMultipleContent}', [ContentPageController::class, 'destroyPageMultipleContent']);
    Route::post('content-page-multiple-content-order/{pageMultipleField}', [ContentPageController::class, 'setOrder']);

    #Contenido Informe de sostenibilidad
    Route::apiResource('sustainability-report', SustainabilityReportController::class);
    Route::post('sustainability-report-order', [SustainabilityReportController::class, 'setOrder']);

    #Contenido Informe de sostenibilidad objetos
    Route::apiResource('sustainability-report-object', SustainabilityReportObjectController::class)->except('index');
    Route::get('sustainability-report-object-list/{sustainabilityReport}', [SustainabilityReportObjectController::class, 'index']);
    Route::post('sustainability-report-object-order', [SustainabilityReportObjectController::class, 'setOrder']);

    #Mapas
    Route::apiResource('map-distributor', MapDistributorController::class);
    Route::post('map-distributor-order', [MapDistributorController::class, 'setOrder']);

    Route::apiResource('map-service-station', MapServiceStationController::class);
    Route::post('map-service-station-order', [MapServiceStationController::class, 'setOrder']);

    #Leads leads
    Route::apiResource('lead', LeadController::class)->only('index', 'show', 'destroy');

    #Leads distribuidores
    Route::apiResource('lead-distributor', LeadDistributorController::class)->only('index', 'show', 'destroy');

    #Leads estación de servicios
    Route::apiResource('lead-service-station', LeadServiceStationController::class)->only('index', 'show', 'destroy');

    #Leads trabaja con nosotros
    Route::apiResource('lead-work-with-us', LeadWorkWithUsController::class)->only('index', 'show', 'destroy');

    #Leads emails de recepción
    Route::apiResource('lead-email-destination', LeadEmailDestinationController::class);


    #Empleos Empleos
    Route::apiResource('employment', EmploymentController::class);

    #Empleos Areas
    Route::apiResource('employment-area', EmploymentAreaController::class);

    #Empleos Tipos
    Route::apiResource('employment-type', EmploymentTypeController::class);


    #Noticias Categorías
    Route::apiResource('category', CategoryController::class);

    #Noticias Etiquetas
    Route::apiResource('tag', TagController::class);

    #Noticias Publicaciones
    Route::apiResource('post', PostController::class);
    Route::post('post-image', [PostController::class, 'uploadImage']);

    #Noticias Comentarios
    Route::get('post-comment-list/{post}', [CommentController::class, 'index']);
    Route::get('post-comment/{comment}', [CommentController::class, 'show']);
    Route::delete('post-comment/{comment}', [CommentController::class, 'destroy']);
    Route::put('post-comment-status/{comment}', [CommentController::class, 'statusComment']);



    #Configuración Activity
    Route::apiResource('activity', ActivityController::class)->only('index', 'show');

    #Configuración Atributos
    Route::apiResource('attribute', AttributeController::class);
    Route::post('attribute-order', [AttributeController::class, 'setOrder']);

    #Configuración Información general
    Route::apiResource('general-information', GeneralInformationController::class)->except('store', 'destroy');
    Route::put('general-information-recaptcha/{generalInformation}', [GeneralInformationController::class, 'updateRecaptcha']);
    Route::put('general-information-tag-manager/{generalInformation}', [GeneralInformationController::class, 'updateTagManager']);
    Route::put('general-information-token-map/{generalInformation}', [GeneralInformationController::class, 'updateTokenMap']);
    Route::put('general-information-cookie/{generalInformation}', [GeneralInformationController::class, 'updateCookie']);


    #Configuración Backup
    Route::get('backup', [BackupController::class, 'index']);
    Route::get('backup-download', [BackupController::class, 'downloadBackup']);

    #Configuración Páginas
    Route::apiResource('page', PageController::class);

    #Configuración Permisos
    Route::apiResource('permission', PermissionController::class);

    #Configuración Roles
    Route::apiResource('role', RoleController::class);

    #Configuración Cookie consent
    Route::apiResource('cookie-consent', CookieConsentController::class)->only('index', 'destroy');

    #Configuración User
    Route::apiResource('user', UserController::class);
    Route::get('admin-user', [UserController::class, 'user']);
    Route::put('profile-user-personal-information-update', [UserController::class, 'profileUserPersonalInformationUpdate']);
    Route::put('profile-user-password-update', [UserController::class, 'profileUserPasswordUpdate']);
    Route::put('profile-user-image-update', [UserController::class, 'profileImageUpdate']);

    #json
    Route::prefix('json')->group(function () {
        Route::get('get-params-create-user', [CmsController::class, 'getParamsCreateUser']);
        Route::get('get-params-create-roles', [CmsController::class, 'getPermissionCreateRole']);
        Route::get('get-params-create-modules', [CmsController::class, 'getParamsCreateModules']);
        Route::get('get-params-create-submodules', [CmsController::class, 'getParamsCreateSubmodules']);
        Route::get('get-params-create-permissions', [CmsController::class, 'getParamsCreatePermissions']);
        Route::get('get-params-create-attributes', [CmsController::class, 'getParamsCreateAttributes']);
        Route::get('get-params-create-fields', [CmsController::class, 'getParamsCreateField']);
        Route::get('get-params-create-multiple-field-sections', [CmsController::class, 'getParamsCreateMultipleFieldSection']);
        Route::get('get-params-create-content-social-network', [CmsController::class, 'getParamsCreateContentSocialNetwork']);
        Route::get('get-params-tags-create-post', [CmsController::class, 'getParamsTagsCreatePost']);
        Route::get('get-params-categories-create-post', [CmsController::class, 'getParamsCategoriesCreatePost']);
        Route::get('get-params-posts-create-post', [CmsController::class, 'getParamsPostsCreatePost']);
        Route::get('get-params-create-map', [CmsController::class, 'getParamsCreateMap']);

        Route::get('get-params-areas-create-employment', [CmsController::class, 'getParamsAreasCreateEmployment']);
        Route::get('get-params-types-create-employment', [CmsController::class, 'getParamsTypesCreateEmployment']);
        Route::get('get-params-employments-create-employment', [CmsController::class, 'getParamsEmploymentCreateEmployment']);
        Route::get('get-params-content-menu-type', [CmsController::class, 'getParamsMenuType']);
        Route::get('get-data-page/{page}', [CmsController::class, 'getDataPage']);
        Route::get('get-data-page-section/{pageSection}', [CmsController::class, 'getDataPageSection']);

        Route::get('departments', [CmsController::class, 'getDepartments']);
        Route::get('provinces/{department}', [CmsController::class, 'getProvinces']);
        Route::get('districts/{department}/{province}', [CmsController::class, 'getDistricts']);
    });

    #files
    Route::prefix('files')->group(function () {
        Route::get('get', [FileController::class, 'downloadFile']);
    });
});
