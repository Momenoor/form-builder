<?php

namespace Momenoor\FormBuilder\Fields;

class Tag extends FormField
{
    protected function getTemplate()
    {
        return 'tag';
    }

    protected function getDefaults()
    {
        return [
            'default_value' => '',
        ];
    }
}
