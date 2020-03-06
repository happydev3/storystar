<div id="ribbon">

    <ol class="breadcrumb">
        <li><a href="{{URL::to('/story-admin/')}}"><i class="fa fa-lg fa-fw fa-home"></i> Home</a></li>

        <li>{{$pageData['MainNav'] or ''}}</li>
        @if($pageData['SubNav']!='')
            <li>{{$pageData['SubNav']}}</li>
        @endif
    </ol>

    {{--<span class="ribbon-button-alignment pull-right">--}}
    {{--<span id="add" class="btn btn-ribbon hidden-xs" data-title="add">--}}
    {{--<i class="fa fa-plus"></i>--}}
    {{--Add New--}}
    {{--</span>--}}
    {{--</span>--}}
</div>
