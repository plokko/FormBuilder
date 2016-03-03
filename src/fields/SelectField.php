<?php
namespace plokko\FormBuilder\fields;

class SelectField extends FormField
{
    protected
        $values=[];

    /**
     * Set the possibile select values as a value => label array
     * @param array $values possible values
     * @return SelectField $this
     */
    function values(array $values)
    {
        $this->values=$values;
        return $this;
    }


    function render()
    {
        $form=\App::make('form');
        $t=$this->type;
        $v=$this->getValue();
        $values=$this->values;
        //Optional value if not required//
        if(!$this->__get('required') && !array_key_exists('',$values))
            $values=[''=>'']+$values;

        return $form->select($this->name,$values,$v,$this->options);
    }

    /**
     * Automatically gets the values from an Eloquent class/query
     *
     * @param \Illuminate\Database\Eloquent\Builder|string $query
     * @param string $key column to use as values
     * @param null|string $label column to use as value label, if null it will match the value
     * @return $this
     */
    function valuesFrom($query,$key,$label=null)
    {
        if(!$label)
            $label=$key;

        if($query instanceof \Illuminate\Database\Eloquent\Builder ){
            $rs=$query->lists($label,$key);
        }else{
            $rs=call_user_func([$query,'lists'],$label,$key);
        }

        $this->values($rs->toArray());
        return $this;
    }

    function __get($k)
    {
        switch($k) {
            case 'values'://Read only access
                return $this->values;
            default:
                return parent::__get($k);
        }
    }

}