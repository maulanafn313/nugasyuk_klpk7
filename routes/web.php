<?php


use App\Models\Cms;
use App\Models\Faq;
use App\Models\User;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Models\HomepageContent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CreateScheduleController;
use App\Http\Controllers\HistoryScheduleController;
use App\Http\Controllers\CategoryScheduleController;
use App\Http\Controllers\Admin\HomepageContentController;
use App\Http\Controllers\Google\GoogleCalendarController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

//route untuk admin
Route::middleware(['auth', 'adminMiddleware'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('userManagement', AdminUserController::class)->names('admin.userManagement');
    Route::resource('homepage-contents', HomepageContentController::class)->names('admin.homepage-contents');
    Route::resource('facilities', FacilityController::class)->names('admin.facilities');
    Route::resource('category', CategoryScheduleController::class)->names('admin.category');
    Route::resource('faqs', FaqController::class)->names('admin.faqs');
    Route::resource('cms', CmsController::class)
        ->names('admin.cms')
        ->parameters(['cms' => 'cms']);
    Route::get('/students/status', [App\Http\Controllers\Admin\StudentStatusController::class, 'index'])
        ->name('admin.students.status');
    Route::put('/students/{id}/status', [App\Http\Controllers\Admin\StudentStatusController::class, 'updateStatus'])
        ->name('admin.students.update-status');
    Route::get('/admin/faqs', [FaqController::class, 'index'])->name('admin.faqs'); // Halaman admin untuk menjawab pertanyaan
    Route::post('/admin/faqs/{faq}', [FaqController::class, 'answer'])->name('admin.faqs.answer'); // Proses menjawab pertanyaan
});




// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//route untuk profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//route middleware untuk user
Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('view-schedule', [ScheduleController::class, 'index'])->name('user.view-schedule');
    Route::get('create-schedule', [CreateScheduleController::class, 'index'])->name('user.create-schedule');
    Route::post('store-schedule', [CreateScheduleController::class, 'store'])->name('user.store-schedule');
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    Route::patch('/schedule/{schedule}/complete', [ScheduleController::class, 'complete'])->name('schedule.complete');
    Route::get('/history-schedule', [HistoryScheduleController::class, 'index'])->name('user.history-schedule');
    Route::delete('/history-schedule/{schedule}', [HistoryScheduleController::class, 'destroy'])->name('history.destroy');
    Route::get('/faq-form', [FaqController::class, 'create'])->name('faq.form'); // Form pertanyaan user
    Route::post('/faq-form', [FaqController::class, 'store'])->name('faq.store'); // Simpan pertanyaan user

    Route::get('/user/search-email', function (Request $request) {
        $q = $request->get('q');
        $users = User::where('role', 'user') // hanya user dengan role 'user'
            ->where(function ($query) use ($q) {
                $query->where('email', 'like', "%$q%")
                    ->orWhere('name', 'like', "%$q%");
            })
            ->limit(5)
            ->get(['id', 'name', 'email']);
        return response()->json($users);
    });

    // Rute Google Calendar
    Route::get('/google/authorize', [GoogleCalendarController::class, 'authorize'])->name('google.authorize');
    Route::get('/google/callback', [GoogleCalendarController::class, 'callback'])->name('google.callback');
    Route::get('/google/calendar/events', [GoogleCalendarController::class, 'listEvents'])->name('google.calendar.events');
    Route::post('/google/events', [GoogleCalendarController::class, 'createEvent'])->name('google.events.create');
    Route::put('/google/events/{eventId}', [GoogleCalendarController::class, 'updateEvent'])->name('google.events.update');
    Route::delete('/google/events/{eventId}', [GoogleCalendarController::class, 'deleteEvent'])->name('google.events.delete');
});


//route middleware untuk admin
// Route::middleware(['auth', 'adminMiddleware'])->group(function () {
//     Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// });


Route::get('/', function () {
    $contents = HomepageContent::all();
    $faqs = Faq::all();
    $facilities = Facility::all();
    $cms = Cms::first();
    return view('homepage', compact('contents', 'faqs', 'facilities', 'cms'));
});


Route::resource('homepage-contents', HomepageContentController::class)
    ->middleware(['auth', 'adminMiddleware'])
    ->names('admin.homepage-contents');


// Route untuk halaman kalender
Route::get('/calendar', [App\Http\Controllers\ScheduleController::class, 'showCalendar'])->name('calendar');



require __DIR__ . '/auth.php';
