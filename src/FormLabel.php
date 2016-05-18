<?php
namespace plokko\FormBuilder;

class FormLabel
{
    public
        $text;

    protected
        $name,
        $attributes=[],
        $hidden=false;

    function __construct($name,$text)
    {
        $this->name=$name;
        $this->text=$text;
    }

    function render()
    {
        return $this->hidden?
                 '':
                 \Form::label($this->name,$this->text,$this->attributes);
    }

    /**
     * Set an option value
     * @param string $k option name
     * @param mixed|null $v option value,if null it will be removed
     * @return FormLabel $this
     */
    function option($k, $v)
    {
        if($v==null)
            unset($this->attributes[$k]);
        else
            $this->attributes[$k]=$v;
        return $this;
    }

    function hidden($hidden=true)
    {
        $this->hidden=!!$hidden;
        return $this;
    }



    function __toString()
    {
        return $this->text;
    }

    /**
     * Set a field attribute value
     * @param string $k option name
     * @param mixed|null $v option value,if null it will be removed
     * @return FormField $this
     */
    function attribute($k, $v)
    {
        if($v==null)
            unset($this->attributes[$k]);
        else
            $this->attributes[$k]=$v;
        return $this;
    }

    /**
     * Replace all the field attributes with the given array
     * @param array $attributes
     * @return FormField $this
     */
    function attributes(array $attributes)
    {
        $this->attributes=$attributes;
        return $this;
    }


}