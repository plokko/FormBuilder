<?php
namespace plokko\FormBuilder\fields;

use App;
use plokko\FormBuilder\HiddenLabel;

class InputField extends FormField
{

    function render()
    {
        $form= App::make('form');
        $t=$this->type;
        $v=$this->getValue();
        ///
        switch($t){
            default:$t='text';
            //HTML5 input types//
            case 'date':
            case 'datetime':
            case 'datetime-local':
            case 'email':
            case 'month':
            case 'number':
            case 'range':
            case 'search':
            case 'tel':
            case 'time':
            case 'url':
            case 'week':
            //
            case 'hidden':
            case 'textarea':
            case 'text':
                return $form->{$t}($this->name,$v,$this->attributes);
            /*
            case 'radio':
            case 'checkbox':
                $checked=false;
                return $form->checkbox($this->name,$v,$checked,$this->options);
            */
            case 'password':
                return $form->{$t}($this->name,$this->attributes);

        }
    }


    function pattern($pattern)
    {
        return $this->attribute('pattern',$pattern);
    }

    function min($n=null)
    {
        $tag=in_array($this->type,['number','range','date','datetime','datetime-local','month','time','week'])?'min':'minlength';
        return $this->attribute($tag,$n);
    }

    function max($n=null)
    {
        $tag=in_array($this->type,['number','range','date','datetime','datetime-local','month','time','week'])?'max':'maxlength';
        return $this->attribute($tag,$n);
    }

    function __get($k)
    {
        $v=parent::__get($k);
        // Don't display any label for hidden fields //
        if($k=='label' && $this->type=='hidden')
            return $v->hidden();

        return $v;
    }
}