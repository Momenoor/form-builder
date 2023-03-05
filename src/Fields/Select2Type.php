<?php

namespace Momenoor\FormBuilder\Fields;

class Select2Type extends FormField
{

    protected function getTemplate()
    {
        return 'select2';
    }

    public function getDefaults()
    {
        return [
            'choices' => [],
            'empty_value' => null,
            'selected' => null,
            'attr' => [
                'data-control' => 'select2'
            ],
        ];
    }
}
