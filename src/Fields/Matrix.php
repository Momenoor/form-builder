<?php namespace Momenoor\FormBuilder\Fields;

class Matrix extends FormField {

    protected function getTemplate()
    {
        return 'matrix';
    }


    protected function getDefaults()
    {

        return [
            'lines' => [],
            'cols'  => []
        ];
    }
}
