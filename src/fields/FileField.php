<?php
namespace plokko\FormBuilder\fields;

use plokko\FormBuilder\FormBuilder;

class FileField extends FormField
{
    function __construct(FormBuilder &$form, $name, $type)
    {
        parent::__construct($form, $name, 'file');
    }

    function render()
    {
        $form=\App::make('form');
        return $form->file($this->name,$this->attributes);
    }

    /**
     * Set the acceptable file extension/mimetypes (<input accept="...">)
     * @param null|string|array $opt Accepted extensions/mimetypes, comma separated, (ex: ".pdf,image/jpeg,audio/*")
     * @return FileField $this
     */
    function accept($opt=null)
    {
        if($opt==null)
            unset($this->attributes['accept']);
        else
            $this->attributes['accept']=is_array($opt)?implode(',',$opt):$opt;
        return $this;
    }


    function multiple($multiple=true)
    {
        if(!$multiple)
            unset($this->attributes['multiple']);
        else
            $this->attributes['multiple']='multiple';
        return $this;
    }

    function isFile()
    {
        return true;
    }
}