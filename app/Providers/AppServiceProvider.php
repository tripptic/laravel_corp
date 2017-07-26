<?php

namespace Corp\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);

        //#set($i,10)
        \Blade::directive('set', function($exp) {
            list($name, $val) = explode(',', $exp);
            return "<?php $name = $val; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
