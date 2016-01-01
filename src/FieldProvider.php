<?php
namespace plokko\FormBuilder;

use plokko\FormBuilder\Contracts\FormBuilderField;

class FieldProvider
{
    private
        $form,
        $name;

    function __construct(FormBuilder &$form,$name)
    {
        $this->form = $form;
        $this->name = $name;
    }

    /**
     * @param $field
     * @return FormBuilderField
     */
    private function initField(FormBuilderField $field)
    {
        return $this->form->{$this->name}=$field;
    }

    /**
     * @param string $type
     * @param $val
     * @return FormField
     */
    private function _formField($type, $val){
        $f=new FormField($this->form,$this->name);
        $f->type($type);
        if($val)$f->value($val);
        return $this->initField($f);
    }

    /**
     * @param $k
     * @param $v
     * @return FormField
     */
    function __call($k,$v)
    {
        switch($k){
            default:$k='text';break;//Revert to default input type if not listed
            case 'hidden':
            case 'email':
            case 'radio':
            case 'checkbox':
            case 'textarea':
            case 'text':
            case 'number':
            case 'password':
            case 'date':
            case 'time':
        }
        return $this->_formField($k,isset($v[0])?$v[0]:null);
    }

    /**
     * @param null $v
     * @return FormFieldGroup
     */
    function group($v=null){
        $f=new FormFieldGroup($this->form,$this->name);
        if($v)$f->value($v);

        return $this->initField($f);
    }

    /**
     * @param null $v
     * @return SelectField
     */
    function select($v=null){
        $f=new SelectField($this->form,$this->name);
        if($v)$f->value($v);
        return $this->initField($f);
    }

    /**
     * @param null $v
     * @return Select2Field
     */
    function select2($v=null){
        $f=new Select2Field($this->form,$this->name);
        if($v)$f->value($v);
        return $this->initField($f);
    }



}