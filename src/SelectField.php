<?php
namespace plokko\FormBuilder;


use Doctrine\Common\Collections\Collection;

class SelectField implements Contracts\FormBuilderField
{
    public
        $label,
        $value;

    protected
        $form,
        $name,
        $useOldValue=true,
        $opt=[],
        $values=[];

    function __construct(&$form,$name)
    {
        $this->form=$form;
        $this->name=$name;
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
            $this->getLabel(),
            $opt
        );
    }


    function addClass($v){
        $this->opt['class']=(isset($this->opt['class'])?$this->opt['class'].' ':'').$v;
        return $this;
    }
    function setClass($v){
        $this->opt['class']=$v;
        return $this;
    }


    function value($v)
    {
        $this->value=$v;
        return $this;
    }


    function values($v)
    {
        $this->values=$v;
        return $this;
    }

    function required($rq=true)
    {
        if($rq)
            $this->opt['required']='required';
        else
            unset($this->opt['required']);
        return $this;
    }

    function multiple($multiple=true){
        if($multiple)
            $this->opt['multiple']='multiple';
        else
            unset($this->opt['multiple']);
        return $this;
    }

    function isMultiple(){return isset($this->opt['multiple']);}

    function useOldValue($use=true){
        $this->useOldValue=$use;
        return $this;
    }

    function getValue(){

        $v=($this->value instanceof \Illuminate\Support\Collection)?
                    $this->value->toArray()
                    :$this->value;

        return $this->useOldValue?
            old($this->name,$v):
            $v;
    }


    function opt($k,$v){
        $this->opt[$k]=$v;
    }


    function getValuesFrom($query,$key,$label)
    {
        if($query instanceof \Illuminate\Database\Eloquent\Builder ){
            $rs=$query->lists($label,$key);
        }else{
            $rs=call_user_func([$query,'lists'],$label,$key);
        }
        $this->values=$rs->toArray();
        return $this;
    }

    /**
     * @return string
     */
    function toString(){
        $form=\App::make('form');
        $v=$this->getValue();

        $values=$this->values;
        if(!isset($this->opt['required']) &&!isset($this->opt['multiple']) && !isset($values['']))
            $values=[''=>'']+$values;
        //dd([$this->name,$values,$v,$this->opt]);
        return $form->select($this->name,$values,$v,$this->opt);

    }

    /**
     * If cast to string render the html field
     * @return string
     */
    function __toString()
    {
        return $this->toString();
    }

    function isGroup()
    {
        return false;
    }

    function __get($k){if($k=='type')return 'select';}
}