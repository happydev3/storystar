@extends('app.layout.page')
@section('bodyContent')




    <div class="container">
        <div class="row">


            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <form id="storiesSearchFrm" action="{{route("app-fav-stories")}}" role="search">
                        <input type="hidden" name="sortby" id="sortby" value=""/>
                        <input type="submit" style="display: none"/>
                        <div class="author-middle-bg">
                            <div class="clearfix"></div>
                            @include('app.components.notification-messages')
                            <h1 class="text-xs-center author-heading text-uppercase author-heading-fav">My Favorite Stories</h1>
                            {{ $paginator->appends($pageData['queryString'])->render("app.components.pagination",["position"=>"top",'pageData'=>$pageData])}}
                            @include("app.components.fav-story",['callFrom'=>'favStories'])
                            {{ $paginator->appends($pageData['queryString'])->render("app.components.pagination",["position"=>"bottom",'pageData'=>$pageData])}}

                        </div>
                    </form>

                    <div class="clearfix"></div>
                    <div class="star-border-box"><span class="star-border"></span></div>
                    @if(!@Auth::user()->is_premium)
                    <div class="ad-section">
                        <div class="ads-box" style="margin-bottom: 10px;">
                                <a href="{{ url('/premium-membership') }}" class="disappear-ads" id="disappear-ads">Want to make ALL the advertising disappear?</a>
                        </div>
                        <div class="ad text-center">
                            <?php
                            $googleAds = App\Models\Ads::where("page_name", "=", "stories")->first();
                            ?>
                            @if(!@Auth::user()->is_premium)
                                {!! $googleAds->ads_code !!}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @include('app.components.footer')


        </div>


    </div>



@endsection
