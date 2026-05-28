<?php

namespace App\Providers;

use App\Support\Registry;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Registry $registry): void
    {
        View::composer('components.layouts.app', function ($view) use ($registry): void {
            if (! array_key_exists('blocks', $view->getData())) {
                $view->with('blocks', $registry->blocksByCategory());
            }
        });
    }
}
