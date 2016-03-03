<?php
namespace plokko\FormBuilder;

class FormLabel
{
    public
        $text;

    protected
        $name,
        $options=[],
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
                 \Form::label($this->name,$this->text,$this->options);
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
            unset($this->options[$k]);
        else
            $this->options[$k]=$v;
        return $this;
    }

    function hidden($hidden=true)
    {
        $this->hidden=!!$hidden;
        return $this;
    }

    /**
     * Replace all the options with the given array
     * @param array $options
     * @return FormLabel $this
     */
    function options(array $options)
    {
        $this->options=$options;
        return $this;
    }

    function __toString()
    {
        return $this->text;
    }

}