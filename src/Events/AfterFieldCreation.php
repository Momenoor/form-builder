<?php

namespace Momenoor\FormBuilder\Events;

use Momenoor\FormBuilder\Fields\FormField;
use Momenoor\FormBuilder\Form;

class AfterFieldCreation
{
    /**
     * The form instance.
     *
     * @var Form
     */
    protected $form;

    /**
     * The field instance.
     *
     * @var FormField
     */
    protected $field;

    /**
     * Create a new after field creation instance.
     *
     * @param Form $form
     * @param FormField $field
     * @return void
     */
    public function __construct(Form $form, FormField $field) {
        $this->form = $form;
        $this->field = $field;
    }

    /**
     * Return the event's form.
     *
     * @return Form
     */
    public function getForm() {
        return $this->form;
    }

    /**
     * Return the event's field.
     *
     * @return FormField
     */
    public function getField() {
        return $this->field;
    }
}
