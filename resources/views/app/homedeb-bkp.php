@extends( 'app.layout.page' )
@section( 'bodyContent' )


    <?php
    $scaledWidth = "";
    $scaledHeight = "";

    $dailyStoryStar = [];
    $dailyStoryStar = \App\ Models\ StoryStar::where("type", "=", "Day")->orderBy("storystar_id", "Desc")->first();
    $storyImg = isset($dailyStoryStar->story->image) && !empty($dailyStoryStar->story->image) ? $dailyStoryStar->story->image : '';

    $heightClass = "";

    ?>

    @if(isset($dailyStoryStar) && isset($dailyStoryStar->story))

        @if($storyImg)

            @if(file_exists(storage_path().'/story/'.$dailyStoryStar->story->image ))

                <?php
                $data = getimagesize(storage_path() . '/story/' . $dailyStoryStar->story->image);
                $imgWidth = $data[0];
                $imgHeight = $data[1];


                if ($imgWidth > 366 && $imgHeight > 286) {

                    $widthRatio = 366 / $imgWidth;
                    $heightRatio = 286 / $imgHeight;

                    // Ratio used for calculating new image dimensions.
                    $ratio = min($widthRatio, $heightRatio);

                    // Calculate new image dimensions.
                    $scaledWidth = (int)$imgWidth * $ratio;
                    $scaledHeight = (int)$imgHeight * $ratio;


                } else if ($imgWidth > 366 && $imgHeight < 286) {


                    $widthRatio = 366 / $imgWidth;
                    $heightRatio = 286 / $imgHeight;

                    // Ratio used for calculating new image dimensions.
                    $ratio = min($widthRatio, $heightRatio);

                    // Calculate new image dimensions.
                    $scaledWidth = (int)$imgWidth * $ratio;
                    $scaledHeight = (int)$imgHeight * $ratio;

                } else if ($imgWidth < 366 && $imgHeight > 286) {

                    $widthRatio = 366 / $imgWidth;
                    $heightRatio = 286 / $imgHeight;

                    // Ratio used for calculating new image dimensions.
                    $ratio = min($widthRatio, $heightRatio);

                    // Calculate new image dimensions.
                    $scaledWidth = (int)$imgWidth * $ratio;
                    $scaledHeight = (int)$imgHeight * $ratio;

                } else {

                    $widthRatio = 366 / $imgWidth;
                    $heightRatio = 286 / $imgHeight;

                    // Ratio used for calculating new image dimensions.
                    $ratio = min($widthRatio, $heightRatio);

                    // Calculate new image dimensions.
                    $scaledWidth = (int)$imgWidth * $ratio;
                    $scaledHeight = (int)$imgHeight * $ratio;

                }

                $scaledWidth = ceil($scaledWidth);
                $scaledHeight = ceil($scaledHeight);

                if ($scaledHeight <= 286) {
                    $heightClass = "heightClass";
                }
                ?>



            @endif



        @endif

        <div class="container">
            <div class="row">
                <div class="nav-boxes middle-top-border">
                    <div class="nav-boxes-inner middle-top-border-inner">
                        <div class="middle-welcome-section">
                            <div class="col-md-7 padding-remove">
                                <div class="middle-top-left-box text-xs-center <?=$heightClass;?>">

                                    <h2 class="story-frame-title ">STORY STAR OF THE DAY</h2>

                                    <div class="star-wrapper" id="star-wrapper">


                                        @push('js')
                                        <script type="text/javascript"
                                                src="{{app_assets('js/star-script.js')}}"></script>
                                        @endpush


                                    </div>


                                    @if($storyImg)
                                        <div class="sotd ">
                                            <img class="the-day-img"
                                                 src="{{Image::url(storage_url($dailyStoryStar->story->image, 'story'), $scaledWidth, $scaledHeight, array('crop'))}}"
                                                 alt="{{ucfirst($dailyStoryStar->story->story_title)}}">
                                        </div>

                                    @endif


                                    <div class="the-end-boxes">
                                        <div class="the-end-part">
                                            <p class="inthe-end">
                                                {{ucfirst(decodeStr($dailyStoryStar->story->story_title))}}
                                            </p>
                                            <p class="bymc-gill">
                                                By <span>
                                                    {{isset($dailyStoryStar->story->author_name)?ucfirst($dailyStoryStar->story->author_name):''}}
                                                </span>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-xs-center btn btn-readstory">
                                        <a href="{{route('app-story',['story_id'=>$dailyStoryStar->story_id])}}">
                                            Read Story
                                        </a>

                                    </div>
                                    @endif

                                </div>
                            </div>


                            <div class="col-md-5 middle-top-right">
                                <h2 class="welcome-title">Welcome to<img src="{{app_assets("images/welcome-logo.png")}}"
                                                                         alt="">
                                </h2>
                                <div class="totally-free-text">
                                    A Totally <span>FREE</span> site for
                                </div>
                                <p class=" totally-free-text writers-text">short story lovers of all ages where writers
                                    are
                                    the <span>STARS</span> and everyone is free to shine!</p>
                                <div class="tell-story-box1">
                                    <a href="{{route('app-publish-story')}}" class="tell-story-box">
                                        <h3>Tell Your Story Now</h3>
                                        <span class="tell-story-text">You could become our<br>
                                    newest story star!</span>
                                    </a>

                                </div>
                                <div class="tell-story-box1 brightest-start-box1">

                                    <a href="{{route("app-comingsoon")}}" class="tell-story-box brightest-start-box">
                                        <span class="storystar-title">STORYSTAR’S</span>
                                        <h3>BRIGHTEST STARS!</h3>
                                        <span class="tell-story-text tell-story-text2">Be part of the NEW anthology<br>
                                    of Storystar’s brightest story STARS!</span>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <a name="themes"></a>
                        <div class="browse-section">
                            <h1 class="browse-title text-xs-center">BROWSE STORIES BY <span>THEME</span></h1>
                            <div class="browse-section-boxes">
                                <?php
                                $Themes = App\ Models\ Theme::where("theme_id", "!=", "41")->orderBy("theme_order", "asc")->get()->toArray();
                                ?> @if($Themes) @foreach($Themes as $k =>$theme)
                                    <div class="col-md-3 col-lg-2  {{$k==0 || $k == 5 || $k == 10?'offset-lg-1 offset-md-0':''}} custom-width">
                                        <a href="{{route('app-story-theme',
                                        ['theme_id'=>$theme['theme_id'],'theme_slug'=>$theme['theme_slug']]
                                        )}}">

                                            <div class="love-box text-xs-center {{$theme['theme_class'] OR ''}}">
                                                <img src="{{Image::url(storage_url($theme['theme_image'], 'themes'), 96, 66, array('crop'))}}"
                                                     alt="">
                                                <h5 class="love-title family-color">
                                                    {{strtoupper($theme['theme_title'])}}
                                                </h5>

                                            </div>
                                        </a>
                                    </div>
                                @endforeach @endif


                            </div>
                            <div class="classic-section">
                                <div class="col-md-6 theclassic-box">


                                    <?php
                                    $classicsTheme = getClassicLink();
                                    ?>
                                    <a href="{{route('app-story-theme',
                                        ['theme_id'=>$classicsTheme['theme_id'],'theme_slug'=>$classicsTheme['theme_slug']]
                                        )}}" class="theclassic-box1">
                                        <h2 class="the-classic-title">
                                            READ THE CLASSICS
                                        </h2>
                                        <p class="short-title">Short stories<br>
                                            by world famous authors.
                                        </p>
                                    </a>

                                </div>
                                <div class="col-md-6 theclassic-box novel-bg-box">
                                    <?php
                                    $novelSubject = getNovelsLink();
                                    ?>

                                    <a href="{{route('app-story-subject',
                                        ['theme_id'=>$novelSubject['subject_id'],'theme_slug'=>str_slug($novelSubject['subject_title'])]
                                        )}}" class="theclassic-box1 novel-bg-box1">

                                        <h2 class="the-classic-title">
                                            READ MORE
                                        </h2>
                                        <p class="short-title">Novels, serials & series.</p>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="star-border-box">
                            <span class="star-border"></span>
                        </div>
                        <a name="star-of-week"></a>
                        <div class="theweek-section">
                            <div class="week-box text-xs-center">
                                <h2>STORY STARS OF THE WEEK</h2>
                            </div>
                            <?php
                            $allCategories = getCategories();
                            ?>
                            @if($allCategories)
                                @foreach($allCategories as $key=> $category)

                                    <h3 class="text-xs-center true-stories-title">
                                        {{strtoupper($category)}} STORIES
                                    </h3>
                                    <div class="true-story-section">

                                        <?php
                                        $dt = Carbon\ Carbon::now();
                                        $allStoryStars = \App\ Models\ StoryStar::where("type", "=", "Week")
                                            ->where("category_id", "=", $key)
                                            ->where("is_active", "=", "1")
                                            // ->whereRaw('"' . $dt . '" between `date_from` and `date_to`')
                                            ->orderBy("sub_category_id", "asc")
                                            ->get()->take(3);


                                        $colorTab = ['kids-box', 'teens-box', 'adults-box', 'kids-box', 'teens-box', 'adults-box', 'kids-box', 'teens-box', 'adults-box'];


                                        ?> @if($allStoryStars) @foreach($allStoryStars as $key=>$storyStar)

                                            <div class="col-md-4">
                                                <div class="kids-box <?=$colorTab[$key];?> text-xs-center ">
									        <span>
                                                    {{ucfirst($storyStar->subcategory->sub_category_title)}}
                                             </span>

                                                </div>
                                                <div class="kids-detail-box text-xs-center">
                                                    <div class="img-set">
                                                        <a href="{{route('app-story',['story_id'=>$storyStar->story_id])}}">


                                                            @if($storyStar->story->image)

                                                                @if(file_exists(storage_path().'/story/'.$storyStar->story->image ))

                                                                    <?php
                                                                    $data = getimagesize(storage_path() . '/story/' . $storyStar->story->image);
                                                                    $imgWidth = $data[0];
                                                                    $imgHeight = $data[1];



                                                                    /* if ($imgWidth > 252 && $imgHeight > 182) {

                                                                         $widthRatio = 252 / $imgWidth;
                                                                         $heightRatio = 182 / $imgHeight;

                                                                         // Ratio used for calculating new image dimensions.
                                                                         $ratio = min($widthRatio, $heightRatio);

                                                                         // Calculate new image dimensions.
                                                                         $scaledWidth = (int)$imgWidth * $ratio;
                                                                         $scaledHeight = (int)$imgHeight * $ratio;

                                                                         //$scaledWidth = $scaledWidth + ($scaledWidth * 10);
                                                                         //$scaledHeight = $scaledHeight + ($scaledHeight * 10);


                                                                     } else if ($imgWidth > 252 && $imgHeight < 182) {

                                                                         $widthRatio = 252 / $imgWidth;
                                                                         $heightRatio = 182 / $imgHeight;

                                                                         // Ratio used for calculating new image dimensions.
                                                                         $ratio = min($widthRatio, $heightRatio);

                                                                         // Calculate new image dimensions.
                                                                         $scaledWidth = (int)$imgWidth * $ratio;
                                                                         $scaledHeight = (int)$imgHeight * $ratio;

                                                                     } else if ($imgWidth < 252 && $imgHeight > 182) {


                                                                         $widthRatio = 252 / $imgWidth;
                                                                         $heightRatio = 182 / $imgHeight;

                                                                         // Ratio used for calculating new image dimensions.
                                                                         $ratio = min($widthRatio, $heightRatio);

                                                                         // Calculate new image dimensions.
                                                                         $scaledWidth = (int)$imgWidth * $ratio;
                                                                         $scaledHeight = (int)$imgHeight * $ratio;

                                                                     } else {


                                                                         $widthRatio = 252 / $imgWidth;
                                                                         $heightRatio = 182 / $imgHeight;

                                                                         // Ratio used for calculating new image dimensions.
                                                                         $ratio = min($widthRatio, $heightRatio);

                                                                         // Calculate new image dimensions.
                                                                         $scaledWidth = (int)$imgWidth * $ratio;
                                                                         $scaledHeight = (int)$imgHeight * $ratio;

                                                                     }*/

                                                                    $widthRatio = 250 / $imgWidth;
                                                                    $heightRatio = 250 / $imgHeight;

                                                                    // Ratio used for calculating new image dimensions.
                                                                    $ratio = min($widthRatio, $heightRatio);

                                                                    // Calculate new image dimensions.
                                                                    $scaledWidth = (int)$imgWidth * $ratio;
                                                                    $scaledHeight = (int)$imgHeight * $ratio;



                                                                    $scaledWidth = ceil($scaledWidth);
                                                                    $scaledHeight = ceil($scaledHeight);
                                                                    ?>


                                                                    <img class="the-day-img"
                                                                         src="{{Image::url(storage_url($storyStar->story->image, 'story'), $scaledWidth, $scaledHeight, array('crop'))}}"
                                                                         alt="{{ucfirst($storyStar->story->story_title)}}">

                                                                @endif


                                                            @endif


                                                        </a>
                                                    </div>


                                                    <h4 class="kids-box-title">
                                                        <a href="{{route("app-story",['story_id'=>$storyStar->story_id])}}">{{decodeStr($storyStar->story->story_title)}}</a>
                                                    </h4>

                                                    <h6 class="michael-title">By
                                                        <a href="{{route("app-story",['story_id'=>$storyStar->story_id])}}">
                                                            {{isset($storyStar->story->author_name)?ucfirst($storyStar->story->author_name):''}}
                                                        </a>
                                                    </h6>
                                                    <p class="kids-content">
                                                        {{\Illuminate\Support\Str::limit($storyStar->story->short_description, 144)}}
                                                    </p>
                                                </div>
                                            </div>

                                        @endforeach @endif

                                    </div>
                                    <div class="clearfix"></div>

                                @endforeach
                            @endif

                        </div>
                        <div class="clearfix"></div>
                        <div class="star-border-box">
                            <span class="star-border"></span>
                        </div>
                        <div class="browse-section subscribe-section">
                            <div class="col-md-6">
                                <div class="theclassic-box subscribe-now">
                                    {{--data-toggle="modal" data-target="#flagModal"--}}
                                    <a href="{{route("app-comingsoon")}}"
                                       class="theclassic-box1 subscribe-now1">
                                        <h2 class="subscribe-title">SUBSCRIBE NOW</h2>
                                        <p class="stories-text">for exclusive stories by<br>
                                            some of our best authors!
                                        </p>
                                    </a>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" theclassic-box subscribe-now help-boxes">
                                    <a href="{{route('app-help')}}" class="theclassic-box1 subscribe-now1 help-boxes1">
                                        <p class="helpus-text">HELP US KEEP STORY STAR<br>
                                            <span>FREE</span> FOR EVERYONE !
                                        </p>
                                    </a>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <a name="author-of-month"></a>
                            <?php

                            $MonthAuthor = [];
                            // $month = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));;
                            $MonthAuthor = App\Models\MonthAuthor::orderBy("id", "desc")->first();

                            ?>
                            @if($MonthAuthor&& isset($MonthAuthor->user)&&!empty($MonthAuthor->user))
                                <div class="col-md-12">
                                    <div class="author-section flexbox">
                                        <div class="author-sec-inner flexbox">
                                            <div class=" col-md-4 jill-img">

                                                @if(isset($MonthAuthor->user->avatar)&&!empty($MonthAuthor->user->avatar))

                                                    @if(file_exists(storage_path().'/users/'.$MonthAuthor->user->avatar))


                                                        <?php
                                                        $data = getimagesize(storage_path() . '/users/' . $MonthAuthor->user->avatar);
                                                        $imgWidth = $data[0];
                                                        $imgHeight = $data[1];


                                                        if ($imgWidth > 212 && $imgHeight > 212) {

                                                            $widthRatio = 212 / $imgWidth;
                                                            $heightRatio = 212 / $imgHeight;

                                                            // Ratio used for calculating new image dimensions.
                                                            $ratio = min($widthRatio, $heightRatio);

                                                            // Calculate new image dimensions.
                                                            $scaledWidth = (int)$imgWidth * $ratio;
                                                            $scaledHeight = (int)$imgHeight * $ratio;


                                                        } else if ($imgWidth > 212 && $imgHeight < 212) {

                                                            $widthRatio = 212 / $imgWidth;
                                                            $heightRatio = 212 / $imgHeight;

                                                            // Ratio used for calculating new image dimensions.
                                                            $ratio = min($widthRatio, $heightRatio);

                                                            // Calculate new image dimensions.
                                                            $scaledWidth = (int)$imgWidth * $ratio;
                                                            $scaledHeight = (int)$imgHeight * $ratio;

                                                        } else if ($imgWidth < 212 && $imgHeight > 212) {

                                                            $widthRatio = 212 / $imgWidth;
                                                            $heightRatio = 212 / $imgHeight;

                                                            // Ratio used for calculating new image dimensions.
                                                            $ratio = min($widthRatio, $heightRatio);

                                                            // Calculate new image dimensions.
                                                            $scaledWidth = (int)$imgWidth * $ratio;
                                                            $scaledHeight = (int)$imgHeight * $ratio;

                                                        } else {

                                                            $widthRatio = 212 / $imgWidth;
                                                            $heightRatio = 212 / $imgHeight;

                                                            // Ratio used for calculating new image dimensions.
                                                            $ratio = min($widthRatio, $heightRatio);

                                                            // Calculate new image dimensions.
                                                            $scaledWidth = (int)$imgWidth * $ratio;
                                                            $scaledHeight = (int)$imgHeight * $ratio;

                                                        }

                                                        $scaledWidth = ceil($scaledWidth);
                                                        $scaledHeight = ceil($scaledHeight);
                                                        ?>

                                                        <img class="the-day-img"
                                                             src="{{Image::url(storage_url($MonthAuthor->user->avatar, 'users'), $scaledWidth, $scaledHeight, array('crop'))}}"
                                                             alt="">


                                                    @else
                                                        <img class="img-fluid"
                                                             src="{{Image::url(storage_url('default.png', 'users'), 212, 212, array('crop'))}}"
                                                             alt="">
                                                    @endif
                                                @else

                                                    <img alt="..."
                                                         data-src="{{Image::url(storage_url("default.png ",'users'), 212, 212, array('crop'))}}"
                                                         class="img-fluid">

                                                @endif
                                            </div>
                                            <div class="col-md-8 col-lg-7 text-xs-center jill-txt">
                                            <div class="">
                                                <h3 class="author-title">AUTHOR OF THE MONTH</h3>
                                                <span class="mcgraw-title">{{ucfirst($MonthAuthor->user->name)}}</span>
                                                <div class="read-jills">
                                                    READ {{trim(strtoupper($MonthAuthor->user->name),0)}}’S
                                                    STORIES NOW
                                                </div>
                                                <div class="text-xs-center btn btn-readstory read-mobile">
                                                    <a href="{{route('app-profile',['user_id'=>$MonthAuthor->user->user_id,'user_name'=>str_slug($MonthAuthor->user->name)])}}">
                                                        Read Stories
                                                    </a>

                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <!-- <div class="auther-bottom-border"></div> -->
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                @include('app.components.footer')
            </div>
        </div>



        <div class="modal fade default-modal" id="flagModal" role="dialog" tabindex="-1" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">


                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5>SUBSCRIBE NOW</h5>
                    </div>
                    <div class="modal-body flag-body subs_modal">

                        <div class="alert alert-danger fade in" id="subscribeError" style="display:none">
                            <strong id="subscribeErrorText">Error!</strong>
                        </div>
                        <div class="alert alert-success fade in" id="subscribeSuccess" style="display:none">
                            <i class="fa-fw fa fa-check"></i>
                            <strong id="subscribeSuccessText">Success</strong>
                        </div>


                        <form method="post" id="flag-box" action="{{route('app-subscribe')}}" id="reply-box"
                              onsubmit="return addSubscriber($(this))">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input type="text" class="custom-select " id="name" name="name" placeholder="Name"/>
                            <input type="text" class="custom-select " id="email" name="email" placeholder="Email"/>

                            <div class="form-select-left btn_submit">
                                <div class="text-xs-center btn btn-readstory read-mobile">
                                    <input type="submit" value="Submit"
                                           style="font-size: 16px;font-family: 'TheSalvadorCondensed-Regular';color: #272e31;text-transform: uppercase;letter-spacing: 1px;font-weight: bold;position: relative;"/>
                                </div>
                                <!-- <div class="text-xs-center btn btn-readstory read-mobile">
                                                <a href="">Submit</a>

                                </div> -->
                            </div>
                            <div class="clearfix"></div>


                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script>


            $(document).ready(function () {
                $(document).on('hidden.bs.modal', function (e) {

                    $("#subscribeError").hide();
                    $("#subscribeSuccess").hide();

                });
            });

            function addSubscriber(from) {

                $(".alert").hide();

                $("input[type=submit]").attr("disabled", "disabled");
                var postData = from.serializeArray();
                var formURL = from.attr("action");
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (data, textStatus, jqXHR) {

                        $("input[type=submit]").removeAttr("disabled");

                        if (data.code == 200) {
                            from[0].reset();
                            $("#subscribeSuccessText").html(data.message);
                            $("#subscribeSuccess").fadeIn();
                            setTimeout(function () {
                                $('#flagModal').modal('toggle');
                            }, 2000);
                        } else {


                            var er = ""
                            $.each(data.message, function (index, value) {
                                er += value + "<br/>"
                            });

                            $("#subscribeErrorText").html(er);
                            $("#subscribeError").fadeIn();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //if fails
                    }
                });

                return false;

            }
        </script>

