<?php

class StaticLabelTest extends FormTestCase {

    public function testYesNoArray()
    {
        $result = \Momenoor\FormBuilder\Helpers\StaticLabel::yesNo();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey(\Momenoor\FormBuilder\Helpers\StaticLabel::STATUS_OFFLINE, $result);
        $this->assertArrayHasKey(\Momenoor\FormBuilder\Helpers\StaticLabel::STATUS_ONLINE, $result);
    }

    public function testYes()
    {
        $result = \Momenoor\FormBuilder\Helpers\StaticLabel::yesNo(\Momenoor\FormBuilder\Helpers\StaticLabel::STATUS_ONLINE);

        $this->assertTrue(is_string($result));
        $this->assertEquals($this->app['translator']->trans('form-builder::form.yes'), $result);
    }

    public function testNa()
    {
        $result = \Momenoor\FormBuilder\Helpers\StaticLabel::yesNo(- 1);

        $this->assertTrue(is_string($result));
        $this->assertEquals($this->app['translator']->trans('form-builder::form.na'), $result);
    }
}
