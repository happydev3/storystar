@extends( 'app.layout.page' )
@section( 'bodyContent' )

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg" style="padding-bottom: 35px;">
                        <div about-us>
                            <a name="profile"></a>

                            <div class="ad-section" style="padding-bottom: 0px !important;padding-top: 0px !important">
                                <div class="ad text-center" style="padding-bottom: 25px !important;padding-top: 25px !important;">

                                    <?php
                                    $googleAds = App\Models\Ads::where("page_name", "=", "contests")->first();
                                    ?>
                                    @if(!@Auth::user()->is_premium)
                                        {!! $googleAds->ads_code !!}
                                    @endif
                                </div>
                            </div>

                            <h1 class="text-xs-center author-heading" style="margin-bottom: 25px">Subscription Service</h1>

                            <div class="author-profile-box contest-list-page" style="padding: 30px 60px 10px 60px;">
                                <?php
                                $Data = App\Models\Content::find(4);
                                ?>
                                {!! $Data->content !!}
                            </div>


                            <div class="clearfix"></div>
                        </div>
                    </div>


                    <!--author-middle-bg-->
                </div>

            </div>
            @include("app.components.footer")
        </div>
    </div>
@endsection

@push('meta-data')
    {{--<meta name="description" content="Short Story Contests - Your short story submissions to our short story contests may win you cash, prizes, and Storystar front page STARDOM!"/>--}}
    <meta name="keywords" content="short story writing contest,short story,short stories,enter short story contest,
short story writing competition,free short story writing contest,short story competition,short story contest,writing
contest,writing competition,free writing contest,free writing competition,creative writing contest,creative writing
competition,submit short story,submit short stories,tell your story,tell your short story."/>
    <meta name="distribution" content="global"/>
    <meta name="robots" content="index,follow"/>
    <meta name="language" content="en, gb"/>
@endpush

@push('js-first')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-70090680-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag()
        gtag('js', new Date());

        gtag('config', 'UA-70090680-2');
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-70090680-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag()
        gtag('js', new Date());

        gtag('config', 'UA-70090680-2');
    </script>
@endpush