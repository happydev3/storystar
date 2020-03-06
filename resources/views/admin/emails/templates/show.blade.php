@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-envelope-o fa-fw "></i>
                    E-mail preview
                </h1>
            </div>
        </div>

        <div style="margin: 10px;border: solid;">
            {!! $HTML !!}
        </div>
    </div>
@stop