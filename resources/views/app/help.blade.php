@extends( 'app.layout.page' )
@section( 'bodyContent' )

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <div about-us>
                            <a name="profile"></a>
                            <div class="ad-section" style="padding-bottom: 0px !important;padding-top: 0px !important">
                                <div class="ad text-center"
                                     style="padding-bottom: 25px !important;padding-top: 25px !important;">

                                    <?php
                                    $googleAds = App\Models\Ads::where("page_name", "=", "help top")->first();
                                    ?>
                                    @if(!@Auth::user()->is_premium)
                                        {!! $googleAds->ads_code !!}
                                    @endif
                                </div>
                            </div>


                            <h1 class="text-xs-center author-heading">PREMIUM MEMBER BENEFITS</h1>
                            <!-- contribute -->
                            <div class="contribute author-profile-box">
                                <p class="author-top-content custom" style="font-weight: 600;">Storystar will always remain <b>FREE</b> for everyone, so writers around the world can freely share their stories and readers of the world can freely enjoy them. But now... you can enjoy the Storystar experience more than ever, with the rewards of <b style="font-weight: 700;"><span style="color:#6d29cc; font-weight: 600;">PREMIUM MEMBER</span> BENEFITS</b>.</p>
                                <div class="text-box">
                                    <span class="premium-members" style="font-weight: 700; color:#6d29cc;">PREMIUM MEMBERS</span><br>
                                <span class="will-enjoy">will enjoy</span><br>
                                <span class="full-year">one full year of</span><br>
                                <span class="advertising" style="font-weight: 600; color: forestgreen;">NO ADVERTISING</span><br>
                                <span class="plus">PLUS</span><br>
                                <span class="all">All</span><br>
                                <span class="premium-members-small">PREMIUM MEMBERS</span><br>
                                <span class="will-receive">Will receive 1,000 points (equal to $10.USD)</span><br>
                                <span class="publications">AND First Dibs on Limited Edition Storystar Publications!</span><br>
                                </div>
                                <p class="author-top-content custom" style="font-weight: 600;">That's right, become a <span style="color:#6d29cc; text-transform: uppercase; font-weight: 600;">Premium member</span>, and you will not see one single ad anywhere on Storystar whenever you are logged in. <b style="font-weight: 600; font-size: 20px;">Plus</b>, you'll get 1,000 rewards points that you can spend however you wish, including your premium membership renewal 
                                    next year, writing contest entry fees, and/or the cost of purchasing our upcoming publication, Storystar's <b>Brightest Stars</b>, featuring an exclusive selection of the <span style="font-weight: 700 !important; font-size: 20px;">best short stories in the world from the first ten years of Storystar!</span><br>
                                    <span style="color:#6d29cc; font-weight: 600; font-size: 20px;">PREMIUM MEMBERS</span> <span style="font-size: 20px;">will receive first dibs on all limited edition Storystar Publications, now and in the future...</span><br>
                                    Start enjoying the benefits of being a <span style="color:#6d29cc; text-transform: uppercase; font-weight: 600;">Premium member</span> today, and <span style="color:#6d29cc; text-transform: uppercase; font-weight: 600;">Join Now</span>!
                                </p>
                                <div class="col-md-12 p-0">
                                    <div class="col-md-3 mt-2 text-center" style="padding-right: 0px;">
										<!--Added by MT -->
										
										
										<!--End Added by MT -->
										<!--  onclick="window.open('https://www.paypal.me/storystar1')"-->
                                        <form style="display:none;" class="float-left"
                                              action="https://www.paypal.com/cgi-bin/webscr"
                                              method="post" target="_top">

                                            {{--<label for="" class="title-padding pr-1">$</label>--}}

                                            {{--<input name="amount" type="text" class="custom-input custom-select"--}}
                                            {{--style="background-color: white;width: 75%;"/>--}}

                                            <input type="hidden" name="cmd" value="_s-xclick">

                                            <input type="hidden" name="hosted_button_id" value="9MS6Y5SNRRL4A">
                                            <input type="image" 
                                                   src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif?akam_redir=1"
                                                   border="0"
                                                   name="submit" alt="PayPal - The safer, easier way to pay online!">
                                            <img alt="" border="0" src="" width="1" height="1">

                                            <input type="hidden" name="currency_code" value="USD">

                                            <input type="hidden" name="return"
                                                   value="http://www.storystar.org/php/thankyou.php">

                                            <input type="hidden" name="cancel_return" value="http://www.storystar.com">

                                            <br/>
                                            <br/>
                                            <a href="#"
                                               onclick="window.open('https://www.sitelock.com/verify.php?site=storystar.com','SiteLock','width=600,height=600,left=400,top=120');"><img
                                                        alt="website security" title="SiteLock"
                                                        src="//shield.sitelock.com/shield/storystar.com"
                                                        style="text-align: center"/></a>


                                        </form>


                                        <form class="float-left" style="display: none;"
                                              action="https://www.paypal.com/cgi-bin/webscr"
                                              method="post" target="_blank">

                                            <label for="" class="title-padding pr-1">$</label>

                                            <input name="amount" type="text" class="custom-input custom-select"
                                                   style="background-color: white;width: 75%; padding-bottom: "/>


                                            <input type="hidden" name="cmd" value="_xclick">

                                            <input type="hidden" name="business" value="artmarke@yahoo.com">

                                            <input type="hidden" name="item_name" value="storystar.org">


                                            <input type="hidden" name="no_note" value="1">

                                            <input type="hidden" name="currency_code" value="USD">

                                            <input type="hidden" name="return"
                                                   value="http://www.storystar.org/php/thankyou.php">

                                            <input type="hidden" name="rm" value="2">

                                            <input type="hidden" name="cancel_return" value="http://www.storystar.org">

                                            <input type="hidden" name="tax" value="0">


                                            <table width="100%" border="0" cellspacing="2" cellpadding="2">

                                                <tr>

                                                    <td height="17" colspan="3" align="left">

                                                    </td>
                                                </tr>

                                                <tr>

                                                    <td align="left" width="22" height="17"><img
                                                                src="../images/arrow_orange.gif" width="17" height="17"
                                                                align="bottom" vspace="5px;"></td>

                                                    <td align="center" style="padding-left:10px; width:100%; ">

                                                        <input type="image" class="paypal_button"
                                                               src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif"
                                                               border="0" name="submit"
                                                               alt="Make payments with PayPal - it's fast, free and secure!">&nbsp;&nbsp;&nbsp;&nbsp;


                                                        <br/>
                                                        <a href="#"
                                                           onclick="window.open('https://www.sitelock.com/verify.php?site=storystar.com','SiteLock','width=600,height=600,left=400,top=120');"><img
                                                                    alt="website security" title="SiteLock"
                                                                    src="//shield.sitelock.com/shield/storystar.com"
                                                                    style="text-align: center"/></a>


                                                    </td>


                                                    <td align="center" style="padding-left:10px; width:100%; ">
                                                        <script type="text/javascript"
                                                                src="https://trustseal.verisign.com/getseal?host_name=www.storystar.com&amp;size=S&amp;use_flash=NO&amp;use_transparent=NO&amp;lang=en"></script>
                                                        <br/>
                                                    </td>
                                                    <td align="right"><a href="/php/links.php">
                                                            <div class="links-box"></div>
                                                        </a>
                                                    </td>

                                                </tr>
                                            </table>

                                        </form>
                                    </div>
                                    <div class="col-md-4 offset-md-1 join-box">
                                        <P style="text-align: center; font-size: 18px; font-weight: 600;" class="join-heading"><span class="span-premium">Premium Member</span><br>
                                        Benefits all year long for just $12.USD</p>
                                        <div class="join-now"><a target="blank" href="https://www.paypal.me/storystar1" class="join-now-text">Join Now!</a><br><a href="https://www.paypal.me/storystar1" target="blank"><img style="margin-top:10px; padding-top: 10px; padding-bottom: 10px; background-color:lightblue;" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif?akam_redir=1"/></a></a></div>
                                    </div>
                                    <div class="col-md-3 sitelock" style="text-align: center;">
                                        <a href="#"
										   onclick="window.open('https://www.sitelock.com/verify.php?site=storystar.com','SiteLock','width=600,height=600,left=400,top=120');"><img
													alt="website security" title="SiteLock"
													src="//shield.sitelock.com/shield/storystar.com"
													style="text-align: center"/></a>
										<p class="pt-1"><a href="http://www.verisign.com/verisign-trust-seal"
                                                           style="color: #000000;text-decoration: none;font: bold 7px verdana,sans-serif;letter-spacing: .5px;text-align: center;margin: 0px; padding: 0px;">ABOUT
                                                TRUST ONLINE</a></p>
                                    </div>
                                    <div class="col-md-12" style="text-align: center;">
                                        <p class="address-heading">You are also welcome to snail mail your contributions to us at:</p>

                                        <address>
                                            <b>STORYSTAR.com</b><br>
                                            P.O. Box 157,<br>
                                            Florence, OR 97439. <br>
                                            Thank you very much. <br>
                                        </address>
                                    </div>
                                </div>
                                <div class="row" style="margin-left: 10%; width: 80%;">
                                    <div class="col-md-12" style="border-bottom: 1px solid; border-top: 1px solid #07588d; padding: 10px;">
                                        <div class="col-md-5">
                                            <a class="link-box" href="{{route("app-publish-story")}}">Tell Your Story Now</a>
                                        </div>
                                        <div class="col-md-7">
                                            <a class="link-box" href="{{route("app-main")}}#star-of-week">Read This Week's Featured Stories</a>
                                        </div>
                                    </div>  
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="star-border-box"><span class="star-border"></span></div>
                            @if(!@Auth::user()->is_premium)
                            <div class="ad-section">
                                <div class="ad text-center"
                                     style="padding-bottom: 5px !important;padding-top:5px !important;">

                                    <?php
                                    $googleAds = App\Models\Ads::where("page_name", "=", "help bottom")->first();
                                    ?>
                                    @if(!@Auth::user()->is_premium)
                                        {!! $googleAds->ads_code !!}
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>


                    </div>
                    <!--author-middle-bg-->
                </div>

            </div>
            @include("app.components.footer")
        </div>
    </div>
@endsection
