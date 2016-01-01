<?php
namespace plokko\FormBuilder;
use ArrayIterator;
use Iterator;
use Traversable;

class FormFieldGroup implements Contracts\FormBuilderField, \IteratorAggregate
{
    public
        $form,
        $name,
        $label=null;

    private
        $fields=[];

    function __construct(&$form,$name,$value=null)
    {
        $this->form=$form;
        $this->name=$name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    function getLabel(){
        return $this->label?:$this->name;
    }
    /**
     * Render the associated label
     * @param array $opt
     * @return string
     */
    function label($opt=[])
    {
        return \Form::label(
            $this->name,
            $this->getLabel(),
            $opt
        );
    }


    /**
     * @param $label
     * @return $this
     */
    function title($label){
        $this->label=$label;
        return $this;
    }


    function isGroup()
    {
        return true;
    }


    /// ADD FIELDS ///
    function radio($value)
    {
        return $this->fields[] =
            (new FormField($this->name))
                ->radio($value);
    }

    function checkbox($value)
    {
        return $this->fields[] =
            (new FormField($this->name))
                ->checkbox($value);
    }


    function __call($k,$v){
        switch($k){

        }
    }

    ////////////ITERATOR IMPLEMENTATION///////////


    public function getIterator()
    {
        return new ArrayIterator($this->fields);
    }
}