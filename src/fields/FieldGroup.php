<?php
namespace plokko\FormBuilder\fields;


class FieldGroup extends FormField
{
    protected
        $view='formbuilder::bootstrap.fieldgroup.inline',
        $fields=[];

    /**
     * Add a new field to the group
     * @param string $fn
     * @param array $args
     * @return FormField
     */
    function __call($fn,$args)
    {
        $name=$args[0];
        $fullname=$this->name.'['.$name.']';
        $this->fields[$name]=\FormBuilder::field($this->form,$fullname,$fn);
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

    function render()
    {
        foreach($this->fields AS $k=>&$f){
            /**@var FormField $f **/
            if($this->__get('disabled'))
                $f->disabled();
            if($this->__get('required'))
                $f->required();
        }

        return view($this->view,[
            'group'=>$this,
            'fields'=>$this->fields,
        ]);
    }
}