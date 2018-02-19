<?php

namespace Encore\Admin\Form\Field;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Encore\Admin\Admin;

class CheckboxRegionTree extends Select
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

        $_regions = array_get($data, 'regions');
        $_cities = array_get($data, 'cities');

        if (is_array($_regions)) {
            foreach ($_regions as $relation) {
                $this->value['regions'][$relation['id']] = $relation['id'];
            }
        }else{
            $this->value['regions'] = array();
        }


        if (is_array($_cities)) {
            foreach ($_cities as $relation) {
                $this->value['cities'][$relation['id']] = $relation['id'];
            }
        }else{
            $this->value['cities'] = array();
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
            $result[$item->id]['info'] = $item;
            $result[$item->id]['cities'] = $item->cities()->where('list_active','=',1)->orderBy('title')->get();
        }

        return $result;
    }

    public function render()
    {

        $this->script = "$('.regions').iCheck({checkboxClass:'icheckbox_minimal-blue'});";
        $this->script .= "$('.cities').iCheck({checkboxClass:'icheckbox_minimal-blue'});";
        Admin::script($this->script);
        $data = $this->prepare_data($this->options);

        return view($this->getView(), $this->variables())->with(['options' => $this->options,'data'=>$data]);
    }
}
