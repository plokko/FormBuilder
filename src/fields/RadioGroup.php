<?php
namespace plokko\FormBuilder\fields;


class RadioGroup extends FormField implements \ArrayAccess
{
    protected
        $view='formbuilder::bootstrap.radiogroup.inline',
        $fields=[];


    /**
     * Set the form view
     * @param string $view
     */
    function view($view)
    {
        $this->view=$view;
        return $this;
    }

    /**
     * Add a radio option
     * @param string $value value of the option
     * @param null|string $label optional label
     * @return $this
     */
    function addOption($value, $label=null)
    {
        $this->fields[$value]=\FormBuilder::field($this->form,$this->name,'radio')
            ->value($value)
            ->label($label?:$value);
        return $this;
    }


    function option($value,$label=null)
    {
        $this->addOption($value,$label);
        return $this->offsetGet($value);
    }

    /**
     * Render the form group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function render()
    {
        //Update check status//
        $value=$this->getValue();
        foreach($this->fields AS $k=>&$f){
            /**@var CheckboxField $f **/
            $f->checked($k==$value);

            $f->disabled($this->__get('disabled'));
            $f->required($this->__get('required'));
        }

        return view($this->view,[
            'group'=>$this,
            'fields'=>$this->fields,
        ]);
    }

    public function offsetExists($offset)
    {
        return isset($this->fields[$offset]);
    }

    public function &offsetGet($offset)
    {
        // Automatically adds option if non existent //
        if(!isset($this->fields[$offset]))
            $this->addOption($offset);

        return $this->fields[$offset];
    }

    public function offsetSet($offset, $value)
    {
        return $this->addOption($offset,$value);
    }

    public function offsetUnset($offset)
    {
        unset($this->fields[$offset]);
    }
}