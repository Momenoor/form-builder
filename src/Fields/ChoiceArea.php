<?php namespace Momenoor\FormBuilder\Fields;

class ChoiceArea extends FormField {

    protected function getTemplate()
    {
        return 'choice_area';
    }


    protected function getDefaults()
    {
        return [
            'choices'  => [],
            'selected' => []

        ];
    }
}
