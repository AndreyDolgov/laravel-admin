@php
    $html = function($options,$name,$class,$value) use (&$html) {;
        $_html = '';
        foreach($options as $item):
            $_checked = (is_array($value) && in_array($item["item"]->id,$value)) ?'checked':'';
            if(isset($item['sub'])):
                $_html.= '
                <li class=dd-item"">
                   <div class="dd-handle">
                        <label for "'. $name .'_'. $item["item"]->id .'">
                             <input id="'. $name .'_'. $item["item"]->id .'" type="checkbox" name="'. $name .'[]" value="'. $item["item"]->id .'" class="'. $class .'" '. $_checked .'/>
                             <strong> '. $item["item"]->title .'</strong>
                        </label>
                    </div>
                      <ol class="dd-list">
                            '. $html($item['sub'],$name,$class,$value) .'
                      </ol>
                </li>
               ';
            else:
               $_html.= '
                <li class=dd-item"">
                    <div class="dd-handle">
                        <label for "'. $name .'_'. $item["item"]->id .'">
                             <input id="'. $name .'_'. $item["item"]->id .'" type="checkbox" name="'. $name .'[]" value="'. $item["item"]->id .'" class="'. $class .'" '. $_checked .'/>
                             <strong> '. $item["item"]->title .'</strong>
                        </label>
                    </div>
                </li>
               ';
            endif;
        endforeach;
        return $_html;
    };
@endphp

<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">
    <div class="col-sm-12">
        @include('admin::form.error')
        <div class="dd">
            <ol class="dd-list">
                {!! $html($options,$name,$class,$value) !!}
            </ol>
        </div>
        @include('admin::form.help-block')
    </div>
</div>
