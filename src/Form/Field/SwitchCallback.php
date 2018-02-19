<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class SwitchCallback extends Field
{
    protected static $css = [
        '/packages/admin/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
    ];

    protected static $js = [
        '/packages/admin/bootstrap-switch/dist/js/bootstrap-switch.min.js',
    ];

    protected $states = [
        'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'default'],
    ];

    protected $callback = false;

    public function setCallback($callback){
        $this->callback = $callback;
    }

    public function states($states = [])
    {
        foreach (array_dot($states) as $key => $state) {
            array_set($this->states, $key, $state);
        }

        return $this;
    }

    public function prepare($value)
    {
        if (isset($this->states[$value])) {
            return $this->states[$value]['value'];
        }

        return $value;
    }

    public function render()
    {
        foreach ($this->states as $state => $option) {
            if ($this->value() == $option['value']) {
                $this->value = $state;
                break;
            }
        }
        $_name = $this->elementName ?: $this->formatName($this->column);
        $callback = ($this->callback == false)?'':$this->callback .'(event, state);';
        $this->script = <<<EOT

$('[name="{$_name}"].la_checkbox').bootstrapSwitch({
    size:'small',
    onText: '{$this->states['on']['text']}',
    offText: '{$this->states['off']['text']}',
    onColor: '{$this->states['on']['color']}',
    offColor: '{$this->states['off']['color']}',
    onSwitchChange: function(event, state) {
        $('[name="{$_name}"]').val(state ? 'on' : 'off');
        {$callback}
    }
});

EOT;

        return parent::render();
    }
}