<?php
/**@var array $fields**/
?>
@foreach($fields AS $field)
    <?/**@var \plokko\FormBuilder\FormField $field**/?>
    @include('formbuilder::bootstrap.form.field.inline',['field'=>$field])
@endforeach
