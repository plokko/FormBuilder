<?php
namespace plokko\FormBuilder\fields;

class InputField extends FormField
{

    function render()
    {
        $form=\App::make('form');
        $t=$this->type;
        $v=$this->getValue();
        ///
        switch($t){
            default:$t='text';
            case 'hidden':
            case 'textarea':
            case 'number':
            case 'text':
            case 'email':
                return $form->{$t}($this->name,$v,$this->options);
            /*
            case 'radio':
            case 'checkbox':
                $checked=false;
                return $form->checkbox($this->name,$v,$checked,$this->options);*/
            case 'password':
                return $form->{$t}($this->name,$this->options);

        }
    }
}