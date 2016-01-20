{!! Form::open($opt) !!}
@foreach($fields AS $field)

    <div class="form-group">
        {!! $field->renderLabel(['class'=>'control-label']) !!}
        <div>
        @if(!$field->isGroup())
            {!!
                ($field->type=='checkbox'||$field->type=='radio')?
                    $field://No form-control for input or radios
                    $field->addClass('form-control')
            !!}
        @else
            @foreach($field AS $f)
                {!! $f->renderLabel() !!}
                {!! $f->addClass('form-control') !!}
            @endforeach
        @endif
        </div>
    </div>
@endforeach
{!! Form::close() !!}