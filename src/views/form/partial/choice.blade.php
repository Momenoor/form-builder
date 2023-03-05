@if ($showLabel && $showField)
    <div {!! $options['wrapperAttrs'] !!}>
@endif

@if ($showLabel)
    {!! Form::label($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    @foreach ((array) $options['children'] as $child)
        @if (isset($noEdit) and $noEdit === true)
            {!! $child->view() !!}
        @else
            {!! $child->render() !!}
        @endif
    @endforeach
@endif

@if ($showError && isset($errors))
    {!! $errors->first(
        data_get($options, 'real_name', $name),
        '<div ' . $options['errorAttrs'] . '>:message</div>',
    ) !!}
@endif

@if (isset($options['help']))
    <span class="help-block">{!! $options['help'] !!}</span>
@endif
@if ($showLabel && $showField)
    </div>
@endif
