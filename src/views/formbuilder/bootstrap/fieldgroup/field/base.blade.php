<?/**@var \plokko\FormBuilder\FormField $field**/?>
<div class="form-group">
    {!! $field->label->render()!!}
    @if($field->type!='checkbox'&&$field->type!='radio')
        <?$field->addClass('form-control');/*Add class except for radio or checkbox fields*/?>
    @endif
    {!! $field->render() !!}
</div>
