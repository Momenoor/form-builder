<?php namespace Momenoor\FormBuilder\Fields;

class DatePicker extends FormField {

    protected function getTemplate()
    {
        return 'datepicker';
    }


    protected function getDefaults()
    {
        return [
            'range'          => false,
            'format'         => 'mm/dd/yyyy',
            'autoclose'      => true,
            'todayHighlight' => true
        ];
    }
}
