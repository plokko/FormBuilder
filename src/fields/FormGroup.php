<?php
namespace plokko\FormBuilder\fields;


class FormGroup extends FormField
{
    protected
        $fields=[];



    /**
     * Add a new field
     * @param string $fn
     * @param array $args
     * @return FormField
     */
    function __call($fn,$args)
    {
        $name=$this->name.'.'.$args[0];
        $this->fields[$name]=\FormBuilder::field($this->form,$name,$fn);
        return $this->fields[$name];
    }

    /**
     * @return array
     */
    function getValue()
    {
        $values=[];
        foreach($this->fields AS $field)
        {
            $values[$field->name]=$field->value;
        }
        return $values;
    }

    function getName()
    {

    }

    function __get($k)
    {
        switch($k){
            case 'value':
                return $this->getValue();//Get value
            // Read only fields //
            case 'name':
            case 'type':
            case 'options':
                return $this->{$k};

            case 'label':
                return $this->getLabel();
            case 'required':
                return isset($this->options['required']);

            case 'id':
                return isset($this->options['id'])?$this->options['id']:null;

            default:
                return null;
        }
    }

    function __set($k,$v)
    {
        switch($k){
            case 'value':
                $this->value($v);
                break;
        }
    }
}