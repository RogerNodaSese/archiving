<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\College\CollegeController;
use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\ThesisImportController;
use App\Http\Controllers\ThesisExportController;
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

Route::get('/all', function(){
    return \App\Models\Thesis::with(['subjects', 'authors'])->simplePaginate(20);
});
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
                ->middleware(['auth'])->name('verification.verify');

Route::get('/resend-verification', function(){
    return view('auth.resend-verification');
})->middleware(['throttle:verification','guest'])->name('resend');


Route::group(['middleware' => ['auth','verified']], function(){

    Route::group(['middleware' => 'role:admin', 'prefix' => 'archives', 'as' => 'archives.'], function(){
        Route::get('/import', [ThesisImportController::class, 'index'])->name('import');
        Route::post('/import', [ThesisImportController::class, 'store'])->name('store');
        Route::get('/export', [ThesisExportController::class, 'export'])->name('export');
    });

    //Routes for Student
    Route::group(['middleware' => 'role:student,admin', 'prefix' => 'archives', 'as' => 'student.'], function(){
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
            })->simplePaginate(20);
            return view('student.subject-archives', compact('theses','slug'));
        })->name('subject');
        Route::get('/title', function(){
            return view('student.title');
        })->name('title');
        Route::get('/{slug}', [CollegeController::class, 'collegeArchives'])->name('college');
        Route::get('/{slug}/{program}',[CollegeController::class, 'programArchive'])->name('program');
        Route::get('/{slug}/{program}/{archive}', function($slug,$program,$archive){
            $thesis = \App\Models\Thesis::with(['authors','subjects','file'])->findOrFail($archive);
            $college = \App\Models\College::where('slug',$slug)->firstOrFail();
            $program = \App\Models\Program::where('slug',$program)->firstOrFail();
            $date = \Carbon\Carbon::createFromFormat('Y-m', $thesis->date_of_publication)->format('F Y');
            // $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $thesis->date_of_issue );
            // $date = [
            //     'month' => $dateFormatted->format('F'),
            //     'day' => $dateFormatted->format('d'),
            //     'year' => $dateFormatted->format('Y'),
            // ];
            return view('student.archive',compact('college','program','thesis'))->with('date',$date);
        })->name('archive');
    });
    //Routes for Admin
    Route::group(['middleware' => 'role:admin', 'prefix' => 'college', 'as' => 'college.'], function(){
        Route::get('/', [CollegeController::class , 'index'])->name('index');
    });

    Route::group(['middleware' => 'role:admin', 'as' => 'college.'], function(){
        Route::get('/request', function(){
            $theses = \App\Models\Thesis::whereRelation('program', 'college_id', auth()->user()->college_id)->withTrashed()->get();
            return view('college.requests', compact('theses'));
        })->name('requests');
        Route::get('/request/view/{id}', function($id){
            $thesis = \App\Models\Thesis::whereRelation('program', 'college_id', auth()->user()->college_id)->with(['program' => function($query){
                $query->with(['college' => function($query) {
                    $query->select('id','description');
                }]);
            },'authors','subjectsWithTrashed','keywordsWithTrashed'])->withTrashed()->findOrFail($id);
            // $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $thesis->date_of_issue );
            // $date = [
            //     'month' => $dateFormatted->format('F'),
            //     'day' => $dateFormatted->format('d'),
            //     'year' => $dateFormatted->format('Y'),
            // ];
            $file_size = \Illuminate\Support\Facades\Storage::disk('google')->size($thesis->file->path);
            $kb = round($file_size / 1024);

            return view('college.view', compact('thesis'))->with('kb', $kb);
        })->name('requests.view');

        Route::put('/request/submit/{id}', function($id){
            $thesis = \App\Models\Thesis::whereRelation('program', 'college_id', auth()->user()->college_id)->with(['subjectsWithTrashed','keywordsWithTrashed'])->withTrashed()->findOrFail($id);
            // $subjects = \App\Models\SubjectThesis::where('thesis_id', $thesis->id)->get();
            // $keywords = \App\Models\KeywordThesis::where('thesis_id', $thesis->id)->get();
            $thesis->restore();
            foreach($thesis->subjectsWithTrashed as $subject){
                $thesis->subjects()->updateExistingPivot($subject, ['deleted_at' => NULL]);
            }

            foreach($thesis->keywordsWithTrashed as $keyword){
                $thesis->keywords()->updateExistingPivot($keyword->id, ['deleted_at' => NULL]);
            }
        
            return redirect('/request')->with('submitted', 'Submitted successfully!');
        })->name('requests.submit');
    });
    //Routes for Super-admin
    Route::group(['middleware' => 'role:admin', 'prefix' => 'library', 'as' => 'library.'], function(){
        Route::get('/', [LibraryController::class , 'index'])->name('index');
    });

    Route::group(['middleware' => 'role:admin', 'as' => 'library.'], function(){
        // Route::get('/user', [LibraryController::class, 'userList'])->name('users');
        // Route::get('/user/create', [LibraryController::class, 'userCreate'])->name('users.create');
        Route::get('/college/create', function(){
            return view('library.form.college');
        })->name('college.create');
        // Route::get('/archive-requests', function(){
        //     $theses = \App\Models\Thesis::with(['program' => function($query){
        //         $query->with('college');
        //     }, 'authors'])->get();
        
        //     return view('library.thesis-verification', compact('theses'));
        // })->name('requests');
        //ADDED
        // Route::get('/archive-request/view/{slug}', function($slug){
        //     $thesis = \App\Models\Thesis::with(['program' => function($query){
        //         $query->with(['college' => function($query) {
        //             $query->select('id','description');
        //         }]);
        //     },'authors','subjects','keywords'])->findOrFail($slug);
        //     $file_size = \Illuminate\Support\Facades\Storage::disk('google')->size($thesis->file->path);
        //     $kb = round($file_size / 1024);
        //     // $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', $thesis->date_of_publication );
        //     // $date = [
        //     //     'month' => $dateFormatted->format('F'),
        //     //     'day' => $dateFormatted->format('d'),
        //     //     'year' => $dateFormatted->format('Y'),
        //     // ];
        //     return view('library.thesis-overview', compact('thesis','date'))->with('kb',$kb);
        // })->name('request.view');
        // Route::post('/archive-requests/{id}', function($id){
        //     $thesis = \App\Models\Thesis::find($id);
        //     $thesis->verified = true;
        //     $thesis->save();
        //     return redirect('archive-requests')->with('verified', 'Request has been verified');
        // })->name('requests.create');
    });
    //Route for Super-admin and Admin
    Route::group(['middleware' => 'role:admin'], function(){
        Route::delete('archive-request/{id}', function($id){
            $thesis = \App\Models\Thesis::with('file')->withTrashed()->find($id);
            if(auth()->user()->role_id == \App\Models\Role::ADMIN){
                
                $thesis->delete();
                return redirect('/archive-requests')->with('deleted', 'Request deleted!');
            }
            if(auth()->user()->role_id == \App\Models\Role::ADMIN){
                
                $thesis->forceDelete();
                \Illuminate\Support\Facades\Storage::disk('google')->delete($thesis->file->path);
                return redirect('/request')->with('deleted', 'Request deleted!');
            }
             
        })->name('requests.delete');
        Route::get('/file/{id}/', function($id){
            $thesis = \App\Models\Thesis::with('file','program')->findOrFail($id);
            if(auth()->user()->isAdministrator())
            {
                $path = $thesis->file->path;

                if(!\Illuminate\Support\Facades\Storage::disk('google')->exists($path)){
                   abort(404);
                }

                return Response::make(file_get_contents(\Illuminate\Support\Facades\Storage::disk('google')->url($path)), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$thesis->file->description.'"'
                ]);
            }else
            {
                abort(403);
            }

            
        })->name('file');
        Route::get('/thesis/create', function(){
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