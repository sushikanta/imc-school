<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        View::composer([
            'layouts.frontend',
        ], 'App\Http\ViewComposers\FrontendLayoutComposer');

        /*View::composer([
            'emails.admin_contactus',
        ], 'App\Http\ViewComposers\MailComposer');*/
    }
}
