<?php
/**@var \plokko\FormBuilder\fields\RadioGroup $group **/
/**@var array $fields **/
?>

<div class="btn-group" data-toggle="buttons">
@foreach($fields AS $field)
    <?/**@var \plokko\FormBuilder\FormField $field**/?>

    <label class="btn btn-primary @if($field->checked) active @endif">
        {!! $field->option('autocomplete','off')->render() !!}
        {!! $field->label->text!!}
    </label>
@endforeach
</div>
