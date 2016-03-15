<?php
namespace plokko\FormBuilder\fields;

use Illuminate\Support\Facades\Request;
use League\Flysystem\Exception;
use plokko\FormBuilder\FormBuilder;
use plokko\FormBuilder\FormLabel;

/**
 * Base class for FormBuilder fields
 * @package plokko\FormBuilder\fields
 */
class FormField
{
    public
        $useOldValue=true;

    protected
        /**@var \plokko\FormBuilder\FormBuilder**/
        $form,
        $type,
        $value=null,
        $name,
        $label=null,
        $attributes=[];

    /**
     * FormField constructor.
     * @param FormBuilder $form
     * @param string $name
     * @param string $type
     */
    function __construct(FormBuilder &$form,$name,$type='text')
    {
        $this->form=$form;
        $this->name=$name;
        $this->type=$type;
    }

    function __get($k)
    {
        switch($k){
            case 'value':
                return $this->getValue();//Get value
            // Read only fields //
            case 'name':
            case 'type':
            case 'attributes':
                return $this->{$k};

            case 'label':
                return $this->getLabel();


            case 'disabled':
            case 'required':
                return isset($this->attributes[$k]);

            default:
            case 'id':
            case 'class':
                return isset($this->attributes[$k])?$this->attributes[$k]:null;

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

    /**
     * Set the useoldvalue status, if true the value previusly specified (if present) will be used instead of the field value
     * @param bool $use
     * @return $this
     */
    function useOldValue($use=true)
    {
        $this->useOldValue=$use;
        return $this;
    }

    function getLabel()
    {
        $id=$this->__get('id');

        if(!$id)
        {   //Generate an unique id for the field
            $id=uniqid(str_replace(['[]','[',' ',']'], '_', $this->name));
            $this->id($id);
        }
        $text=$this->label?:(str_replace(['[]','[',']','_'], ['','(',')',' '],$this->name));

        return new FormLabel($id,$text);
    }

    function getValue()
    {
        if($this->useOldValue && \Request::hasSession())//Old value only availalble with session support
        {
            return old($this->name,$this->value);
        }else{
            return $this->value;
        }
    }

    /**
     * Set the field value
     * @param string $v
     * @return FormField $this
     */
    function value($v)
    {
        $this->value=$v;
        return $this;
    }


    /**
     * Set the field as required
     * @param bool $required
     * @return $this
     */
    function required($required=true)
    {
        if($required)
            $this->attributes['required']='required';
        else
            unset($this->attributes['required']);
        return $this;
    }

    /**
     * Set the field as disabled
     * @param bool $disabled
     * @return $this
     */
    function disabled($disabled=true)
    {
        if($disabled)
            $this->attributes['disabled']='disabled';
        else
            unset($this->attributes['disabled']);
        return $this;
    }

    /**
     * Set the field CSS class
     * @param string $class
     * @return $this
     */
    function setClass($class)
    {
        $this->attributes['class']=$class;
        return $this;
    }

    /**
     * Append a CSS class to the field
     * @param string $class
     * @return $this
     */
    function addClass($class)
    {
        $this->attributes['class']=(isset($this->attributes['class']))?
            implode(' ',array_unique(explode(' ',$this->attributes['class'])+explode(' ',$class)))//Remove repeated classes
            :$class;

        return $this;
    }

    /**
     * tells if the form handles file uploads
     * @return bool
     */
    function isFile(){return false;}


    /**
     * Render the field
     * @return mixed
     */
    function render()
    {
        return \Form::text($this->name,$this->getValue(),$this->attributes);
    }

    function __toString()
    {
        try{
            return ''.$this->render();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    function id($id=null)
    {
        $this->attributes['id']=$id;
        return $this;
    }
    /**
     * Set the label field
     * @param string $text
     * @return FormField $this
     */
    function label($text)
    {
        $this->label=$text;
        return $this;
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

    function fill($value)
    {
        return $this->value($value);
    }
}