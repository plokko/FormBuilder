<?php
namespace plokko\FormBuilder;

class FormLabel
{
    public
        $text;
    private
        $name,
        $options=[];

    function __construct($name,$text)
    {
        $this->name=$name;
        $this->text=$text;
    }

    function render()
    {
        return \Form::label($this->name,$this->text,$this->options);
    }

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