<?php
namespace plokko\FormBuilder;

use ArrayAccess;
use plokko\FormBuilder\Contracts\FormBuilderField;

class FormBuilder implements ArrayAccess
{
    private
        $formopt=[],
        $view='formbuilder::bootstrap.form.base',
        $fields=[];

    function __construct($opt)
    {
        $this->formopt=$opt;
    }

    function removeField($k)
    {
        unset($this->fields[$k]);
    }


    function view($v)
    {
        $this->view=$v;
        return $this;
    }


    function __call($fn,$args)
    {
        $name=$args[0];
        $this->fields[$name]=\FormBuilder::field($this,$name,$fn);
        return $this->fields[$name];
    }

    /**
     * @param String $k
     * @return FormField
     */
    function __get($k)
    {
        return array_key_exists($k,$this->fields[$k])?
                    $this->fields[$k]:       //Return field
                    $this->call('text',[$k]);//Init and return a new Text field
    }
/*
    function __call($k,$arg){
        return $this->initField($arg[0])->{$k}(isset($arg[1])?$arg[1]:null);
    }
*/
    function openForm()
    {

        $opt=$this->formopt;
        foreach($this->fields AS $f){
            if($f->isFile()){
                $opt['files']=true;
                break;
            }
        }

        return \Form::open($opt);
    }

    function closeForm()
    {
        return \Form::close();
    }

    function render(){
        $v=view($this->view,[
            'opt'=>$this->formopt,
            'fields'=>$this->fields,
        ]);
        //dd($v->render());//DEBUG VIEW ERROR
        return $v;
    }

    function __toString()
    {
        return ''.$this->render();
    }

    public function offsetExists($k)
    {
        return array_key_exists($k,$this->fields);
    }

    public function offsetGet($k)
    {
        return $this->__get($k);
    }

    public function offsetSet($k, $v){}

    public function offsetUnset($k)
    {
        unset($this->fields[$k]);
    }

    function fill($el){
        foreach($this->fields AS $k=>&$field){
            /**@var \plokko\FormBuilder\fields\FormField $field **/
            if(array_key_exists($k,$el))
            {
                $field->fill($el[$k]);
            }
        }
        return $this;
    }
}