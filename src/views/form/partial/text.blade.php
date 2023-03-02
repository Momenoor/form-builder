@if ($type == 'hidden')
    {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
@else
    @if ($showLabel && $showField && !$options['is_child'])
        <div {!! $options['wrapperAttrs'] !!}>
    @endif

    @if ($showLabel)
        {!! Form::label($name, $options['label'], $options['label_attr']) !!}
    @endif

    @if ($showField)
        @if (isset($noEdit) and $noEdit === true)
            {!! $options['default_value'] !!}
        @else
            {!! Form::input($type, $name, $options['default_value'], $options['attr']) !!}
        @endif
    @endif

    @if ($showError && isset($errors))
        {!! $errors->first(
            data_get($options, 'real_name', $name),
            '<span ' . $options['errorAttrs'] . '>:message</span>',
        ) !!}
    @endif
    @if (isset($options['help']))
        <span class="help-block">{!! $options['help'] !!} </span>
    @endif


    @if ($showLabel && $showField && !$options['is_child'])
        </div>
    @endif

@endif
