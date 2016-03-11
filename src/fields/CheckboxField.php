<?php
namespace plokko\FormBuilder\fields;

use plokko\FormBuilder\FormBuilder;

class CheckboxField extends FormField
{
    protected
        $checked=false;

    function __construct(FormBuilder &$form, $name, $type)
    {
        parent::__construct($form, $name, ($type=='radio'?'radio':'checkbox'));
    }

    function getValue()
    {
        //Does NOT use the old value (only checked status changes)
        return $this->value;
    }

    function render()
    {
        unset($this->options['checked']);
        $form=\App::make('form');
        return $form->{$this->type}($this->name,$this->getValue(),$this->checked,$this->options);
    }

    /**
     * Set checkbox as checked
     * @param bool $checked check status
     * @return CheckboxField $this
     */
    function checked($checked=true)
    {
        $this->checked=!!$checked;
        return $this;
    }

    function __get($k)
    {
        switch($k) {
            case 'checked'://Read only access
                return $this->{$k};
            default:
                return parent::__get($k);
        }
    }

    function fill($value)
    {
        $this->checked($value==$this->value);
    }

}