@extends( 'app.layout.page' )
@section( 'bodyContent' )

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <div class="text-center hidden">
                            <img src="http://185.56.85.247/~dynamolo/storystar/assets/app/images/4041.png" alt="image 4041">
                        </div>

                        <!-- contribute -->
                        <div class="contribute author-profile-box hidden">
                            <h1 class="story-info-title">HELP US KEEP STORYSTAR FREE FOR EVERYONE</h1>
                            <p class="author-top-content">You can help us keep storystar free for everyone by doing any
                                of the following three things:</p>
                            <ol style="list-style: decimal;" class="pb-1 author-top-content pt-0">
                                <li>
                                    1. Make a donation.
                                </li>
                                <li>
                                    2. Volunteer
                                </li>
                                <li>
                                    3. Click on and make a purchase from any of our sponsoring advertisers on this page.
                                </li>
                            </ol>
                            <h1 class="story-info-title">DONATIONS MAY BE MADE VIA PAYPAL OR SNAIL MAIL</h1>
                            <p class="author-top-content">Donations may be made online via Paypal using the link
                                provided below. We are Paypal registered and verified. Please Enter an amount greater
                                than $1.00 and click the Paypal donation button below. Thank you.</p>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 mt-2 text-center">
                                    <form action="" class="float-left">
                                        <label for="" class="title-padding pr-2">$</label>
                                        <input type="text" class="custom-input custom-select"
                                               style="background-color: white;width: 75%;">
                                    </form>
                                    <img class="pt-1"
                                         src="http://185.56.85.247/~dynamolo/storystar/assets/app/images/paypal.gif"
                                         alt="paypal">
                                    <p class="pt-1"><a href=""
                                                       style="color: #000000;text-decoration: none;font: bold 7px verdana,sans-serif;letter-spacing: .5px;text-align: center;margin: 0px; padding: 0px;">ABOUT
                                            TRUST ONLINE</a></p>
                                </div>
                                <div class="col-md-6 theclassic-box novel-bg-box p-0">
                                    <a href="http://185.56.85.247/~dynamolo/storystar/story-subject/164/novel-serial-series"
                                       class="theclassic-box1 novel-bg-box1 p-2">

                                        <h2 class="the-classic-title">
                                            click here for related links
                                        </h2>
                                        <p class="short-title">you may also be interested in these other reading and
                                            writing websites</p>
                                    </a>
                                </div>
                            </div>

                            <p class="author-top-content">You are also welcome to snail mail your donations to us
                                at:</p>

                            <address>
                                <b><a href="">STORYSTAR.com</a></b><br>
                                P.O. Box 157,<br>
                                Florence, OR 97439. <br>
                                Thank you very much. <br>
                            </address>
                            <h1 class="story-info-title">VOLUNTEER AT STORYSTAR</h1>
                            <p class="author-top-content">Volunteers are needed to help us read and screen all the
                                stories that are submitted to this site. If you would like to volunteer for this
                                mission, please send us an email indicating your interest and which subject or theme
                                categories you would like to concentrate your efforts on. Thank you.</p>
                            <h1 class="story-info-title">CHECK OUT OUR SPONSORS:</h1>
                            <h2 class="story-info-title"><a href="">Tell Your Story Now</a></h1>
                                <h2 class="story-info-title pt-1"><a href="">Read This Months Featured Stories</a></h1>
                                    <div class="clearfix"></div>
                        </div>
                        <!-- contribute -->

                        <div about-us class="">
                            <a name="profile"></a>
                            <h1 class="text-xs-center author-heading">About Us</h1>
                            <div class="author-profile-box">
                                <p class="author-top-content">
                                   Storystar is a totally FREE short stories site featuring some of the best short stories online, written by/for kids, teens, and adults of all ages around the world, where short story writers are the stars, and everyone is free to shine! Storystar is dedicated to providing a free place where everyone can share their stories. Stories can entertain us, enlighten us, and change us. Our lives are full of stories; stories of joy and sorrow, triumph and tragedy, success and failure. The stories of our lives matter. Share them. Sharing stories with each other can bring us closer together and help us get to know one another better. Please invite your friends and family to visit Storystar to read, rate and share all the short stories that have been published here, and to tell their stories too.
                                </p>
                                <p class="author-top-content pt-0">StoryStar headquarters are located on the central
                                    Oregon coast. </p>
                                <address>
                                    <b>
                                        Storystar <br>
                                        POB 157 <br>
                                        Florence, OR 97439 <br>
                                    </b>
                                </address>
                                
                                <h1 class="story-info-title" style="border: none;">
                                    <a href="{{route("app-contact")}}">Contact / Suggestion Box</a>
                                </h1>
                                <p class="author-top-content"></p>
                                <p style="display:none;" class="author-top-content">We are happy to hear your Storystar
                                    related questions, comments, and suggestions. Please note that for security reasons
                                    we accept comments and suggestions from registered users only. If you would like to
                                    contact us please
                                    <a href="{{route("app-contact")}}" class="text-primary">Login</a>. If you are not
                                    yet registered with us then you may register as an author by publishing your story
                                    on our site, or you may register as a story rater/reader from the ‘rate story’ link
                                    found at the bottom of all the stories posted on the site. Thank you.</p>
                            </div>
                        </div>
                        <!--about us-->
                        <div coming-soon class="hidden">
                            <img src="{{app_assets(" images/coming.png ")}}" class="img-fluid" alt="coming soon"/>
                        </div>
                        <!--coming soon-->
                        <div posting_instructions class="hidden">
                            <a name="profile"></a>
                            <h1 class="text-xs-center author-heading"> INSTRUCTIONS FOR USING OUR STORY POSTING
                                FORM</h1>
                            <div class="author-profile-box">
                                <p class="author-top-content">
                                    It is best not to write your story off the top of your head. We suggest you write
                                    your story on your own word processor, run it through your spell checker, reread it
                                    over several times for errors, and rewrite it until you and your best critic think
                                    it is perfect. Then you can copy/paste it into our Storystar story writing text box.
                                    But please do not paste anything into our story posting form except for just plain
                                    text with no html code, bolding, underlining, pictures, etc....
                                    <br><br> Remember that once you submit your story to this website it becomes a
                                    permanent published record of your writing skills at this moment in time. So please
                                    be sure you have given your story your best effort and that you are proud of it
                                    before you place it online for the world to read and judge.
                                    <br><br> Please note that we have a story size limit of 50,000 characters of text,
                                    or about 5,000 words. If you submit a story that is longer than that the end of your
                                    story will be cut off when you submit it.
                                    <br><br> You can find out whether your story fits into the form by pasting it in and
                                    then hitting the ENTER key on your keyboard. The Storystar character counter will
                                    then tell you how many characters of space you have left, if it is less than 50,000
                                    characters long. OR, it will cut off the end of your story that exceeds the length
                                    limit and show 0 characters remaining on the counter. Each letter, and each space
                                    between words, counts as one character. A big space between paragraphs, or a full
                                    line of blank space, counts as two characters. Our story window accepts up to 74
                                    characters per line, so your story can be a maximum of about 405 lines of text long.
                                    <br><br> Once you copy/paste your story into the text box please check to make sure
                                    it retained all the same spacing and punctuation you intended. If not, then adjust
                                    it accordingly before you submit it. The story will look exactly the same on the
                                    permanent web page as it does in the story writing box.
                                    <br><br> Please remember that R rated and racist stories and language are not
                                    accepted on Storystar. If you have used R rated language but your story is not R
                                    rated then you'll need to either replace the words or replace some of the letters
                                    with symbols.
                                    <br><br> If you have a story you want to publish that is too long you'll have to
                                    condense it and take out as many non-essential parts as possible. Remember that
                                    Storystar is for SHORT stories. Please check out our helpful tips on how to write a
                                    good short story.
                                    <br><br> Thanks for sharing your short stories with us!
                                </p>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <!--posting_instructions-->
                        <div favorite-authors class="hidden">
                            <h1 class="text-xs-center author-heading text-uppercase">Favorite Authors</h1>
                            <div class="pagination-boxes">
                                <div class="pagination-left">
                                    <div class="sort-wrap">
                                        Sort by
                                        <select class="styled hasCustomSelect" id="sort" name="sort"
                                                onchange="setSorting()"
                                                style="width: 156px; position: absolute; opacity: 0; height: 38px; font-size: 20px;">
                                            <option value="latest">Latest
                                            </option>
                                            <option value="oldest">Oldest
                                            </option>
                                        </select><span class="customSelect styled" style="display: inline-block;"><span
                                                    class="customSelectInner"
                                                    style="width: 195px; display: inline-block;">Latest
                        </span></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="pagination-middle">
                                    <ul class="">
                                        <li class="arrow-bg-pagin no-link">
                                            <a href="javascript:void(0)">
                                                <img src="http://185.56.85.247/~dynamolo/storystar/assets/app/images/arrow-icon-pagin.png"
                                                     alt="arrow icon" class="loading" data-was-processed="true">
                                            </a>


                                        </li>
                                        <li class="active"><span>1</span>
                                        </li>
                                        <li><a href="http://185.56.85.247/~dynamolo/storystar/stories?page=2">2</a>
                                        </li>
                                        <li><a href="http://185.56.85.247/~dynamolo/storystar/stories?page=3">3</a>
                                        </li>
                                        <li><a href="http://185.56.85.247/~dynamolo/storystar/stories?page=4">4</a>
                                        </li>

                                        <li class="background-remove disabled">
                                            <a href="javascript:void(0)">
                                                ...
                                            </a>


                                        </li>
                                        <li><a href="http://185.56.85.247/~dynamolo/storystar/stories?page=674">674</a>
                                        </li>
                                        <li><a href="http://185.56.85.247/~dynamolo/storystar/stories?page=675">675</a>
                                        </li>
                                        <li class="arrow-bg-pagin last-arrow-change">
                                            <a href="http://185.56.85.247/~dynamolo/storystar/stories?page=2"
                                               rel="next">
                                                <img src="http://185.56.85.247/~dynamolo/storystar/assets/app/images/arrow-icon-pagin.png"
                                                     alt="loadin" class="loading" data-was-processed="true">
                                            </a>


                                        </li>
                                    </ul>
                                </div>
                                <div class="pagination-left pagination-right">
                                    <div class="sort-wrap">
                                        Jump to page
                                        <select class="styled hasCustomSelect" id="goto" onchange="goToPage($(this))"
                                                style="width: 100px; position: absolute; opacity: 0; height: 38px; font-size: 20px;">
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=50">
                                                50
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=100">
                                                100
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=150">
                                                150
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=200">
                                                200
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=250">
                                                250
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=300">
                                                300
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=350">
                                                350
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=400">
                                                400
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=450">
                                                450
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=500">
                                                500
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=550">
                                                550
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=600">
                                                600
                                            </option>
                                            <option value="http://185.56.85.247/~dynamolo/storystar/stories?page=650">
                                                650
                                            </option>
                                        </select><span class="customSelect styled" style="display: inline-block;"><span
                                                    class="customSelectInner"
                                                    style="width: 195px; display: inline-block;">50</span></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <!--pagination-boxes-->
                            <div class="author_list">
                                <div class="stories-box">

                                    <div class="col-md-12">
                                        <div class="author_img">
                                            <img src="{{app_assets(" images/1.png ")}}" class="img-fluid" alt="author details"/>
                                        </div>
                                        <div class="author_details">
                                            <div class="author-name">
                                                <label>Name</label>
                                                <span>KEVIN HUGHES</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Born</label>
                                                <span>1951</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Address</label>
                                                <span>Wilmington NC</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Country</label>
                                                <span>United States</span>
                                            </div>
                                        </div>
                                        <div class="author-heart-icon">
                                            <a href="#">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                                <div class="stories-box">

                                    <div class="col-md-12">
                                        <div class="author_img">
                                            <img src="{{app_assets(" images/1.png ")}}" class="img-fluid" alt="author img"/>
                                        </div>
                                        <div class="author_details">
                                            <div class="author-name">
                                                <label>Name</label>
                                                <span>KEVIN HUGHES</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Born</label>
                                                <span>1951</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Address</label>
                                                <span>Wilmington NC</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Country</label>
                                                <span>United States</span>
                                            </div>
                                        </div>
                                        <div class="author-heart-icon">
                                            <a href="#">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                                <div class="stories-box">

                                    <div class="col-md-12">
                                        <div class="author_img">
                                            <img src="{{app_assets(" images/1.png ")}}" class="img-fluid" alt="stories box"/>
                                        </div>
                                        <div class="author_details">
                                            <div class="author-name">
                                                <label>Name</label>
                                                <span>KEVIN HUGHES</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Born</label>
                                                <span>1951</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Address</label>
                                                <span>Wilmington NC</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Country</label>
                                                <span>United States</span>
                                            </div>
                                        </div>
                                        <div class="author-heart-icon">
                                            <a href="#">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                                <div class="stories-box">

                                    <div class="col-md-12">
                                        <div class="author_img">
                                            <img src="{{app_assets(" images/1.png ")}}" class="img-fluid" alt="assets"/>
                                        </div>
                                        <div class="author_details">
                                            <div class="author-name">
                                                <label>Name</label>
                                                <span>KEVIN HUGHES</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Born</label>
                                                <span>1951</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Address</label>
                                                <span>Wilmington NC</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Country</label>
                                                <span>United States</span>
                                            </div>
                                        </div>
                                        <div class="author-heart-icon">
                                            <a href="#">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                                <div class="stories-box">

                                    <div class="col-md-12">
                                        <div class="author_img">
                                            <img src="{{app_assets(" images/1.png ")}}" class="img-fluid" alt="author name 1"/>
                                        </div>
                                        <div class="author_details">
                                            <div class="author-name">
                                                <label>Name</label>
                                                <span>KEVIN HUGHES</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Born</label>
                                                <span>1951</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Address</label>
                                                <span>Wilmington NC</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Country</label>
                                                <span>United States</span>
                                            </div>
                                        </div>
                                        <div class="author-heart-icon">
                                            <a href="#">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                                <div class="stories-box">

                                    <div class="col-md-12">
                                        <div class="author_img">
                                            <img src="{{app_assets(" images/1.png ")}}" class="img-fluid" alt="author details 1"/>
                                        </div>
                                        <div class="author_details">
                                            <div class="author-name">
                                                <label>Name</label>
                                                <span>KEVIN HUGHES</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Born</label>
                                                <span>1951</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Address</label>
                                                <span>Wilmington NC</span>
                                            </div>
                                            <div class="author-name">
                                                <label>Country</label>
                                                <span>United States</span>
                                            </div>
                                        </div>
                                        <div class="author-heart-icon">
                                            <a href="#">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--author_list-->
                        </div>
                        <!--favorite-authors-->

                    </div>
                    <!--author-middle-bg-->
                </div>

            </div>
            @include("app.components.footer")
        </div>
    </div>
@endsection

@push('meta-data')
<meta name="description"
      content="Storystar is a free online library featuring the best short stories  to read online, by some of the best short story writers of all ages around the world."/>
<meta name="keywords" content="short story,short stories,write short story,write short stories,share short story,share short
stories,tell your story,tell your short story."/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/>
@endpush