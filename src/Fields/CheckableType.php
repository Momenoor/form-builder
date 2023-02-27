<?php namespace Momenoor\FormBuilder\Fields;

class CheckableType extends FormField
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
        return $this->type;
    }

    public function getDefaults()
    {
        return [
            'attr' => ['class' => null],
            'default_value' => null,
            'label_attr' => ['id' => '', 'for' => ''],
            'checked' => false
        ];
    }
}
