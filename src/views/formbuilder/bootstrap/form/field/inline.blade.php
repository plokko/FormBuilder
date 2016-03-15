<?/**@var \plokko\FormBuilder\FormField $field**/?>
<div class="form-group{{ $errors->has($field->name) ? ' has-error' : '' }}">
    {!! $field->label->option('class','col-sm-2 control-label')->render()!!}
    <div class="row">
        <div class="col-sm-8">
            @if($field->type!='checkbox'&&$field->type!='radio')
                <?$field->addClass('form-control');/*Add class except for radio or checkbox fields*/?>
            @endif
            {!! $field->render() !!}


            @if ($errors->has($field->name))
                <span class="help-block">
                        <strong>{{$errors->first($field->name)}}</strong>
                    </span>
            @endif
        </div>
    </div>
</div>