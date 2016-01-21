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
        $label;

    private
        $fields=[];

    function __construct(&$form,$name,$value=null)
    {
        $this->form=$form;
        $this->name=$name;
        $this->value = $value;
    }

    /**
     * @param $label
     * @return $this
     */
    function label($label){
        $this->label=$label;
        return $this;
    }
    /**
     * Render the associated label
     * @param array $opt
     * @return string
     */
    function renderLabel($opt=[])
    {
        return \Form::label(
            $this->name,
            $this->label,
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