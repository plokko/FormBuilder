<?php
/**@var \plokko\FormBuilder\fields\RadioGroup $group **/
/**@var array $fields **/
?>
@foreach($fields AS $field)<?/**@var \plokko\FormBuilder\fields\CheckboxField $field**/?>
    <label class="radio-inline"> {!! $field->render() !!} {!! $field->label->text!!}</label>
@endforeach
