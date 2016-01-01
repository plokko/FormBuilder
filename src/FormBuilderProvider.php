<?php
namespace plokko\FormBuilder;

use Illuminate\Support\ServiceProvider;

class FormBuilderProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->mergeConfigFrom(__DIR__.'/config/default-config.php','PageHelper');

        $this->app->bind('FormBuilder',function ($app){
            return new FormBuilder();//$app['config']['FormBuilder']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'FormBuilder'
        ];
    }
}
