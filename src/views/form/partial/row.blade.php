@if ($showWrapper)
    {!! $wrapper['start'] !!}
@endif
<div {!! $attributes !!}>
    @if ($showFields)
        @if ($fields)
            @foreach ($fields as $field)
                @if (isset($isNotEditable) and $isNotEditable === true)
                    @if (method_exists($field, 'view') and $field->getType() != 'submit')
                        <?php $default = $field->getOptions(); ?>
                        @if (empty($default['default_value']))
                            <?php $name = last(explode('[', rtrim($field->getName(), ']'))); ?>
                            {!! $field->view([
                                'default_value' =>
                                    ($model && $model->exists and isset($model->{$name})) ? $model->{$name} : $default['default_value'],
                                'model' => (!empty($model) and isset($model->{$name})) ? $model->{$name} : null,
                            ]) !!}
                        @else
                            {!! $field->view() !!}
                        @endif
                    @endif
                @else
                    {!! $field->render() !!}
                @endif
            @endforeach
        @endif
    @endif
</div>
@if ($showWrapper)
    {!! $wrapper['end'] !!}
@endif
