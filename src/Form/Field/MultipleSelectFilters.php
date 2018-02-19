<?php

namespace Encore\Admin\Form\Field;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Encore\Admin\Admin;

class MultipleSelectFilters extends Select
{
    /**
     * Other key for many-to-many relation.
     *
     * @var string
     */
    protected $otherKey;

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
        $relations = array_get($data, $this->column);

        if (is_string($relations)) {
            $this->value = explode(',', $relations);
        }

        if (is_array($relations)) {
            if (is_string(current($relations))) {
                $this->value = $relations;
            } else {
                foreach ($relations as $relation) {
                    $this->value[] = array_get($relation, "pivot.{$this->getOtherKey()}");
                }
            }
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
        $this->options = $options;
        return $this;
    }

    public function prepare_data($data){

        $result = array();
        foreach ($data as $item){
            if(isset($result[$item->filter_group_id])){
                $result[$item->filter_group_id]['filters'][] = $item;
            }else{
                $result[$item->filter_group_id]['info'] = $item->filter_group()->first();
                $result[$item->filter_group_id]['filters'][] = $item;
            }
        }
        return $result;
    }

    public function render()
    {
        if (empty($this->script)) {
            $this->script = "$('{$this->getElementClassSelector()}').iCheck({checkboxClass:'icheckbox_minimal-blue'});";        }
        Admin::script($this->script);
        $data = $this->prepare_data($this->options);

        return view($this->getView(), $this->variables())->with(['options' => $this->options,'data'=>$data]);
    }
}
