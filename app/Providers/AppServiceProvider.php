<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        // $theses = \App\Models\Thesis::all();
        // dd($theses->subjects());
        // // foreach($theses as $thesis){
        // //     foreach($thesis->subjects as $subject){
        // //         dd($subject->pivot);
        // //     }
        // }
    }
}
