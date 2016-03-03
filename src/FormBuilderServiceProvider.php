<?php
namespace plokko\FormBuilder;
use Illuminate\Support\ServiceProvider;
use plokko\FormBuilder\FormBuilderProvider;
class FormBuilderServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        // Publish default config //
        $this->publishes([
            __DIR__.'/config/default.php' => config_path('FormBuilder.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/views/formbuilder', 'formbuilder');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/default.php','FormBuilder');
        $this->app->singleton('FormBuilderProvider',function ($app){
            return new FormBuilderProvider(config('FormBuilder'));//config('page.config')
        });
    }

    public function provides()
    {
        return ['FormBuilderProvider'];
    }
//*/
}