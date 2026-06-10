<?php

namespace App\Providers;

use Illuminate\{
    Support\ServiceProvider,
    Support\Facades\DB,
    Support\Facades\Schema,
};
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Fix for older MySQL versions (key length issue)
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        view()->composer("*", function ($settings) {
            // use Eloquent models instead of raw query so newly added attributes
            // are loaded automatically and we get Setting instances rather than
            // stdClass. helps avoid undefined property errors when columns are
            // added via migrations.
            $settings->with("setting", \App\Models\Setting::first());
            $settings->with(
                "extra_settings",
                \App\Models\ExtraSetting::first(),
            );
            $settings->with("menus", \App\Models\Menu::first());
            $settings->with(
                "socials",
                \App\Models\Social::orderBy("id", "asc")->get(),
            );

            if (!session()->has("popup")) {
                view()->share("visit", 1);
            }

            session()->put("popup", 1);
        });
    }

    public function register()
    {
        $helpersPath = app_path("Helpers/helpers.php");
        if (file_exists($helpersPath)) {
            require_once $helpersPath;
        }
    }
}
