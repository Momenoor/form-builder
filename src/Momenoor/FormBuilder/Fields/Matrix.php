<?php namespace Momenoor\FormBuilder\Fields;

class Matrix extends FormFieldsView {

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
