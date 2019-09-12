<?php

namespace PandoApps\Quiz;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables;

class QuizServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'pandoapps');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'pandoapps');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->app['router']->namespace('PandoApps\\Quiz\\Controllers')
                ->middleware(['web'])
                ->group(function () {
                    $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
                });


        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        
        View::share('parentName', config('quiz.models.parent_id'));
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/quiz.php', 'quiz');

        // Register the service the package provides.
        $this->app->singleton('quiz', function ($app) {
            return new Quiz(new DataTables);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['quiz'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the config.
        $this->publishes([
            __DIR__.'/../config/quiz.php' => config_path('quiz.php'),
        ], 'config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/pandoapps'),
        ], 'views');

        // Publishing the assets.
        $this->publishes([
            __DIR__.'/public/' => public_path('vendor/pandoapps'),
        ], 'public');

        // Publishing the migrations.
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Publishing the seeder.
        $this->publishes([
            __DIR__ . '/../database/seeds/' => database_path('seeds'),
        ], 'seeds');

        // Publishing the translations.
        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/vendor/pandoapps'),
        ], 'lang');


        // Registering package commands.
        // $this->commands([]);
    }
}
