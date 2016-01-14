@foreach($fields AS $field)

    <div class="form-group">
        {!! $field->label(['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-8">
        @if(!$field->isGroup())
                {!!
                    ($field->type=='checkbox'||$field->type=='radio')?
                        $field://No form-control for input or radios
                        $field->addClass('form-control')
                !!}
        @else
            @foreach($field AS $f)
                {!! $f->label() !!}
                {!! $f->addClass('form-control') !!}
            @endforeach
        @endif
        </div>
    </div>
@endforeach
