<?php

namespace Momenoor\FormBuilder;

use Momenoor\FormBuilder\FormHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FormRow
{

    /**
     * Is field rendered.
     *
     * @var bool
     */
    protected $rendered = false;

    /**
     * @var string
     */

    protected $fields;

    public function __construct(
        protected string $name,
        protected array $options = [],
        protected FormHelper $formHelper,
        protected Form $parent,
        protected $template = ''
    ) {
        $this->template = $this->formHelper->getConfig('row');
        $this->options = $this->formHelper->mergeOptions($this->options, $this->allDefaults());
    }

    public function addToFields($key, $field)
    {
        $this->fields[$key] = $field;
    }

    public function addField($name, $type = 'text', array $options = [], $modify = false, $noOveride = false)
    {
        if ($options['col']) {
            $options['wrapper'] = ['class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-' . $options['col'] . ' ' . (($options['wrapper']['class']) ?? '')];
        }
        $this->parent->add($name, $type, $options, $modify, $noOveride, $this->name);

        return $this;
    }

    public function render($options = [])
    {
        $this->rendered = true;

        $this->prepareOptions($options);

        return  $this->formHelper->getView()
            ->make(
                $this->getTemplate(),
                [
                    'attributes' => $this->getOption('attr'),
                    'fields'     => $this->fields,
                    'showFields' => true,
                ]
            )
            ->render();
    }

    private function allDefaults()
    {
        return [
            'class' => 'row',
            'name' => $this->name,
        ];
    }

    public function getRealName(): string
    {
        return $this->getOption('real_name', $this->name);
    }

    public function getTemplate()
    {
        return $this->template;
    }

    private function prepareOptions($options = [])
    {

        $this->options = $this->formHelper->mergeOptions($options, $this->options);

        $this->setOption('attr', $this->formHelper->prepareAttributes($this->options));
    }

    private function setOption($name, $value)
    {

        Arr::set($this->options, $name, $value);
        return $this;
    }

    private function getOption($option, $default = null)
    {

        return Arr::get($this->options, $option, $default);
    }

    private function removeOption($option)
    {

        return Arr::forget($this->options, $option);
    }

    public function actionRow()
    {
        return $this->name === 'action';
    }
}
