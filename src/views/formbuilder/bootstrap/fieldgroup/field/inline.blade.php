<?/**@var \plokko\FormBuilder\FormField $field**/?>
<div class="form-group">
    {!! $field->label->attribute('class','col-sm-2 control-label')->render()!!}
    <div class="row">
        <div class="col-sm-8">
            @if($field->type!='checkbox'&&$field->type!='radio')
                <?$field->addClass('form-control');/*Add class except for radio or checkbox fields*/?>
            @endif
            {!! $field->render() !!}
        </div>
    </div>
</div>