<?php
/**@var \plokko\FormBuilder\fields\FieldGroup $group **/
/**@var array $fields **/
?>
@foreach($fields AS $field)<?/**@var \plokko\FormBuilder\fields\FormField $field**/?>
    @include('formbuilder::bootstrap.fieldgroup.field.inline',['field'=>$field])
@endforeach
