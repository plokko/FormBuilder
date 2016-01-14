<?php
namespace plokko\FormBuilder\Facades;
use Illuminate\Support\Facades\Facade;

class FormBuilder extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'FormBuilder';
    }
}