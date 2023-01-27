<?php
namespace Momenoor\FormBuilder;
use Kris\LaravelFormBuilder\Field as baseField;

class Field extends baseField{

    const CHOICE_AJAX = 'choice_ajax';
    const TINYMCE = 'tinymce';
    const UPLOAD = 'upload';
    const ADDRESS_PICKER = 'address_picker';
}
