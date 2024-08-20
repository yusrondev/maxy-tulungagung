<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        @$cms = DB::table('cms')->orderBy('id', 'DESC')->first();

        @$chatContents = DB::table('chat_contents')->first();

        View::share('cms', @$cms);
        View::share('chat_contents', @$chatContents);
    }
}
