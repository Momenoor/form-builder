<?php namespace Momenoor\FormBuilder\Fields;

class FolderChooser extends FormField {

    protected function getTemplate()
    {
        return 'folder_chooser';
    }


    protected function getDefaults()
    {

        return [
            'label_chooser' => trans('forms.browse'),
            'badge_class'   => 'badge-success badge-roundless'
        ];
    }
}
