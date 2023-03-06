<?php

namespace Momenoor\FormBuilder\Fields;

class SwitcheryType extends FormField
{

    const DEFAULT_VALUE = 1;

    /**
     * @inheritdoc
     */
    protected $valueProperty = 'checked';

    /**
     * {@inheritdoc}
     */
    protected function isValidValue($value)
    {
        return $value !== null;
    }


    protected function getTemplate()
    {
        return 'switchery';
    }

    public function getDefaults()
    {
        return [
            'wrapper' => ['class' => 'row mb-5'],
            'attr' => ['class' => 'form-check-input'],
            'default_value' => 1,
            'label_attr' => ['id' => '', 'for' => ''],
            'checked' => false
        ];
    }
}
