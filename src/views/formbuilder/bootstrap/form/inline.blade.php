@foreach($fields AS $field)

    <div class="form-group">
        {!! $field->renderLabel(['class'=>'col-sm-2 control-label']) !!}
        <div class="row">
            <div class="col-sm-8">
            @if(!$field->isGroup())
                    {!!
                        ($field->type=='checkbox'||$field->type=='radio')?
                            $field->render()://No form-control for input or radios
                            $field->addClass('form-control')->render()
                    !!}
            @else
                @foreach($field AS $f)
                    {!! $f->renderLabel() !!}
                    {!! $f->addClass('form-control')->render() !!}
                @endforeach
            @endif
            </div>
        </div>
    </div>
@endforeach
