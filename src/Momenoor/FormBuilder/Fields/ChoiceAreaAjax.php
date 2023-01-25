<?php namespace Momenoor\FormBuilder\Fields;


class ChoiceAreaAjax extends FormFieldsView
{
    protected function getTemplate()
    {
        return 'choice_area_ajax';
    }


    protected function getDefaults()
    {
        return [
            'action'   => ''
        ];
    }
}
