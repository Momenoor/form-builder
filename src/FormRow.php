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
     * Field options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */

    protected $fields;
    /**
     *
     * @var string
     */

    protected $wrapper = [];

    public function __construct(
        protected string $name,
        array $options,
        protected FormHelper $formHelper,
        protected Form $parent,
        protected $template = ''
    ) {
        $this->template = $this->formHelper->getConfig('row');
        $this->options = $this->formHelper->mergeOptions($options, $this->allDefaults());
        $this->appendOptions();
    }

    private function appendOptions()
    {
        $options = $this->options;
        foreach ($options as $key => $option) {

            if (!strpos($key, '_append')) {

                continue;
            }

            $this->removeOption($key);
            $key = str_replace('_append', '', $key);

            if (!key_exists($key, $this->options)) {
                continue;
            }

            $newOption = $this->getOption($key);
            $this->removeOption($key);

            if (is_array($newOption)) {
                array_push($newOption, $option);
            }

            if (is_string($newOption)) {
                $newOption .= ' ' . $option;
            }

            $this->setOption($key, $newOption);
        }
    }
    public function addToFields($key, $field)
    {
        $this->fields[$key] = $field;
    }

    public function addField($name, $type = 'text', array $options = [], $modify = false, $noOveride = false)
    {
        /* if (key_exists('col',$options)) {
            $options['wrapper'] = ['class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-' . $options['col'] . ' ' . (($options['wrapper']['class']) ?? '')];
        } */
        $this->parent->add($name, $type, $options, $modify, $noOveride, $this->name);

        return $this;
    }

    public function addWrapper($tag = 'div', $options = [])
    {
        $this->wrapper['start'] = '<' . $tag . ' ' . $this->formHelper->prepareAttributes($options) . '>';
        $this->wrapper['end'] = '</' . $tag . '>';
    }

    public function render($options = [])
    {
        $showWrapper = false;
        $this->rendered = true;
        $this->prepareOptions($options);
        if (!empty($this->wrapper)) {
            $showWrapper = true;
        }
        return  $this->formHelper->getView()
            ->make(
                $this->getTemplate(),
                [
                    'attributes' => $this->getOption('attr'),
                    'fields'     => $this->fields,
                    'showFields' => true,
                    'showWrapper' => $showWrapper,
                    'wrapper' => $this->wrapper,
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

    private function prepareOptions($options = []): void
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

    public function removeClass(string $className = 'row')
    {
        $class = $this->getOption('class');

        if (is_array($class)) {
            foreach ($class as $key => $value) {
                if ($value == $className) {
                    unset($class[$key]);
                }
            }
        }
        if (is_string($class)) {

            $class = str_replace($className, '', $class);
        }
        $this->setOption('class', $class);
    }
}
