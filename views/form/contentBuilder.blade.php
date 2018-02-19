<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-{{$width['label']}} control-label">{{$label}}</label>

    <div class="col-sm-{{$width['field']}}">

        @include('admin::form.error')

        <input type="hidden" name="{{$name}}" value=" {{$value }}"  id="field{{$area_id}}">
        <div id = "{{$area_id}}" class="is-container container">

            @if($value)
               {!! $value !!}
            @endif

        </div>
        @include('admin::form.help-block')

    </div>
</div>
