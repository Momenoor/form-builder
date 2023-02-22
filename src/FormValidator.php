<?php
namespace Momenoor\FormBuilder;

use Closure;
use \Validator;
use \Redirect;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class FormValidator extends FormView
{

    public $rows = [];
    public static $rules = [];
    public static $rules_update = null;

    // ------------------------------------------------------------------------------------------------

    protected $hasError = false;
    protected $validation = null;
    protected $formOptions = [
        'method' => 'POST',
        'url' => null,
    ];


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @param bool $modify
     * @param bool $noOveride
     * @return $this
     */

    public function addRow($name, $options = [], $callback)
    {
        $row = new FormRow($name, $options = [], $this->formHelper, $this);
        if ($callback instanceof Closure) {
            $callback($row);
        }

        $this->rows[$name] = $row;
        return $this;
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    /**
     * @param string $name
     * @param string $type
     * @param array $options
     * @param bool $modify
     * @param bool $noOveride
     * @return $this
     */
    public function add($name, $type = 'text', array $options = [], $modify = false, $noOveride = false)
    {

        $defaultClass = $this->formHelper->getConfig('defaults.field_class') . ' ';
        if (empty($options['attr']['class'])) {
            $options['attr']['class'] = '';
        }

        if (empty($noOveride)) {
            $options['attr']['class'] = $defaultClass . ' ' . $options['attr']['class'] . ' ';
        }

        if (!empty($options) && isset($options['validation'])) {

            $options['attr']['class'] .= ' validate[' . $options['validation'] . ']' . ' ';
            unset($options['validation']);
        }

        return parent::add($name, $type, $options, $modify);
    }

    // ------------------------------------------------------------------------------------------------

    public function validateAndRedirectBack()
    {
        return Redirect::back()->withErrors($this->validate())->withInput($this->formHelper->getRequest()->all());

    }

    // ------------------------------------------------------------------------------------------------

    public function validate($rules = [], $messages = [])
    {
        if ($this->validation == null) {

            $fields = $this->getFields();

            foreach ($fields as $field) {
                if ($field->getType() == 'form') {

                    $validation = Validator::make($this->formHelper->getRequest()->get($field->getName(), []), $field->getClass()->getRules());

                    if ($validation->fails()) {
                        $this->hasError = true;
                        $this->validation = $validation;

                        return $this->validation;
                    }
                }
            }

            $validation = Validator::make($this->formHelper->getRequest()->all(), $this->getRules());

            $validation->after(function ($validator) {
                $this->afterValidate($validator, $this->formHelper->getRequest()->all());
            });

            if ($validation->fails()) {
                $this->hasError = true;
            }

            $this->validation = $validation;
        }

        return $this->validation;
    }

    // ------------------------------------------------------------------------------------------------

    protected function afterValidate(ValidatorContract $validator, array $inputs)
    {
        return;
    }

    // ------------------------------------------------------------------------------------------------

    public function hasError()
    {

        if ($this->validation == null) {
            $this->validate();
        }

        return $this->hasError;
    }


    // ------------------------------------------------------------------------------------------------

    public function addDefaultActions()
    {
        $this->add(
            'submit',
            'submit',
            [
                'label' => trans('form-builder::form.save'),
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ],
            false,
            true
        )
            ->add(
                'back',
                'button',
                [
                    'label' => trans('form-builder::form.back'),
                    'attr' => [
                        'class' => 'btn btn-light',
                        'onclick' => 'window.history.back()'
                    ],
                ],
                false,
                true
            );

    }

    // ------------------------------------------------------------------------------------------------

    public function getRules($overrideRules = [])
    {
        $key = !empty($this->model) ? $this->formHelper->getRequest()->get($this->model->getKeyName()) : null;

        return ($this->getUpdateRules() == null || empty($key)) ? $this->getGeneralRules() : $this->getUpdateRules();
    }

    // ------------------------------------------------------------------------------------------------

    protected function getGeneralRules()
    {

        return static::$rules;
    }

    // ------------------------------------------------------------------------------------------------

    protected function getUpdateRules()
    {

        return static::$rules_update;
    }

    public function hasRows()
    {
        return (count($this->rows) > 0);
    }

}
