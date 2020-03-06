@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-table fa-fw "></i>
                    Templates list
                </h1>
            </div>
        </div>

        <section id="widget-grid" class="">
            <div class="row">
                <div class="card-container">
                    @if (isset($templates))
                        @foreach($templates as $template)
                            <div class="card-wrapper">
                                <span>{{$template['Name']}}</span>
                                <form action="delete/{{$template['Name']}}" method="POST">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
                                    <div class="card-wrapper-icon"><i class="fa fa-trash-o"></i></div>
                                </form>
                                <a href="{{route('admin.email.show',['name'=>$template['Name']])}}"><div class="card-wrapper-icon"><i class="fa fa-eye"></i></div></a>
                            </div>
                        @endforeach
                    @else
                        <h2>You don't have any template on Amazon servers!</h2>
                    @endif
                </div>

            </div>
        </section>
    </div>
    <script>
        $('.fa-trash-o').parent().click(function () {
            if (confirm('Are you sure you want to delete this template from Amazon server?')) {
                $(this).parent().submit();
            } else {
            }
        });
        // $(document).ready(function() {
        //     console.log('adfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf');
        //     window.open('https://www.storystar.com/deleteBounceEmail');            
        // });
    </script>
@stop
