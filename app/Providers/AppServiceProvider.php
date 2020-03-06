<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /*Blade::directive('hello', function ($name) {
            return "<?php echo 'Hello '.{$name}; ?>";
        });*/

        Blade::directive('switch', function ($condition) {
            return "<?php switch({$condition}){ ";
        });
        Blade::directive('firstcase', function ($value) {
            return "case {$value}:  ?>";
        });
        Blade::directive('endswitch', function () {
            return "<?php }  ?>";
        });
        Blade::directive('case', function ($value) {
            return "<?php  case {$value}:  ?>";
        });
        Blade::directive('breakcase', function () {
            return "<?php break; ?>";
        });
        Blade::directive('whatever', function () {
            return "<?php default : ?>";
        });

        /*Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });*/
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
