<?php
namespace plokko\FormBuilder\fields;

use plokko\FormBuilder\HiddenLabel;

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
                return $form->{$t}($this->name,$v,$this->attributes);
            /*
            case 'radio':
            case 'checkbox':
                $checked=false;
                return $form->checkbox($this->name,$v,$checked,$this->options);*/
            case 'password':
                return $form->{$t}($this->name,$this->attributes);

        }
    }

    function min($n=null)
    {
        $tag=in_array($this->type,['number','range','date','datetime','datetime-local','month','time','week'])?'min':'minlength';
        if($n!==null)
            $this->attributes[$tag]=$n;
        else
            unset($this->attributes[$tag]);
        return $this;
    }

    function max($n=null)
    {
        $tag=in_array($this->type,['number','range','date','datetime','datetime-local','month','time','week'])?'max':'maxlength';
        if($n!==null)
            $this->attributes[$tag]=$n;
        else
            unset($this->attributes[$tag]);
        return $this;
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