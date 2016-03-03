<?php
namespace plokko\FormBuilder;

use League\Flysystem\Exception;
use plokko\FormBuilder\fields\FormField;

class FormBuilderProvider
{
    protected
        $view='formbuilder.bootstrap.form.base',
        $fieldProviders=[];

    function __construct($cfg=[])
    {
        foreach(['view','fieldProviders']AS $k)
            if(isset($cfg[$k]))
                $this->{$k}=$cfg[$k];
    }


    public function make($opt=[])
    {
        return (new FormBuilder($opt))->view($this->view);
    }

    public function field(FormBuilder &$form,$name,$type)
    {
        if(array_key_exists($type,$this->fieldProviders))
        {
            $class=$this->fieldProviders[$type];
            return new $class($form,$name,$type);
        }else{
            return new FormField($form,$name,$type);
        }
    }
}