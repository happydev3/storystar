@extends('app.layout.page')
@section('bodyContent')
    <style>
        .publishstory-boxes .c_note {
            float: left;
            font-size: 17px !important;
            font-family: Oxygen-Regular !important;
            padding-bottom: 25px !important;
            font-weight: 600;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    @if (!$novel)
                        <div class="author-middle-bg publishstory_bg">
                            <h1 class="text-xs-center author-heading text-uppercase">THANK YOU!</h1>
                            <p style="color: #fff;
    background: #00000040;
    padding: 10px;
    font-size: 18px;
    text-align: center;">Congratulations, you have just become Storystars newest published author.
                                <br>Your story can be found at the top of the 'Read Stories' page or by searching
                                under the theme and subject categories you selected. Please see your new My
                                Storystar author profile and update it with whatever information you would
                                like your readers to know about you.<br><br>Thank you for sharing your story with us.
                            </p>
                        </div>
                    @else
                        <div class="author-middle-bg publishstory_bg">
                            <h1 class="text-xs-center author-heading text-uppercase">THANK YOU!</h1>
                            <p style="color: #fff;
    background: #00000040;
    padding: 10px;
    font-size: 18px;
    text-align: center;">Congratulations, you have just become Storystars newest published author.
                                <br>Your novel can be found at the top of the 'Read Stories' page or by
                                searching under the theme and subject categories you selected.
                                Please see your new My Storystar author profile and update it with
                                whatever information you would like your readers to know about you. <br><br>
                                Thank you for sharing your novel with us.</p>
                        </div>
                    @endif


                </div>
                <div class="clearfix"></div>
                <div class="star-border-box"><span class="star-border"></span></div>
                <div class="ad-section">
                    <div class="ad text-center">

                        <?php
                        $googleAds = App\Models\Ads::where("page_name", "=", "publish story")->first();
                        // echo $googleAds->ads_code;
                        ?>
                        @if(!@Auth::user()->is_premium)
                            {!! $googleAds->ads_code !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include("app.components.footer")
    </div>
    </div>


@endsection