@endsection

@push( 'js' )
<script type="text/javascript" src="{{app_assets('js/sprite.js')}}"></script>
@endpush


@push( 'meta-data' )



<meta property="og:url" content="http://www.storystar.com/"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="Storystar, where short story writers are the stars"/>
<meta property="og:description" content="Storystar is a totally FREE short stories site featuring some of the best short stories online, written by/for kids, teens, and adults of all ages around the world."/>
<meta property="og:image" content="http://www.storystar.com/assets/app/images/storystarcom.jpg"/>



<meta name="description"
      content="Storystar is a totally FREE short stories site featuring some of the best short stories online, written by/for kids, teens, and adults of all ages around the world."/>
<meta name="keywords" content="story, star, short story, short stories, free, Publish short stories free"/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/> @endpush @push('meta-data')
<meta name="description" content=" Storystar is a totally FREE short stories site featuring some of the best short stories online, written by/for kids, teens, and adults of all ages around the world."/>
<meta name="keywords" content="short story writing contest,short story,short stories,enter short story contest,
short story writing competition,free short story writing contest,short story competition,short story contest,writing
contest,writing competition,free writing contest,free writing competition,creative writing contest,creative writing
competition,submit short story,submit short stories,tell your story,tell your short story."/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/> @endpush


@push('js-first')

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-70090680-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-70090680-2');
</script>


@endpush