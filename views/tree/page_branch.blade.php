
@php $parent_alias =(isset($branch['parent_alias']))?$branch['parent_alias']:''; @endphp


<li class="dd-item" data-id="{{ $branch[$keyName] }}">
    <div class="dd-handle">
        @if($branch['released'] == 1)
            {!! $branchCallback($branch) !!}
        @else
            <span style="color:grey">{!! $branchCallback($branch) !!}</span>
        @endif

        &nbsp;&nbsp;&nbsp;<a href="{{url($parent_alias.$branch['alias'])}}" class="dd-nodrag" target="_blank">{{url($parent_alias.$branch['alias'])}}</a>
        <span class="pull-right dd-nodrag">
            <a href="/{{ $path }}/{{ $branch[$keyName] }}/edit"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-id="{{ $branch[$keyName] }}" class="tree_branch_delete"><i class="fa fa-trash"></i></a>
        </span>

    </div>
    @if(isset($branch['children']))
        @php $parent_alias =($parent_alias == '')?$branch['alias'] .'/':$parent_alias . $branch['alias'] .'/'; @endphp
        <ol class="dd-list">
            @foreach($branch['children'] as $branch)
                @php $branch['parent_alias'] =  $parent_alias; @endphp
                @include($branchView, $branch)
            @endforeach
        </ol>
    @endif
</li>