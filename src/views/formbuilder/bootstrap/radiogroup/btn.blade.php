<?php
/**@var \plokko\FormBuilder\fields\RadioGroup $group **/
/**@var array $fields **/
?>

<div class="btn-group" data-toggle="buttons">
@foreach($fields AS $field)<?/**@var \plokko\FormBuilder\FormField $field**/?>
    <label class="<?
            $cl=array_unique(array_merge(['btn'],explode(' ',$field->class)));
            if(count(array_intersect($cl,[]))==0) $cl[]='btn-default';
            if($field->checked)$cl[]='active';
            echo implode(' ',$cl);
    ?>">
        {!! $field->setClass('')->attribute('autocomplete','off')->render() !!}
        {!! $field->label->text!!}
    </label>
@endforeach
</div>
