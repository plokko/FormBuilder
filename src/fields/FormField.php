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
        $options=[];

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
        return new FormLabel($id,$this->label?:(str_replace(['[]','[',']','_'], ['','(',')',' '],$this->name)));
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
            $this->options['required']=true;
        else
            unset($this->options['required']);
        return $this;
    }

    /**
     * Set the field CSS class
     * @param string $class
     * @return $this
     */
    function setClass($class)
    {
        $this->options['class']=$class;
        return $this;
    }

    /**
     * Append a CSS class to the field
     * @param string $class
     * @return $this
     */
    function addClass($class)
    {
        $this->options['class']=isset($this->options['class'])?
                                        $this->options['class'].' '.$class
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
        return \Form::text($this->name,$this->getValue(),$this->options);
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
        $this->options['id']=$id;
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
     * Set an option value
     * @param string $k option name
     * @param mixed|null $v option value,if null it will be removed
     * @return FormField $this
     */
    function option($k, $v)
    {
        if($v==null)
            unset($this->options[$k]);
        else
            $this->options[$k]=$v;
        return $this;
    }

    /**
     * Replace all the options with the given array
     * @param array $options
     * @return FormField $this
     */
    function options(array $options)
    {
        $this->options=$options;
        return $this;
    }


}