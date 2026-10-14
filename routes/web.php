<?php

use App\Http\Controllers\Admin\AboutProfileController as AdminAboutProfileController;
use App\Http\Controllers\Admin\AdmissionsController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SchoolFeeController as AdminSchoolFeeController;
use App\Http\Controllers\Admin\SensitiveDocumentController as AdminSensitiveDocumentController;
use App\Http\Controllers\Admin\SensitiveSectionController as AdminSensitiveSectionController;
use App\Http\Controllers\Admin\ProgrammeEntryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\UpdatesController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrimaryApplicationController;
use App\Http\Controllers\PrefectController;
use App\Http\Controllers\SchoolProgrammeController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StaffController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/favicon.ico', fn () => redirect('/favicon.jpeg', 301));
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');
Route::get('/admissions/online-application', [PrimaryApplicationController::class, 'create'])->name('applications.primary.create');
Route::post('/admissions/online-application', [PrimaryApplicationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('applications.primary.store');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/school-programme', [SchoolProgrammeController::class, 'index'])->name('school-programme');
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/prefects', [PrefectController::class, 'index'])->name('prefects.index');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/academics/school-fees', [AcademicsController::class, 'schoolFees'])->name('academics.school-fees');
Route::get('/academics/sensitive-information', [AcademicsController::class, 'sensitiveInformation'])->name('academics.sensitive-information');
Route::get('/academics/sensitive-information/download/{document}', [AcademicsController::class, 'downloadSensitiveDocument'])->name('academics.sensitive-information.download');
Route::get('/academics', [PageController::class, 'section'])->defaults('section', 'academics')->name('academics');
Route::get('/students', [PageController::class, 'section'])->defaults('section', 'students')->name('students');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

Route::prefix('admin')->name('admin.')->middleware('admin.secure')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');
        Route::post('forgot-password', [ForgotPasswordController::class, 'submitEmail'])->name('password.email');
        Route::get('master-reset-password', [ForgotPasswordController::class, 'showMasterForm'])->name('password.master');
        Route::post('master-reset-password', [ForgotPasswordController::class, 'verifyMaster'])->name('password.master.submit');
        Route::get('reset-password', [ForgotPasswordController::class, 'showNewPasswordForm'])->name('password.reset');
        Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset.store');
        Route::redirect('verify-reset-code', '/admin/forgot-password');
    });

    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware(['auth', 'admin.force-password'])->group(function () {
        Route::get('change-password', [ChangePasswordController::class, 'showForm'])->name('password.change');
        Route::put('change-password', [ChangePasswordController::class, 'update'])->name('password.update');
    });

    Route::middleware([AdminMiddleware::class, 'admin.force-password'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('help', [HelpController::class, 'index'])->name('help');
        Route::get('notifications/unread-counts', [NotificationController::class, 'unreadCounts'])->name('notifications.unread');
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::put('settings/account', [SettingController::class, 'updateAccount'])->name('settings.account.update');

        Route::resource('posts', AdminPostController::class)->except(['show']);
        Route::resource('events', AdminEventController::class)->except(['show']);
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::resource('staff', AdminStaffController::class)->except(['show']);
        Route::resource('about-profiles', AdminAboutProfileController::class)->except(['show']);
        Route::resource('school-fees', AdminSchoolFeeController::class)->except(['show']);
        Route::resource('sensitive-sections', AdminSensitiveSectionController::class)->except(['show']);
        Route::resource('sensitive-documents', AdminSensitiveDocumentController::class)->except(['show']);
        Route::resource('gallery', AdminGalleryController::class)->except(['show']);

        Route::get('updates', [UpdatesController::class, 'index'])->name('updates.index');
        Route::get('updates/news', [AdminPostController::class, 'index'])->name('updates.news.index');
        Route::get('updates/events', [AdminEventController::class, 'index'])->name('updates.events.index');
        Route::get('updates/gallery', [AdminGalleryController::class, 'index'])->name('updates.gallery.index');
        Route::get('updates/programme', [ProgrammeEntryController::class, 'index'])->name('updates.programme.index');
        Route::get('updates/programme/create', [ProgrammeEntryController::class, 'create'])->name('updates.programme.create');
        Route::post('updates/programme', [ProgrammeEntryController::class, 'store'])->name('updates.programme.store');
        Route::get('updates/programme/{programmeEntry}/edit', [ProgrammeEntryController::class, 'edit'])->name('updates.programme.edit');
        Route::put('updates/programme/{programmeEntry}', [ProgrammeEntryController::class, 'update'])->name('updates.programme.update');
        Route::delete('updates/programme/{programmeEntry}', [ProgrammeEntryController::class, 'destroy'])->name('updates.programme.destroy');

        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('admissions', [AdmissionsController::class, 'index'])->name('admissions.index');
        Route::get('admissions/primary', [AdmissionsController::class, 'primary'])->name('admissions.primary.index');
        Route::get('admissions/primary/{primaryApplication}', [AdmissionsController::class, 'showPrimary'])->name('admissions.primary.show');
    });
});
