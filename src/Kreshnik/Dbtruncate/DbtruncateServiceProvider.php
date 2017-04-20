<?php namespace Kreshnik\Dbtruncate;

use Illuminate\Support\ServiceProvider;

class DbtruncateServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['db.truncate'] = $this->app->singleton(DatabaseTruncateCommand::class, function ( $app ) {
            return new DatabaseTruncateCommand($app['db']);
        });

        $this->commands([
            DatabaseTruncateCommand::class
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}