<?php namespace Momenoor\FormBuilder\Fields;

class UploadType extends FormFieldsView {

    protected function getTemplate()
    {
        return 'upload';
    }


    protected function getDefaults()
    {
        return [
            'extensions' => '',
            'view'       => '',
        ];
    }
}
