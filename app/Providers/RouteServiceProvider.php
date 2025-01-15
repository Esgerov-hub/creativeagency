<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';
    protected const adminNamespace = 'App\Http\Controllers\Admin';
    protected const siteNamespace = 'App\Http\Controllers\Site';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function map(Request $request)
    {

//        $this->mapApiRoutes();
        $this->mapSiteRoutes();
        $this->mapAdminRoutes();
    }

    public function boot()
    {
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function mapAdminRoutes(){
        $this->configureRateLimiting();
        Route::namespace(self::adminNamespace)->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    protected function mapApiRoutes(){
        Route::middleware(['web'])->namespace('App\Http\Controllers')
            ->group(base_path('routes/web.php'));
    }

    protected function mapSiteRoutes(){
        Route::namespace(self::siteNamespace)
            ->name('site.')
            ->group(base_path('routes/site.php'));
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()->id ?: $request->ip());
        });
    }
}
