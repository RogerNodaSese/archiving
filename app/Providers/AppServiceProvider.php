<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Str;

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
        if($this->app->environment('production'))
        {
            \URL::forceScheme('https');
        }

        HeadingRowFormatter::extend('custom', function($value, $key) {
            return Str::slug(explode(' ',$value)[0], '-');
        });

        HeadingRowFormatter::default('custom');
        
    }
}
