<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

    <div class="col-sm-12">

        @include('admin::form.error')

        @foreach($data as $group)

            <?php
//        var_dump($column);
//        var_dump($value);

        ?>
            <div class ="row">
                <div class="col-sm-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="regions[]" value="{{$group['info']->id}}" class="regions" {{  isset($value['regions'][$group['info']->id]) ?'checked':'' }}  {!! $attributes !!} />&nbsp;<strong>{{$group['info']->title}}</strong>
                    </label>
                </div>
                @foreach($group['cities'] as $item)
                    <div class="col-sm-2">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="cities[]" value="{{$item->id}}" class="cities" {{  isset($value['cities'][$item->id]) ?'checked':'' }}  {!! $attributes !!} />&nbsp;{{$item->title}}
                        </label>
                    </div>
                @endforeach
            </div>
            <hr/>
        @endforeach
        <input type="hidden" name="regions[]" />
        <input type="hidden" name="cities[]" />
        @include('admin::form.help-block')

    </div>
</div>
