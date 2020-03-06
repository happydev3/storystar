@extends('admin.layout.two-column')


@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

<?php

$adminId = 1;
?>

@section('RightSide')

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-server fa-fw "></i>
                    {{$pageData['MainHeading'] or ''}}

                </h1>
            </div>

        </div>


        <!-- widget grid -->
        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">


                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('admin.components.notification-messages')


                    <div class="jarviswidget jarviswidget-color-blueDark"
                         id="wid-id-1"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-editbutton="false"
                         data-widget-grid="false"
                         data-widget-colorbutton="false"
                         data-widget-sortable="false"

                    >

                        <header>
                            <span class="widget-icon"> <i class="fa fa-server"></i> </span>
                            <h2>Detail Record</h2>
                        </header>


                        <!-- widget div-->
                        <div>


                            <div class="widget-body">


                                <div class="well padding-10">

                                    <div class="row">

                                        <div class="col-md-12">
                                            @if (isset($actions) && !empty($actions))
                                                @forelse ($actions as $k => $action)
                                                    <div class="setting_btn">
                                                        {!! $action !!}
                                                    </div>
                                                @empty
                                                @endforelse
                                            @endif
                                            <hr class="horigental-line">
                                        </div>


                                        <div class="col-md-12">
                                            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-8">
                                                <ul id="sparks" class="">
                                                    <li class="sparks-info">
                                                        <h5>Story Listed as:
                                                            <span class="txt-color-blue">
                                                                <a target="_blank"
                                                                   href="{{route("app-story-category",["category"=>$story->category->category_id,"slug"=>str_slug($story->category->category_title)])}}"> {{$story->category->category_title}}
                                                                </a>
                                                                For
                                                                <a target="_blank"
                                                                   href="{{route("app-story-subcategory",["subcategory"=>$story->subcategory->sub_category_id,"slug"=>str_slug($story->subcategory->sub_category_title3)])}}">
                                                                    {{$story->subcategory->sub_category_title3}}
                                                                </a>
                                                            </span>
                                                        </h5>


                                                    </li>
                                                    <li class="sparks-info">
                                                        <h5> Theme <span class="txt-color-purple">
                                                                 <a target="_blank"
                                                                    href="{{route("app-story-theme",['theme'=>$story->theme->theme_id,'subject_slug>'=>isset($story->theme->theme_slug)?$story->theme->theme_slug:''])}}">
                                                                  {{$story->theme->theme_title}}
                                                                </a>
                                                            </span>
                                                        </h5>

                                                    </li>
                                                    <li class="sparks-info">
                                                        <h5> Subject <span class="txt-color-greenDark">
                                                                 <a target="_blank"
                                                                    href="{{route("app-story-subject",['subject'=>$story->subject->subject_id,'subject_slug>'=>str_slug($story->subject->subject_title)])}}">
                                                           {{$story->subject->subject_title}}</a>
                                                            </span>
                                                        </h5>

                                                    </li>
                                                    <li class="sparks-info">
                                                        <h5> Published at <span class="txt-color-greenDark">
                                                                <a style="color: #214e75;"> {{date("m/d/Y",$story->created_timestamp)}}</a>
                                                            </span>
                                                        </h5>

                                                    </li>
                                                </ul>
                                            </div>


                                        </div>
                                        <div class="col-md-12">
                                            <hr class="horigental-line">
                                        </div>

                                        <div class="col-md-8 padding-left-0">
                                            <h1 class="margin-top-0">

                                                {{htmlspecialchars_decode(html_entity_decode($story->story_title))}}

                                                <br>
                                                <small class="font-xs">

                                                    By
                                                    <a href="javascript:void(0);" style="color:#214e75;">
                                                        {{isset($story->author_name)?ucfirst($story->author_name):ucfirst($story->user->name)}}
                                                    </a>

                                                </small>
                                            </h1>



                                            @php
                                                $StoryInfo = "";

                                                $DOB =  isset($story->author_dob)&&!empty($story->author_dob)?trim($story->author_dob):"";
                                                if($DOB)
                                                    $StoryInfo .= "Born "."$DOB, ";
                                                else
                                                    $StoryInfo .= isset($story->written_by)?$story->written_by.", ":"";



                                                $Gender =  isset($story->author_gender)&&!empty($story->author_gender)?ucfirst($story->author_gender):"";
                                                if($Gender)
                                                    $StoryInfo .= "<span title='".$Gender."'>".substr($Gender,0,1)."</span>, ";

                                                $Address =  isset($story->author_address)&&!empty($story->author_address)?ucfirst($story->author_address):"";
                                                if($Address)
                                                    $StoryInfo .="from ". ucfirst($Address).", ";

                                                $Country =  isset($story->author_country)&&!empty($story->author_country)?ucfirst($story->author_country):"";
                                                if($Country)
                                                    $StoryInfo .=$Country.", ";




                                            @endphp


                                            <h4>
                                                {!! rtrim($StoryInfo," ,") !!}
                                            </h4>

                                            @php
                                                $profileUrl = "";
                                                    if(isset($story->user->is_profile_complete)&&$story->user->is_profile_complete == 1){
                                                        $profileUrl = route('app-profile',['user_id'=>$story->user_id,'user_name'=>str_slug($story->user->name)]);
                                                        $profileUrl = $profileUrl."#profile";
                                                   }
                                            @endphp


                                            <?php
                                            if (isset($story->user) && !empty($story->user)) {
                                            ?>
                                            <h4>Author's Email: <?=$story->user->email;?></h4>
                                            <?php
                                            }
                                            ?>

                                            @if(isset($profileUrl)&&!empty($profileUrl))
                                                <h6>
                                                    <a href="{{$profileUrl}}" target="_blank">
                                                        View Author Profile
                                                    </a>
                                                </h6>
                                            @endif

                                            <?php
                                            $countStories = App\Models\Story::with("stories")->where("user_id", "=", $story->user_id)->count();


                                            if($countStories > 1):
                                            ?>
                                            <h6>
                                                <a target="_blank"
                                                   href="{{route('app-profile',['user_id'=>$story->user_id,'user_name'=>str_slug($story->author_name)])}}#stories">
                                                    Read More Stories by This Author
                                                </a>
                                            </h6>
                                            <?php
                                            endif;
                                            ?>



                                            <?php
                                            $readOnly = 'true';
                                            $title = "";
                                            $average_rate = 0;
                                            $url = 'javascript:void(0)';
                                            $string = '';
                                            $alreadyRare = '';

                                            $totalViews = isset($story->views) ? $story->views : 0;
                                            $average_rate = isset($story->rate->average_rate) ? number_format($story->rate->average_rate, 1) : 0;


                                            $r1 = isset($story->rate->r1) ? $story->rate->r1 : 0;
                                            $r2 = isset($story->rate->r2) ? $story->rate->r2 : 0;
                                            $r3 = isset($story->rate->r3) ? $story->rate->r3 : 0;
                                            $r4 = isset($story->rate->r4) ? $story->rate->r4 : 0;
                                            $r5 = isset($story->rate->r5) ? $story->rate->r5 : 0;
                                            $totalVotes = $r1 + $r2 + $r3 + $r4 + $r5;



                                            $readOnly = 'false';

                                            $userID = $adminId;
                                            $alreadyRare = isset($story->rater($userID, $story->story_id)->rate) ? $story->rater($userID, $story->story_id)->rate : 0;


                                            if (isset($alreadyRare) && !empty($alreadyRare)) {


                                                $readOnly = 'true';

                                                $txt = ($alreadyRare > 1) ? "stars" : "star";
                                                $string = "You have given $alreadyRare " . $txt . " to this story.";
                                                $average_rate = isset($story->rate->average_rate) ? number_format($story->rate->average_rate, 1) : 0;
                                                $title = "
Average Story Rating: " . $average_rate . "
No. of View(s): $totalViews
No. of Vote(s): $totalVotes";

                                            } else {

                                                $average_rate = 0;
                                                $string = "Please Rate This Story.";
                                            }


                                            ?>


                                            <div class="product-content product-wrap clearfix product-deatil"
                                                 style="padding: 0px; border: none">
                                                <div class="certified staradmin">
                                                    <ul>
                                                        <li>

                                                            <a href="{{$url}}">
                                                                <div class="individual-star-box">
                                                                    <div class="my-rating"
                                                                         data-rating="{{$average_rate}}"
                                                                         title="{{$title}}"></div>
                                                                    <span id="yourRatedText">{{$string}}</span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-4">
                                            @if($story->image)
                                                @if(file_exists(storage_path().'/story/'.$story->image ))

                                                    <?php
                                                    $data = getimagesize(storage_path() . '/story/' . $story->image);
                                                    $imgWidth = $data[0];
                                                    $imgHeight = $data[1];


                                                    if ($imgWidth > 415 && $imgHeight > 285) {
                                                        //  $scaledWidth = 415;
                                                        //  $scaledHeight = 285;

                                                        $widthRatio = 415 / $imgWidth;
                                                        $heightRatio = 285 / $imgHeight;

                                                        // Ratio used for calculating new image dimensions.
                                                        $ratio = min($widthRatio, $heightRatio);

                                                        // Calculate new image dimensions.
                                                        $scaledWidth = (int)$imgWidth * $ratio;
                                                        $scaledHeight = (int)$imgHeight * $ratio;


                                                    } else if ($imgWidth > 415 && $imgHeight < 285) {


                                                        $widthRatio = 415 / $imgWidth;
                                                        $heightRatio = 285 / $imgHeight;

                                                        // Ratio used for calculating new image dimensions.
                                                        $ratio = min($widthRatio, $heightRatio);

                                                        // Calculate new image dimensions.
                                                        $scaledWidth = (int)$imgWidth * $ratio;
                                                        $scaledHeight = (int)$imgHeight * $ratio;

                                                    } else if ($imgWidth < 415 && $imgHeight > 285) {

                                                        $widthRatio = 415 / $imgWidth;
                                                        $heightRatio = 285 / $imgHeight;

                                                        // Ratio used for calculating new image dimensions.
                                                        $ratio = min($widthRatio, $heightRatio);

                                                        // Calculate new image dimensions.
                                                        $scaledWidth = (int)$imgWidth * $ratio;
                                                        $scaledHeight = (int)$imgHeight * $ratio;

                                                    } else {

                                                        //$scaledWidth = $imgWidth;
                                                        //$scaledHeight = $imgHeight;

                                                        $widthRatio = 415 / $imgWidth;
                                                        $heightRatio = 285 / $imgHeight;

                                                        // Ratio used for calculating new image dimensions.
                                                        $ratio = min($widthRatio, $heightRatio);

                                                        // Calculate new image dimensions.
                                                        $scaledWidth = (int)$imgWidth * $ratio;
                                                        $scaledHeight = (int)$imgHeight * $ratio;

                                                    }

                                                    $scaledWidth = ceil($scaledWidth);
                                                    $scaledHeight = ceil($scaledHeight);
                                                    ?>


                                                    <img class="img-responsive"
                                                         src="{{Image::url(storage_url($story->image, 'story'), $scaledWidth, $scaledHeight, array('crop'))}}"
                                                         alt="{{ucfirst($story->story_title)}}">


                                                @else
                                                    {{--<img class="img-fluid"--}}
                                                    {{--src="{{Image::url(storage_url('default.jpg', 'story'), 415, 285, array('crop'))}}"--}}
                                                    {{--alt="{{ucfirst($story->story_title)}}">--}}
                                                @endif

                                            @endif
                                        </div>


                                        <div class="col-md-12">

                                            <p style="    font-size: 14px; font-weight: 400;line-height: 22px;">
                                                <br>
                                                {!! nl2br(html_entity_decode(removeBR($story->the_story))) !!}
                                                <br><br>
                                            </p>

                                            <hr class="horigental-line">


                                            @if (isset($actions) && !empty($actions))
                                                @forelse ($actions as $k => $action)
                                                    <div class="setting_btn">
                                                        {!! $action !!}
                                                    </div>
                                                @empty
                                                @endforelse
                                            @endif

                                        </div>


                                    </div>


                                </div>


                            </div>


                        </div>
                        <!-- end widget div -->

                    </div>


                </article>

            </div>


        </section>

    </div>
    <!-- END MAIN CONTENT -->

    <script type="text/javascript" src="{{app_assets('js/jquery.star-rating-svg.js')}}"></script>
    <link href="{{app_assets("css/star-rating-svg.css")}}" type="text/css" rel="stylesheet">

    <script>
        // When user click on delete btn . It is showing confirmation
        function confirmBox(value) {
            $.SmartMessageBox({
                title: ' <i class="fa fa-trash txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to delete this record?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }

        // When user click on delete btn . It is showing confirmation
        function confirmBoxOnBlock(value) {
            $.SmartMessageBox({
                title: ' <i class="fa  fa-exclamation txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to change status of this user?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }


        $(document).ready(function () {


            //Start Rating Code
            $(".my-rating").starRating({
                //initialRating: 0.2,
                //  readOnly: <?=$readOnly;?>,
                disableAfterRate: false,
                starSize: 35,
                useFullStars: true,
                strokeWidth: 20,
                strokeColor: '#e5c71c',
                emptyColor: '#4074d8',
                hoverColor: '#ffdb00',
                starGradient: {
                    start: '#ffff00',
                    end: '#ffab00'
                },
                callback: function (currentRating, $el) {


                    if (currentRating) {

                        var txt = "star"
                        if (currentRating > 1)
                            txt = "stars"

                        $("#yourRatedText").html("You have given " + currentRating + " " + txt + " to this story");

                        $.ajax({
                            type: 'POST',
                            url: '{{route("admin-stories-rate-story")}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "rate": currentRating,
                                "story": <?=$story->story_id;?>,
                            },
                            success: function (msg) {
                                // alert('wow' + msg);
                            }
                        });

                    }

                }
            });


            @if($alreadyRare!=0)

            $(document).on('mouseover', '.jq-star', function () {

                var title = $(this).parent().attr("title");
                $(this).attr("title", title);
            });
            @endif


        });
    </script>
@stop



