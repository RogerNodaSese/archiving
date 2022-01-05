<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\College\CollegeController;
use App\Http\Controllers\Library\LibraryController;
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

Route::get('/', [LoginController::class, 'index'])->middleware('guest');
Route::post('/', LoginController::class)->name('login');

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', RegisterController::class)->name('register');

Route::post('/logout', LogoutController::class)->name('logout');

//Email verification
Route::get('/email/verify', [RegisterController::class, 'verify'])
                ->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', [RegisterController::class, 'verificationNotification'])
                ->middleware(['auth','throttle:verification'])->name('verification.send');

Route::post('/email/resend-email-verification', [RegisterController::class, 'resendEmailVerification'])
                ->middleware(['throttle:verification'])->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'emailVerification'])
                ->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/resend-verification', function(){
    return view('auth.resend-verification');
})->middleware(['throttle:verification','guest']);


Route::group(['middleware' => ['auth','verified']], function(){
    //Routes for Student
    Route::group(['middleware' => 'role:student,admin,superadmin', 'prefix' => 'archives', 'as' => 'student.'], function(){
        Route::get('/', [StudentController::class , 'index'])->name('index');
        Route::get('/colleges', function(){
            return view('library.colleges');
        })->name('colleges');
        Route::get('/keyword', function(){
            return view('student.keyword');
        })->name('keywords');
        Route::get('/keyword/{slug}', [CollegeController::class, 'keywordArchive'])->name('keyword');
        Route::get('/programs', function(){
            return view('library.programs');
        })->name('programs');
        Route::get('/subject', function(){
            return view('student.subject');
        })->name('subjects');
        Route::get('subject/{slug}', function($slug){
            $theses = \App\Models\Thesis::with(['authors' => function($query){
                $query->select('id','last_name','first_name');
            },'program' => function($query){
                $query->with('college');
            }])->whereHas('subjects',function(\Illuminate\Database\Eloquent\Builder $query) use ($slug){
                $query->where('description', $slug);
            })->where('verified', true)->paginate(20);
            return view('student.subject-archives', compact('theses','slug'));
        })->name('subject');
        Route::get('/title', function(){
            return view('student.title');
        })->name('title');
        Route::get('/{slug}', [CollegeController::class, 'collegeArchives'])->name('college');
        Route::get('/{slug}/{program}',[CollegeController::class, 'programArchive'])->name('program');
        Route::get('/{slug}/{program}/{archive}', function($slug,$program,$archive){
            $thesis = \App\Models\Thesis::with(['authors','keywords','subjects'])->where('verified',true)->findOrFail($archive);
            $college = \App\Models\College::where('slug',$slug)->firstOrFail();
            $program = \App\Models\Program::where('slug',$program)->firstOrFail();
            $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $thesis->date_of_issue );
            $date = [
                'month' => $dateFormatted->format('F'),
                'day' => $dateFormatted->format('d'),
                'year' => $dateFormatted->format('Y'),
            ];
            return view('student.archive',compact('college','program','thesis','date'));
        })->name('archive');
    });
    //Routes for Admin
    Route::group(['middleware' => 'role:admin', 'prefix' => 'college', 'as' => 'college.'], function(){
        Route::get('/', [CollegeController::class , 'index'])->name('index');
    });
    //Routes for Super-admin
    Route::group(['middleware' => 'role:superadmin', 'prefix' => 'library', 'as' => 'library.'], function(){
        Route::get('/', [LibraryController::class , 'index'])->name('index');
    });

    Route::group(['middleware' => 'role:superadmin', 'as' => 'library.'], function(){
        Route::get('/users', [LibraryController::class, 'userList'])->name('users');
        Route::get('/college/create', function(){
            return view('library.form.college');
        })->name('college.create');
        Route::get('/archive-requests', function(){
            $theses = \App\Models\Thesis::with(['program' => function($query){
                $query->with('college');
            }])->where('verified', false)->get();
        
            return view('library.thesis-verification', compact('theses'));
        })->name('requests');
        //ADDED
        Route::get('/archive-request/view/{slug}', function($slug){
            $thesis = \App\Models\Thesis::with(['program' => function($query){
                $query->with(['college' => function($query) {
                    $query->select('id','description');
                }]);
            },'authors','subjects','keywords'])->findOrFail($slug);
            $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $thesis->date_of_issue );
            $date = [
                'month' => $dateFormatted->format('F'),
                'day' => $dateFormatted->format('d'),
                'year' => $dateFormatted->format('Y'),
            ];
            return view('library.thesis-overview', compact('thesis','date'));
        })->name('request.view');
        Route::post('/archive-requests/{id}', function($id){
            $thesis = \App\Models\Thesis::find($id);
            $thesis->verified = true;
            $thesis->save();
            return back()->with('message', 'Thesis verified');
        })->name('requests.create');

        Route::delete('archive-request/{id}', function($id){
            $thesis = \App\Models\Thesis::find($id);
            $thesis->delete();
            return back()->with('deleted', 'Request declined!'); 
        })->name('requests.delete');
    });
    //Route for Super-admin and Admin
    Route::group(['middleware' => 'role:superadmin,admin'], function(){
        Route::get('thesis/create', function(){
            return view('library.form.thesis');
        })->name('thesis.create');
        Route::get('/program/create', function(){
            return view('library.form.program');
        })->name('program.create');
    });
});


// Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

// Route::get('/test4/{id}', function($id){
//     $thesis = \App\Models\Thesis::with(['program' => function($query){
//         $query->with(['college' => function($query) {
//             $query->select('id','description');
//         }]);
//     },'authors','subjects','keywords'])->findOrFail($id);
//     $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $thesis->date_of_issue );
//     $date = [
//         'month' => $dateFormatted->format('F'),
//         'day' => $dateFormatted->format('d'),
//         'year' => $dateFormatted->format('Y'),
//     ];
//     return view('student.archive',compact('thesis','date'));
// })->name('test4');

// Route::get('/library/dashboard', function(){
//     return view('super-admin.dashboard');
// });

// Route::group(['middleware' => ['auth','verified']], function(){
//     Route::get('/dashboard', function(){
//         dd('auth');
//     });
// });


//Create migration

//Authorization