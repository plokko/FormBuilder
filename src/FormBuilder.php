<?php
namespace plokko\FormBuilder;

use ArrayAccess;
use plokko\FormBuilder\Contracts\FormBuilderField;

class FormBuilder implements ArrayAccess
{
    private
        $formopt=[],
        $view='formbuilder.bootstrap.base',
        $fields=[];

    function __construct(){}

    function make($opt=[]){
        $this->formopt=$opt;
        return $this;
    }

    function removeField($k)
    {
        unset($this->fields[$k]);
    }


    function setView($v)
    {
        $this->view=$v;
        return $this;
    }


    public function offsetExists($k)
    {
        return array_key_exists($k,$this->fields);
    }


    /**
     * @param string $k
     * @return FieldProvider
     */
    private function initField($k){
        return $this->fields[$k]=new FieldProvider($this,$k);//FormField($this,$k);
    }
    private function initFieldGroup($k){
        return $this->fields[$k]=new FormFieldGroup($this,$k);
    }


    /**
     * @param mixed $k
     * @return FieldProvider
     */
    public function offsetGet($k)
    {
        return $this->initField($k);
    }

    /**
     * @param $name
     * @return FormFieldGroup
     */
    function group($name)
    {
        return $this->initFieldGroup($name);
    }
    public function offsetSet($k, $v)
    {
        return $this->initField($k)->text($v);
    }

    public function offsetUnset($k)
    {
        $this->removeField($k);
    }

    function __set($k,FormBuilderField $f)
    {
        return $this->fields[$k]=$f;
    }

    /**
     * @param $k
     * @return FieldProvider
     */
    function __get($k){
        return $this->initField($k);
    }
/*
    function __call($k,$arg){
        return $this->initField($arg[0])->{$k}(isset($arg[1])?$arg[1]:null);
    }
*/
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
        try {
            return ''.$this->render();
        } catch (\Exception $e) {
            return 'FormBuilder ERROR:'.$e->getMessage();
        }
    }

    function openForm(){
        return \Form::open($this->formopt);
    }
    function closeForm(){
        return \Form::close();
    }


    function fillValuesWith($el){
        foreach($this->fields AS $k=>&$f){

            if(isset($el[$k]))
                $f->value($el[$k]);
        }
    }


}