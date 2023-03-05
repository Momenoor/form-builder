<?php

return [
    'defaults'           => [
        'wrapper_class'       => 'form-group mb-5',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'form-label fs-6 fw-bolder text-gray-700 mb-3',
        'field_class'         => 'form-control form-control-solid',
        'error_class'         => 'help-block text-danger',
        'field_error_class'   => '',
        'help_block_class'    => 'help-block',
        'required_class'      => 'required',
        'help_block_tag'      => 'p',
    ],
    'moxy_manager_path'  => '/assets/moxiemanager/plugin.min.js',
    'api_google_map_key' => env('GOOGLE_MAP_JS_API_KEY'),
    // Templates
    'form'          => 'form-builder::form.partial.form',
    'text'          => 'form-builder::form.partial.text',
    'textarea'      => 'form-builder::form.partial.textarea',
    'button'        => 'form-builder::form.partial.button',
    'buttongroup'   => 'form-builder::form.partial.buttongroup',
    'radio'         => 'form-builder::form.partial.radio',
    'checkbox'      => 'form-builder::form.partial.checkbox',
    'select'        => 'form-builder::form.partial.select',
    'choice'        => 'form-builder::form.partial.choice',
    'repeated'      => 'form-builder::form.partial.repeated',
    'child_form'    => 'form-builder::form.partial.child_form',
    'collection'    => 'form-builder::form.partial.collection',
    'static'        => 'form-builder::form.partial.static',
    'tinymce'            => 'form-builder::form.partial.tinymce',
    'tag'                => 'form-builder::form.partial.tag',
    'choice_area'        => 'form-builder::form.partial.choice_area',
    'address_picker'     => 'form-builder::form.partial.address_picker',
    'choice_ajax'        => 'form-builder::form.partial.choice_ajax',
    'datepicker'         => 'form-builder::form.partial.datepicker',
    'upload'             => 'form-builder::form.partial.upload',
    'matrix'             => 'form-builder::form.partial.matrix',
    'choice_area_ajax'   => 'form-builder::form.partial.choice_area_ajax',
    'folder_chooser'     => 'form-builder::form.partial.folder_chooser',
    'row'                => 'form-builder::form.partial.row',
    'select2'                => 'form-builder::form.partial.select2',

    'custom_fields' => [
        'button'                   => 'Momenoor\FormBuilder\Fields\ButtonType',
        'radio'                    => 'Momenoor\FormBuilder\Fields\CheckableType',
        'checkbox'                 => 'Momenoor\FormBuilder\Fields\CheckableType',
        'text'                     => 'Momenoor\FormBuilder\Fields\InputType',
        'email'                    => 'Momenoor\FormBuilder\Fields\InputType',
        'upload'                   => 'Momenoor\FormBuilder\Fields\UploadType',
        'number'                   => 'Momenoor\FormBuilder\Fields\InputType',
        'select'                   => 'Momenoor\FormBuilder\Fields\SelectType',
        'textarea'                 => 'Momenoor\FormBuilder\Fields\TextareaType',
        'tinymce'                  => 'Momenoor\FormBuilder\Fields\Tinymce',
        'tag'                      => 'Momenoor\FormBuilder\Fields\Tag',
        'choice'                   => 'Momenoor\FormBuilder\Fields\ChoiceType',
        'form'                     => 'Momenoor\FormBuilder\Fields\ChildFormType',
        'choice_area'              => 'Momenoor\FormBuilder\Fields\ChoiceArea',
        'address_picker'           => 'Momenoor\FormBuilder\Fields\AddressPicker',
        'choice_ajax'              => 'Momenoor\FormBuilder\Fields\ChoiceAjax',
        'datepicker'               => 'Momenoor\FormBuilder\Fields\DatePicker',
        'folder_chooser'           => 'Momenoor\FormBuilder\Fields\FolderChooser',
        'matrix'                   => 'Momenoor\FormBuilder\Fields\Matrix',
        'choice_area_ajax'         => 'Momenoor\FormBuilder\Fields\ChoiceAreaAjax',
        'cloudinary_media_library' => 'Momenoor\FormBuilder\Fields\CloudinaryMediaLibrary',
    ],

    'cloudinary' => [
        'enabled'    => env('CLOUDINARY_ENABLED'),
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
    ],
    // Templates


    // Remove the form-builder:: prefix above when using template_prefix
    'template_prefix'   => '',

    'default_namespace' => '',

    'plain_form_class' => \Momenoor\FormBuilder\Form::class,
    'form_builder_class' => \Momenoor\FormBuilder\FormBuilder::class,
    'form_helper_class' => \Momenoor\FormBuilder\FormHelper::class,

    'translator_prefix' => 'app',

];
