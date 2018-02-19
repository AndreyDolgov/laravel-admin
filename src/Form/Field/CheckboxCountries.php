<?php

namespace Encore\Admin\Form\Field;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Encore\Admin\Admin;

class CheckboxCountries extends Select
{
    /**
     * Other key for many-to-many relation.
     *
     * @var string
     */
    protected $otherKey;

    protected $value = array();

    protected $rate_type = 0;

    /**
     * Get other key for this many-to-many relation.
     *
     * @throws \Exception
     *
     * @return string
     */

    protected function getOtherKey()
    {
        if ($this->otherKey) {
            return $this->otherKey;
        }

        if (method_exists($this->form->model(), $this->column) &&
            ($relation = $this->form->model()->{$this->column}()) instanceof BelongsToMany
        ) {
            /* @var BelongsToMany $relation */
            $fullKey = $relation->getOtherKey();

            return $this->otherKey = substr($fullKey, strpos($fullKey, '.') + 1);
        }

        throw new \Exception('Column of this field must be a `BelongsToMany` relation.');
    }

    public function fill($data)
    {
        $this->rate_type = $data['rate_type_id'];
        $_countries = array_get($data, 'countries');

        if (is_array($_countries)) {
            foreach ($_countries as $relation) {
                $this->value[$relation['pivot']['roaming_country_id']] = $relation['pivot']['roaming_country_id'];
            }
        }else{
            $this->value = array();
        }

    }

    public function setOriginal($data)
    {
        $relations = array_get($data, $this->column);

        if (is_string($relations)) {
            $this->original = explode(',', $relations);
        }

        if (is_array($relations)) {
            if (is_string(current($relations))) {
                $this->original = $relations;
            } else {
                foreach ($relations as $relation) {
                    $this->original[] = array_get($relation, "pivot.{$this->getOtherKey()}");
                }
            }
        }
    }

    public function prepare(array $value)
    {
        return array_filter($value);
    }


    public function options($options = [])
    {


        foreach ($options as $item){
            $_options[$item->rate_type_id][$item->id] = $item->title;
        }
        $this->options = $_options;
        return $this;
    }

    public function render()
    {

        $this->script = "$('.regions').iCheck({checkboxClass:'icheckbox_minimal-blue'});";
        $this->script .= "$('.cities').iCheck({checkboxClass:'icheckbox_minimal-blue'});";
        Admin::script($this->script);


        return view($this->getView(), $this->variables())->with(['options' => $this->options])->with(['rate_type'=>$this->rate_type]);
    }
}
