<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

    <div class="col-sm-12">

        @include('admin::form.error')
        <?php

//dd($inline);
        ?>
        @foreach($options as $type => $data)
            @if($rate_type != 0 && $type != $rate_type)
                @php continue; @endphp
            @endif
            <div class="col-sm-12">
                <hr/>
                <label class="checkbox-inline">
                    &nbsp;@lang('admin::lang.rate_type_'.$type)
                </label>
                <hr/>
            </div>
            @foreach($data as $option => $label)
                <div class="col-sm-2">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="{{$name}}[]" value="{{$option}}" class="{{$class}}" {{ in_array($option, $value)?'checked':'' }} {!! $attributes !!} />&nbsp;{{$label}}&nbsp;&nbsp;
                    </label>
              </div>
            @endforeach
        @endforeach
        <?php


        ?>
        <input type="hidden" name="{{$name}}[]">
        @include('admin::form.help-block')

    </div>
</div>
