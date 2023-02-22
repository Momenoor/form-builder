<?php
namespace Momenoor\FormBuilder;

use Kris\LaravelFormBuilder\FormHelper;
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
    protected $template;

    public function __construct(
        protected $name,
        protected $options = [],
        protected FormHelper $formHelper,
        protected FormValidator $parent,
    )
    {

    }

    public function addField($name, $columnSize, $options){

    }

    public function render($options = [], $showColumns = true, )
    {
        if ($showColumns) {
            $this->rendered = true;
        }

        $this->prepareOptions($options);


    }

    private function allDefaults()
    {
        return [
            'class' => 'col',
            'name' => null,
        ];
    }

    private function prepareOptions($options = [])
    {

        $this->options = $this->formHelper->mergeOptions($options, $this->allDefaults());

        $columns = $this->getOption('columns', $this->options);
        $this->removeOption('columns');
        dd($columns);
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

}
