@extends('app.layout.page')
@section('bodyContent')


    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <h1 class="text-xs-center author-heading text-uppercase">Subscription</h1>
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">

                                <br/>
                                <br/>
                                <br/>
                                <h1 class="story-info-title" style="border-bottom:none;">
                                   You
                                    ({{$request->email}}) have successfully unsubscribed to our newsletter.
                                </h1>
                                <div class="clearfix"></div>

                                <br/>
                                <br/>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('app.components.footer')
        </div>
    </div>


@endsection
