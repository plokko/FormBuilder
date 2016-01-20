<?php
namespace plokko\FormBuilder;

class FormField implements Contracts\FormBuilderField
{
    public
        $type='text',
        $label,
        $value;

    protected
        $form,
        $name,
        $useOldValue=true,
        $opt=[];

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


    /**
     * @param $k
     * @param $v
     * @return FormField
     */
    function __call($k, $v)
    {
        switch($k){

            //////////FIELD//////////
            case 'hidden':
            case 'email':
            case 'radio':
            case 'checkbox':
            case 'textarea':
            case 'text':
            case 'number':
            case 'password':
                $this->type($k);
                if(isset($v[0]))
                    $this->value($v[0]);
                break;

            ///////////////////////
            case 'checked':case 'multiple':
                if(!isset($v[0])||$v[0])
                    $this->opt[$k]=$k;
                else
                    unset($this->opt[$k]);

                break;
            ///Class///
            case 'addClass':
                if(isset($v[0])&&isset($this->opt['class'])){
                    $this->opt['class'].=' '.$v[0];
                    break;
                }
            case 'class':
                if(isset($v[0]))
                    $this->opt['class']=$v[0];
                break;


            default:
                $this->opt[$k]=$v[0];
            break;
        }
        return $this;
    }


    function value($v)
    {
        $this->value=$v;
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

    function type($t)
    {
        $this->type=$t;
        return $this;
    }

    function useOldValue($use=true){
        $this->useOldValue=$use;
        return $this;
    }

    function getValue(){
        return $this->useOldValue?
                old($this->name,$this->value):
                $this->value;
    }


    function opt($k,$v){
        $this->opt[$k]=$v;
    }

    /**
     * @return string
     */
    function toString(){
        $form=\App::make('form');
        $t=$this->type;
        $v=$this->getValue();
        ///
        switch($t){
            default:
                //$t='text';
            case 'hidden':
            case 'textarea':
            case 'number':
            case 'text':
            case 'radio':
                return $form->{$t}($this->name,$v,$this->opt);
            case 'checkbox':
                return $form->checkbox($this->name,$v,false,$this->opt);
            case 'password':
                return $form->{$t}($this->name,$this->opt);

        }
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
}