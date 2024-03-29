@extends('app.layout.page')

@push('js-include')
    <script type="text/javascript" src="{{app_assets('js/jquery.jscroll.js')}}"></script>
@endpush

@section('bodyContent')
    <style>
        .individ-content {
            letter-spacing: 0px;
        }

        .popup-container {
            position: fixed;
            width: 1047px;
            bottom: 0;
            z-index: 100;
        }

        .popup {
            float: right;
            background: #F1E412;
            width: 300px;
            height: 140px;
            text-align: center;
            border: 1px solid;
            color: #003992;
            border-radius: 10px;
            vertical-align: middle;
            padding-top: 24px;
            font-weight: bold;
            display: none;
            margin-bottom: 5px;
        }

        .gift-container {
            width: 33%;
            margin-left: 52px;
            cursor: pointer;
            position: absolute;
        }

        .gift-points {
            position: absolute;
            left: 0px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            background-color: #f0f1f5;
            float: none;
            margin-right: 0px;
            display: inline-block;
        }
    </style>
    <div class="container">
        <div class="popup-container">
            <div class="popup">
                <h3 style="font-weight:1000;">Congratulations !</h3>
                <br/>
                <p>You have been awarded points. <br/>Thank you for <span class="popup-message"></span> !</p>
            </div>
        </div>
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg author-middle-bg2">
                        <ul class="individu-story-list">
                            <li style="color: #FFF;">
                                Story Listed as:
                                <a href="{{route("app-story-category",["category"=>$story->category->category_id,"slug"=>str_slug($story->category->category_title)])}}"> {{$story->category->category_title}}
                                </a>
                                For
                                <a href="{{route("app-story-subcategory",["subcategory"=>$story->subcategory->sub_category_id,"slug"=>str_slug($story->subcategory->sub_category_title3)])}}">
                                    {{$story->subcategory->sub_category_title3}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route("app-story-theme",['theme'=>$story->theme->theme_id,'subject_slug>'=>isset($story->theme->theme_slug)?$story->theme->theme_slug:''])}}">
                                    Theme: {{$story->theme->theme_title}}</a>
                            </li>
                            <li>
                                <a href="{{route("app-story-subject",['subject'=>$story->subject->subject_id,'subject_slug>'=>str_slug($story->subject->subject_title)])}}">
                                    Subject: {{$story->subject->subject_title}}</a>
                            </li>
                            <li>
                                <a style="color: #FFF;">Published: {{date("m/d/Y",$story->created_timestamp)}}</a>
                            </li>
                        </ul>
                        <div class="individu-story-section">
                            @if(Session::has('alert-danger') or Session::has('alert-warning') or Session::has('alert-success') or Session::has('alert-danger'))
                                <div class="col-md-8" style="margin-left:-14px;">
                                    <article class="">
                                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                            @if(Session::has('alert-'.$msg))
                                            <div class="alert alert-{{ $msg }} fade in">
                                                <button class="close" data-dismiss="alert">×</button>
                                                @if($msg=='warning')
                                                    <i class="fa-fw fa fa-warning"></i>
                                                    <strong>Warning</strong>
                                                @elseif($msg=='success')
                                                    <strong>Success! </strong>
                                                @elseif($msg=='info')
                                                    <i class="fa-fw fa fa-info"></i>
                                                    <strong>Info!</strong>
                                                @elseif($msg=='danger')
                                                    <i class="fa-fw fa fa-times"></i>
                                                    <strong>Error!</strong>
                                                @endif
                                                {{ Session::get('alert-' . $msg) }}.
                                            </div>
                                            @endif
                                        @endforeach
                                    </article>
                                </div>
                            @endif

                            <div class="harvesting-left">
                                <h1 class="author-heading"
                                    style="font-family: 'Oxygen-Regular'">{{htmlspecialchars_decode(html_entity_decode($story->story_title))}}</h1>
                                    
                                <div class="individ-justin">
                                    @if(@$story->user->is_profile_complete==1)
                                        <?php $name = isset($story->author_name) && !empty($story->author_name) ? ucfirst($story->author_name) : ucfirst($story->user->name);
                                        ?>
                                        <a href="{{route('app-profile',['user_id'=>$story->user->user_id,'user_name'=>str_slug($name)])}}">By
                                            <span>{{$name}}</span></a>
                                    @else
                                        By <span>{{isset($story->author_name)?ucfirst($story->author_name):""}}</span>
                                        &nbsp;
                                    @endif
                                    @if(\Auth::user())
                                        @if($story->user_id )
                                            @if(\Auth::user() && $story->user_id != \Auth::user()->user_id)
                                                <div class="author-heart-icon">
                                                    <div class="gift-container">
                                                        <a class="gift-points"
                                                           data-user_id="{{$story->user_id}}"
                                                           title="Gift points to {{strtoupper($story->author_name)}}.">
                                                            <i class="fa fa-gift" aria-hidden="true"></i>
                                                        </a>
                                                    </div>

                                                    <a id="fav-user-{{$story->user_id}}" href="javascript:void(0)"
                                                       onclick="favActionAuthor({{$story->user_id}},'Remove')"
                                                       title="Remove {{strtoupper($story->author_name)}} from favorite list."
                                                       style="{{$favAddedAuthor==0?'display: none;':''}}"
                                                    >
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a>
                                                    <a id="unfav-user-{{$story->user_id}}" href="javascript:void(0)"
                                                       onclick="favActionAuthor({{$story->user_id}},'Add')"
                                                       title="Add {{strtoupper($story->author_name)}} into favorite list."
                                                       style="{{$favAddedAuthor==1?'display: none;':''}}">
                                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if($story->user_id )
                                            <div class="author-heart-icon">
                                                <a id="fav-user-{{$story->user_id}}" href="{{route("login")}}"
                                                   title="Add {{strtoupper($story->author_name)}} into favorite list.">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <span class="earn-title">
                                    @php
                                        $StoryInfo = "";
                                        $DOB =  isset($story->author_dob)&&!empty($story->author_dob)?trim($story->author_dob):"";
                                        if($DOB)
                                            $StoryInfo .= "Born "."$DOB, ";
                                        else
                                            $StoryInfo .= isset($story->written_by)?ucfirst(strtolower($story->written_by)).", ":"";

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

                                    {!! rtrim($StoryInfo," ,") !!}
                                </span>
                                <div class="individ-profile-link">
                                    @if(@$story->user->is_profile_complete == 1)
                                    <?php $name = isset($story->author_name) && !empty($story->author_name) ? ucfirst($story->author_name) : ucfirst($story->user->name);
                                        ?>
                                        <a href="{{route('app-profile',['user_id'=>$story->user->user_id,'user_name'=>str_slug($name)])}}">
                                            View Author Profile
                                        </a>
                                    @endif
                                    <br>
                                    @php
                                        @endphp
                                    @if(empty($story->user_id))
                                        @php
                                            $Author = App\Models\SiteUser::firstOrCreate([
                                                            'name' => $story->author_name,
                                                            'country' => $story->author_country,
                                                            'address' => $story->author_address,
                                                        ],[
                                                            'gender' => $story->author_gender,
                                                            'dob' => $story->author_dob,
                                                            'password' => bcrypt(str_random(8)),
                                                            'email' => time().'@storystar.com',
                                                            'created_timestamp' => time(),
                                                            'updated_timestamp' => time(),
                                                            'verify_token' => str_random(40),
                                                            'active' => 1,
                                                            'is_author' => 1,
                                                        ]);

                                            $story->user_id = $Author->user_id;
                                            App\Models\Story::where('story_id',$story->story_id)->update(["user_id"=>$Author->user_id]);

                                        @endphp
                                    @endif

                                    @php
                                        $countStories = App\Models\Story::with("stories")->where("user_id", "=", $story->user_id)->count();
                                    @endphp
                                    @if($countStories > 1 && (isset($story->user)))
                                        <a href="{{route('app-profile',['user_id'=>$story->user_id,'user_name'=>str_slug($story->author_name)])}}#stories">
                                            Read More Stories by This Author
                                        </a>
                                    @endif
                                </div>
                                <?php
                                $readOnly = 'true';
                                $title = "";
                                $average_rate = $average_rate_text = 0;
                                $url = 'javascript:void(0)';
                                $string = '';
                                $alreadyRare = '';

                                $totalViews = isset($story->views) ? $story->views : 0;
                                $average_rate_text = $average_rate = isset($story->rate->average_rate) ? number_format($story->rate->average_rate,
                                    1) : 0;

                                $r1 = isset($story->rate->r1) ? $story->rate->r1 : 0;
                                $r2 = isset($story->rate->r2) ? $story->rate->r2 : 0;
                                $r3 = isset($story->rate->r3) ? $story->rate->r3 : 0;
                                $r4 = isset($story->rate->r4) ? $story->rate->r4 : 0;
                                $r5 = isset($story->rate->r5) ? $story->rate->r5 : 0;
                                $totalVotes = $r1 + $r2 + $r3 + $r4 + $r5;

                                if (\Auth::check()) {
                                    $userID = \Auth::user()->user_id;
                                    $storyAuthorID = isset($story->user_id) ? $story->user_id : 0;
                                    $alreadyRare = isset($story->rater($userID,
                                            $story->story_id)->rate) ? $story->rater($userID,
                                        $story->story_id)->rate : 0;
                                    $average_rate = isset($story->rate->average_rate) ? number_format($story->rate->average_rate,
                                        1) : 0;
                                    $title = "
                                    Average Story Rating: " . $average_rate . "
                                    No. of View(s): $totalViews
                                    No. of Vote(s): $totalVotes";

                                    if ($userID == $storyAuthorID) {
                                        $readOnly = 'true';
                                    } else {
                                        $readOnly = 'false';

                                        if (isset($alreadyRare) && !empty($alreadyRare)) {
                                            $readOnly = 'true';
                                            $txt = ($alreadyRare > 1) ? "stars" : "star";
                                            // $string = "You have given $alreadyRare " . $txt . " to this story.";
                                            $string = "Thank you for your rating";
                                        } else {
                                            $average_rate = 0;
                                            $string = "Please Rate This Story";
                                        }
                                    }
                                } else {
                                    $title = "
                                    Average Story Rating: " . $average_rate . "
                                    No. of View(s): $totalViews
                                    No. of Vote(s): $totalVotes";

                                    $string = "Please Rate This Story";
                                    \Session::put('url.intended', URL::full());
                                    $url = route("login");
                                }

                                ?>

                                <div class="rating_flag clearfix">
                                    <div class="individual-star-box">
                                        <a href="{{$url}}">
                                            <div class="my-rating" data-rating="{{$average_rate}}"
                                                 title="{{$title}}"></div>
                                        </a>

                                        @if(\Auth::user())
                                            @if($story->user_id != \Auth::user()->user_id)
                                                <span>
                                                <span id="yourRatedText">  {{$string}} </span>
                                                    @if (isset($story->rate))
                                                        <?php
                                                        $rating_url = route("app-story-rating",
                                                            [$story->rate->story_id]);
                                                        ?>

                                                        <a href="<?=$rating_url;?>">
                                                            <span class="qus"
                                                                  title="Click here for more details about story ratings. Thank you.">?</span>
                                                        </a>
                                                    @endif
                                                 </span>
                                            @endif
                                        @else
                                            <span>
                                                <span id="yourRatedText">  {{$string}} </span>
                                                <?php
                                                $rating_url = route("app-story-rating", [$story->story_id]);
                                                ?>

                                                <a href="<?=$rating_url;?>">
                                                    <span class="qus"
                                                          title="Click here for more details about story ratings. Thank you.">?</span>
                                                </a>
                                            </span>
                                        @endif
                                    </div>
                                    @if(\Auth::user())
                                        @if($story->user_id == \Auth::user()->user_id)
                                            <div class="avg-rating-story">
                                                <p>
                                                    <strong>No. of View(s): </strong>{{$totalViews}} <br>
                                                    <strong>No. of Votes(s): </strong> {{$totalVotes}}<br>
                                                    <strong>Average Story Rating: </strong>{{$average_rate_text}}
                                                </p>
                                            </div>
                                        @endif
                                    @endif

                                    <?php
                                    if ($story->subject_id == 177) {
                                        $passedTime = 0;
                                    } else {
                                        $passedTime = strtotime(date("Y-m-d H:m:s", strtotime('-24 hours')));
                                    }
                                    ?>

                                    @if(isset($story->user_id) && $story->updated_timestamp>$passedTime)
                                        @if(\Auth::user())
                                            @if($story->user_id != \Auth::user()->user_id)
                                                <a href="javascript:void(0)" data-toggle="modal"
                                                   data-target="#flagModal"
                                                   title="Click to flag story to Site Admin attention, if there is a problem."
                                                   class="flag-anchor">
                                                    <i class="fa fa-flag"></i>
                                                </a>
                                            @endif
                                        @else
                                            <?php
                                            \Session::put('url.intended', URL::full());
                                            $url = route("login");
                                            ?>
                                            <a href="<?=$url;?>"
                                               title="Click to flag story to Site Admin attention, if there is a problem."
                                               class="flag-anchor">
                                                <i class="fa fa-flag"></i>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>

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
                                    } elseif ($imgWidth > 415 && $imgHeight < 285) {
                                        $widthRatio = 415 / $imgWidth;
                                        $heightRatio = 285 / $imgHeight;
                                        // Ratio used for calculating new image dimensions.
                                        $ratio = min($widthRatio, $heightRatio);
                                        // Calculate new image dimensions.
                                        $scaledWidth = (int)$imgWidth * $ratio;
                                        $scaledHeight = (int)$imgHeight * $ratio;
                                    } elseif ($imgWidth < 415 && $imgHeight > 285) {
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
                                    <div class="harvesting-right">
                                        <img class="img-fluid"
                                             src="{{Image::url(storage_url($story->image, 'story'), $scaledWidth, $scaledHeight, array('crop'))}}"
                                             alt="{{ucfirst($story->story_title)}}">
                                    </div>
                                @else
                                    {{--<img class="img-fluid"--}}
                                    {{--src="{{Image::url(storage_url('default.jpg', 'story'), 415, 285, array('crop'))}}"--}}
                                    {{--alt="{{ucfirst($story->story_title)}}">--}}
                                @endif
                            @endif

                            <div class="individ-content" style="padding-bottom: 50px;">
                                <p>{!! nl2br(html_entity_decode(removeBR($story->the_story))) !!}
                                </p>
                            </div>
                            <div class="col-md-1 col-lg-1 padding-remove-heart share-custom-width3"
                                 style="width:100%;">
                                @if(\Auth::user() && $story->user_id != \Auth::user()->user_id)
                                    <a onclick="favAction({{$story->story_id}},'Remove')"
                                       id="fav-story-{{$story->story_id}}"
                                       href="javascript:void(0)" class="heart-social-icon"
                                       title="Remove story from favorite stories list."
                                       style="{{$favAdded==0?'display: none;':''}}">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                    <a onclick="favAction({{$story->story_id}},'Add')"
                                       id="unfav-story-{{$story->story_id}}"
                                       href="javascript:void(0)" class="heart-social-icon"
                                       title="Add story to favorite stories list."
                                       style="{{$favAdded==1?'display: none;':''}}">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                    <a onclick="nominateAction({{$story->story_id}},'Add')"
                                       id="nominate-story-{{$story->story_id}}"
                                       href="javascript:void(0)" class="heart-social-icon certificate-icon"
                                       title="Nominate this story for anthology."
                                       style="{{$nominateAdded == 0 ? 'display: block;' : 'display:none;'}}">
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a id="unnominate-story-{{$story->story_id}}"
                                       href="javascript:void(0)" class="heart-social-icon certificate-icon"
                                       title="Story already nominated for anthology"
                                       style="{{$nominateAdded != '0' ? 'display: block;' : 'display:none;'}}">
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a id="unfav-story-{{$story->story_id}}"
                                       href="{{route("login")}}" class="heart-social-icon certificate-icon"
                                       title="Add story to favorite stories list.">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                    <a id="nominate-story-{{$story->story_id}}"
                                       href="{{route("login")}}" class="heart-social-icon certificate-icon"
                                       title="Nominate story for anthology.">
                                        <i class="fa fa-check-square-o"></i>
                                    </a>
                                @endif
                                
                                    <input type="checkbox" name="thumbsup" id="thumbsup-{{$story->story_id}}" @if($like != 0) disabled @endif>
                                    <label class="thumbup" for="thumbsup-{{$story->story_id}}"><div class="like-count">@if($count){{ $count }} @else 0 @endif</div></label>
                                    
                                
                                    
                            </div>
                            <style>
                                .like-count {
                                    font-weight: 600;
                                    color: #07588d;
                                    font-size: 27px;
                                    padding-left: 100px;
                                    padding-top: 20px;
                                    
                                }
                                .heart-social-icon {
                                    float: left;
                                    margin-top: 30px;
                                }

                                .certificate-icon {
                                    margin-left: 20px;
                                }
                                
                                input[type=checkbox] {
                                    display:none;
                                }
                                
                                input[type=checkbox] + label {
                                    margin-left: 100px;
                                    margin-bottom: 0px;
                                    display:inline-block;
                                    padding: 0 0 0 0px;
                                    background:url("../../../../assets/app/images/starthumbsup.jpg") no-repeat;
                                    height: 100px;
                                    width: 100px;;
                                    background-size: 100%;
                                    position: absolute;
                                }
                                
                                input[type=checkbox]:checked + label {
                                    margin-left: 100px;
                                    margin-bottom: 0px;
                                    background:url("../../../../assets/app/images/starthumbsup.jpg") no-repeat;
                                    height: 100px;
                                    width: 100px;
                                    display:inline-block;
                                    background-size: 100%;
                                    position: absolute;
                                }
                                
                                .thumbup:hover {
                                    cursor: pointer;
                                }
                                
                                @media(max-width: 340px) {
                                    input[type=checkbox] + label {
                                    float: right;
                                    margin-bottom: 0px;
                                    display:inline-block;
                                    padding: 0 0 0 0px;
                                    background:url("../../../../assets/app/images/starthumbsup.jpg") no-repeat;
                                    height: 70px;
                                    width: 70px;;
                                    background-size: 100%;
                                }
                                
                                input[type=checkbox]:checked + label {
                                    float:right;
                                    margin-bottom: 0px;
                                    background:url("../../../../assets/app/images/starthumbsup.jpg") no-repeat;
                                    height: 40px;
                                    width: 40px;
                                    display:inline-block;
                                    background-size: 100%;
                                }
                                .like-count {
                                    float: right;
                                }
                            } 
                            </style>
                            <div class="individul-story-share-box">
                                <div class="col-md-8 col-lg-6 padding-remove-left-share share-custom-width">
                                    <ul class="individul-story-share">
                                        <?php
                                        $url = URL::full();
                                        $socialShare = (Share::load($url, $story->story_title)->services("facebook",
                                            "gplus", "twitter", "tumblr", "pinterest", "email"));
                                        ?>
                                        <li>Share this story on</li>
                                        <li>
                                            <a href="{{$socialShare['facebook']}}" target="_blank">
                                                <img src="{{app_assets('images/individu-facebook.png')}}"
                                                     class="img-fluid" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{$socialShare['twitter']}}" target="_blank">
                                                <img src="{{app_assets('images/individu-twitter.png')}}"
                                                     class="img-fluid" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{$socialShare['gplus']}}" target="_blank">
                                                <img src="{{app_assets('images/googleplusicon.png')}}"
                                                     class="img-fluid" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            {{--<a href="{{$socialShare['pinterest']}}" target="_blank">--}}
                                            {{--<img src="{{app_assets('images/individu-pinterset.png')}}"--}}
                                            {{--class="img-fluid" alt="">--}}
                                            {{--</a>--}}
                                            <a href="{{$socialShare['email']}}">
                                                <img src="{{app_assets('images/emailicon.png')}}"
                                                     class="img-fluid" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 col-lg-3 text-xs-center padding-top-social share-custom-width1">
                                    <a href="{{twitter_url}}" target="_blank">
                                        <img src="{{app_assets('images/individu-follow-us.png')}}" class="img-fluid"
                                             alt="">
                                    </a>
                                </div>
                                <div class="col-md-3 col-lg-3 padding-top-social text-xs-center share-custom-width1">
                                    {{--<div id="fb-root"></div>--}}
                                    {{--<script>(function (d, s, id) {--}}
                                    {{--var js, fjs = d.getElementsByTagName(s)[0];--}}
                                    {{--if (d.getElementById(id)) return;--}}
                                    {{--js = d.createElement(s);--}}
                                    {{--js.id = id;--}}
                                    {{--js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=207313922666015&autoLogAppEvents=1';--}}
                                    {{--fjs.parentNode.insertBefore(js, fjs);--}}
                                    {{--}(document, 'script', 'facebook-jssdk'));--}}
                                    {{--</script>--}}
                                    {{--<div class="fb-like" data-href="{{$url}}"--}}
                                    {{--data-layout="button_count" data-action="like" data-size="large"--}}
                                    {{--data-show-faces="false"--}}
                                    {{--data-share="false"></div>--}}

                                    <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FStoryStar%2F&width=90&layout=button_count&action=like&size=large&show_faces=true&share=false&height=21&appId=2030895600464968" width="90" height="40" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>

                                    {{--<iframe--}}
                                        {{--src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2F%23%21%2Fpages%2FStoryStarcom-Publish-Read-Discuss-Short-Stories%2F118577431531287%3Fref%3Dts&amp;layout=button_count&amp;show_faces=false&amp;width=135&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=35"--}}
                                        {{--scrolling="no" frameborder="0"--}}
                                        {{--style="border:none; overflow:hidden; width:108px; height:35px;display: inline-block;margin-top: 18px;"--}}
                                        {{--allowTransparency="true" id="fbiframe" class="iframe-like"></iframe>--}}
                                    {{--<style>--}}
                                        {{--#fbiframe {--}}
                                            {{--transform: scale(1.5);--}}
                                            {{---ms-transform: scale(1.5);--}}
                                            {{---webkit-transform: scale(1.5);--}}
                                            {{---o-transform: scale(1.5);--}}
                                            {{---moz-transform: scale(1.5);--}}
                                            {{--transform-origin: bottom left;--}}
                                            {{---ms-transform-origin: bottom left;--}}
                                            {{---webkit-transform-origin: bottom left;--}}
                                            {{---moz-transform-origin: bottom left;--}}
                                            {{---webkit-transform-origin: bottom left;--}}
                                            {{--margin-top: 4px;--}}
                                        {{--}--}}
                                    {{--</style>--}}
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr class="horigental-line">
                            <div class="comment-boxes">
                                <?php
                                $url = 'javascript:void(0)';
                                if (\Auth::check() || $anonymous == 'anonymous') {
                                    $addClass = 'add-comment';
                                } else {
                                    \Session::put('url.intended', URL::full());
                                    $url = route("login");
                                    $addClass = '';
                                }
                                ?>
                                <div class="col-md-12 text-center">
                                    <div class="text-center btn btn-readstory  {{$addClass}} ">
                                        <a href="{{$url}}">
                                            ADD COMMENT
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <h3 class="author-heading text-center comment-title">
                                        COMMENTS (<span id="counter">{{$comments->total()}}</span>)
                                    </h3>
                                </div>
                            </div>
                            @include("app.comments")
                        </div>
                    </div>
                </div>
            </div>
            @include("app.components.footer")
        </div>
    </div>
    <div class="modal fade default-modal" id="flagModal" role="dialog" tabindex="-1" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Help Us Understand What's Happening</h5>
                </div>
                <div class="modal-body flag-body">
                    <form method="post" id="flag-box"
                          action="{{route('app-flag-story',['story_id'=>$story->story_id])}}"
                          id="reply-box"
                          onsubmit="return flagStory($(this))">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div>
                            <input type="radio" name="flag_for" value="Pornographic or offensive content" checked>
                            <label for="">Pornographic or offensive content</label>
                        </div>
                        <div>
                            <input type="radio" name="flag_for" value="Unreadable">
                            <label for=""> Unreadable</label>
                        </div>
                        <div><input type="radio" name="flag_for" value="Spam or advertising"><label for="">
                                Spam or advertising</label></div>
                        <div><input type="radio" name="flag_for" value="Plagiarism"><label for="">
                                Plagiarism</label>
                        </div>
                        <div class="form-select-left btn_submit">
                            <div class="text-xs-center btn btn-readstory">
                                <input type="submit" value="Submit"/>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
    $(document).ready(function() {
        $('#thumbsup-{{$story->story_id}}').click(function() {
            if(this.checked){
                this.value = 1;
                $('.like-count').html({{ $count }} + 1);
                $('#thumbsup-{{$story->story_id}}').attr('disabled' ,true);
                $.ajax({
                    type: "GET",
                    url: '/update-thumbsup-stories/{{$story->story_id}}',
                    dataType: "JSON",
                      //--> send id of checked checkbox on other page
                    success: function(data) {
                        console.log(data);
                        
                        // window.location.reload();
                
                    },
                });
            }
        });
        
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">

        function postReplay(from) {
            var postData = from.serializeArray();
            var formURL = from.attr("action");
            $("input[type=submit]").attr("disabled", "disabled");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $("input[type=submit]").removeAttr("disabled");
                    from[0].reset();
                    from.parent().next().prepend(data.html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error!\nLooks like you are logged out. Log in and try again.')
                }
            });
            return false;
        }

        function postComment(from) {
            $("input[type=submit]").attr("disabled", "disabled");
            var postData = from.serializeArray();
            var formURL = from.attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    from[0].reset();
                    $("input[type=submit]").removeAttr("disabled");
                    if (data.code == 200) {
                        $("#counter").html(data.count);
                        $(".jscroll-inner").prepend(data.html);
                        if (data.points == 'success') {
                            $(".popup-message").html('your comment');
                            $(".popup").fadeIn('slow');
                            $(".add-comment-box").fadeOut();
                            $('html, body').animate({
                                scrollTop: $(".jscroll-inner").offset().top
                            },800);
                            setTimeout(function () {
                                $(".popup").fadeOut('slow');
                            }, 4000);
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error!\nLooks like you are logged out. Log in and try again.')
                }
            });
            return false;
        }

        function flagStory(from) {
            $("input[type=submit]").attr("disabled", "disabled");
            var postData = from.serializeArray();
            var formURL = from.attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    from[0].reset();
                    $("input[type=submit]").removeAttr("disabled");
                    if (data.code == 200) {
                        $('#flagModal').modal('toggle');
                        window.location = '{{route("app-stories")}}';
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error!\nLooks like you are logged out. Log in and try again.')
                }
            });
            return false;
        }

        function favAction(story_id, action) {
            if (action == 'Add') {
                $("#unfav-story-" + story_id).hide()
                $("#fav-story-" + story_id).fadeIn()
            } else {
                $("#fav-story-" + story_id).hide()
                $("#unfav-story-" + story_id).fadeIn()
            }

            var formURL = '{{route("app-add-fav-stories")}}/' + story_id + "/" + action;
            $.ajax({
                url: formURL,
                type: "get",
                success: function (data, textStatus, jqXHR) {
                    if (data.code == 200) {
                        if (action == 'Add') {
                            $("#unfav-story-" + story_id).hide()
                            $("#fav-story-" + story_id).fadeIn()
                        } else {
                            $("#fav-story-" + story_id).hide()
                            $("#unfav-story-" + story_id).fadeIn()
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error!\nLooks like you are logged out. Log in and try again.')
                }
            });
            return false;
        }

        function nominateAction(story_id, action) {
            var formURL = '{{route("app-add-nominated-stories")}}/' + story_id + "/" + action;
            $.ajax({
                url: formURL,
                type: "get",
                success: function (data, textStatus, jqXHR) {
                    if (data.code == 200) {
                        if (action == 'Add') {
                            $("#unnominate-story-" + story_id).fadeIn();
                            $("#nominate-story-" + story_id).hide();
                        } else {
                            $("#nominate-story-" + story_id).fadeIn();
                            $("#unnominate-story-" + story_id).hide();
                        }
                        if (data.points == 'success') {
                            $(".popup-message").html('nominating story');
                            $(".popup").fadeIn('slow');
                            setTimeout(function () {
                                $(".popup").fadeOut('slow');
                            }, 4000);
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error!\nLooks like you are logged out. Log in and try again.')
                }
            });
            return false;
        }
        function saveRating(currentRating){
            $("#yourRatedText").html("Thank you for your rating");
            $.ajax({
                type: 'POST',
                url: '{{route("app-rate-story")}}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "rate": currentRating,
                    "story": {{ $story->story_id}},
                },
                success: function (msg) {
                    if(currentRating > 1){
                        $(".popup-message").html('rating the story');
                        $(".popup").fadeIn(400);
                        setTimeout(function () {
                            $(".popup").fadeOut('slow');
                        }, 4000);
                    }
                }
            });
        }

        $(document).ready(function () {
            //Start Rating Code
            $(".my-rating").starRating({
                readOnly: {{$readOnly}},
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
                        if (currentRating > 1){
                            saveRating(currentRating);
                        }
                        else{  
                            Swal.fire({
                                title: 'Are you sure?',
                              text: " Are you sure you want to give this story a 1-star rating, the lowest rating possible. Writers may be both offended and deeply discouraged by it, and, if it is undeserved, Storystar Admin may consider it abusive and/or malicious, which could result in your being blocked from using Storystar. Do you still wish to give a 1-star rating?",
                              icon: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes, I am sure !'
                            }).then((result) => {
                                if(result.value){
                                    saveRating(currentRating);
                                }
                                else{
                                    $(".my-rating").starRating('setRating',0);
                                    $(".my-rating").starRating('setReadOnly', false);
                                }
                            });
                        }
                    }
                    else{
                        // In random cases the system is crashing to make sure the stars result for sure this code has been done. 
                        $(".my-rating").starRating('setRating',0);
                        $(".my-rating").starRating('setReadOnly', false);
                    }
                }
            });

            //Comments paginataion code
            $('ul.pagination').hide();
            $('.comments-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div style="text-align: center;padding-top: 20px;"><img class="center-block" src="{{app_assets("images/loader.gif")}}" alt="Loading..." /></div>',
                padding: 100,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.comments-scroll',
                callback: function () {
                    $('ul.pagination').remove();
                }
            });

            //Clip text show more Code
            $(".complete").hide();
            $(document).on('click', '.show-full', function (e) {
                e.preventDefault();
                $(this).parent().hide();
                $(this).parent().next().removeClass('hidden').fadeIn();
            });

            $(document).on('click', '.add-comment', function () {
                $(".add-comment-box").fadeIn();
                $('html, body').animate({
                    scrollTop: $(".add-comment-box").offset().top - 75
                }, 800);
            });

            $(document).on('click', '.reply-btn', function () {
                var comment_id = $(this).data('comment_id');
                $("#reply-" + comment_id).fadeIn();
            });

            //Load more reply code
            $(document).on('click', '.btn-more', function () {
                var id = $(this).data('id');
                var story_id = $(this).data('story_id');
                var parent_id = $(this).data('parent_id');
                $('#btn-more-' + story_id + "-" + parent_id).hide();
                $('#loader-' + story_id + "-" + parent_id).html('<div style="text-align: center;padding-top:0px;"><img class="center-block" src="{{app_assets("images/loader.gif")}}" alt="Loading..." /></div>')
                $.ajax({
                    url: '{{route('app-get-comments')}}',
                    method: "POST",
                    data: {id: id, story_id: story_id, parent_id: parent_id, _token: "{{csrf_token()}}"},
                    dataType: "JSON",
                    success: function (data) {
                        $('#loader-' + story_id + "-" + parent_id).remove();
                        if (data != '') {
                            $('#remove-row-' + story_id + "-" + parent_id).remove();
                            $('#load-data-' + story_id + "-" + parent_id).append(data.html);
                        } else {
                            $('#btn-more-' + story_id + "-" + parent_id).html("No Data");
                        }
                    }
                });
            });

            @if($alreadyRare!=0)
            $(".jq-star").hover(function () {
                var title = $(this).parent().attr("title");
                console.log(title);
                $(this).attr("title", title);
            });
            @endif
        });

        function favActionAuthor(user_id, action) {
            if (action == 'Add') {
                $("#unfav-user-" + user_id).hide()
                $("#fav-user-" + user_id).fadeIn()
            } else {
                $("#fav-user-" + user_id).hide()
                $("#unfav-user-" + user_id).fadeIn()
            }

            var formURL = '{{route("app-add-fav-author")}}/' + user_id + "/" + action;
            $.ajax({
                url: formURL,
                type: "get",
                success: function (data, textStatus, jqXHR) {
                    if (data.code == 200) {
                        if (action == 'Add') {
                            $("#unfav-user-" + user_id).hide()
                            $("#fav-user-" + user_id).fadeIn()
                        } else {
                            $("#fav-user-" + user_id).hide()
                            $("#unfav-user-" + user_id).fadeIn()
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //if fails
                }
            });

            return false;
        }

        $(document).on('click', '.gift-points', function (event) {
            event.preventDefault();
            var html = '';
            html += '<form style="width:80%; margin-top:-20px; margin-left:-100px;" id="form-update-points" role="form" method="POST" action="{{ route('app-gift-points') }}" novalidate class="form-horizontal">';
            html += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
            html += '<input type="hidden" name="to_user" value="' + $(this).data('user_id') + '"/>';
            html += '<input type="text" name="points" id="gift-points" placeholder=""' +
                'style="height:38px; width:60px; background:#F6FFBC; border:1px solid #3A93EC; margin-top:20px;"/>'
            html += '<button type="submit" class="btn btn-info" style="margin-top:-5px; height:37px; margin-left:10px;">Gift</button>';
            html += ' <span style="font-size:12px; background:white; padding:1px;">({!! isset(\Auth::user()->points) ? \Auth::user()->points : '' !!} available)</span>';
            html += '</form>';
            $(this).replaceWith(html);
        });
    </script>
@endpush

@push('meta-data')
    <meta name="title"
          content="{{decodeStr($story->story_title)}} - A short story by {{decodeStr($story->author_name)}}"/>
    <meta name="description"
          content="Written by {{decodeStr($story->author_name)}} of {{$story->author_address}}, {{$story->author_country}}, short story '{{decodeStr($story->story_title)}}' is listed as {{decodeStr($story->category->category_title)}} under Short stories for {{decodeStr($story->subcategory->sub_category_title)}} in the theme of {{decodeStr($story->theme->theme_title)}} stories, with the chosen subject of {{decodeStr($story->subject->subject_title)}}."/>
    <meta name="keywords"
          content="short story, short stories, read short stories online, {{decodeStr($story->category->category_title)}} story, {{decodeStr($story->theme->theme_title)}} story, {{decodeStr($story->story_title)}}, {{decodeStr($story->subject->subject_title)}}"/>
    <meta name="distribution" content="{{decodeStr($story->story_title)}}"/>
    <meta name="robots" content="index,follow"/>
    <meta name="language" content="en, gb"/>
@endpush

<?php
$width = 0;
$height = 0;
if (file_exists(storage_path() . '/story/' . $story->image)) {
    if (isset($story->image) && !empty($story->image)) {
        list($width, $height) = (getimagesize('storage/story/' . $story->image));
    }
}
?>
@push('social-meta')
    <meta property="og:title"
          content="{{decodeStr($story->story_title)}} - A short story by {{decodeStr($story->author_name)}}"/>
    <meta property="og:type" content="website"/>

    @if($story->image && $width >200 && $height > 200)
        <meta property="og:image" content="{{storage_url($story->image, 'story')}}"/>
    @else
        <meta property="og:image" content="https://www.storystar.com/assets/app/images/storystarcomfb.jpg"/>
    @endif

    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:description"
          content="Written by {{decodeStr($story->author_name)}} of {{$story->author_address}}, {{$story->author_country}}, short story '{{decodeStr($story->story_title)}}' is listed as {{decodeStr($story->category->category_title)}} under Short stories for {{decodeStr($story->subcategory->sub_category_title)}} in the theme of {{decodeStr($story->theme->theme_title)}} stories, with the chosen subject of {{decodeStr($story->subject->subject_title)}}."/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title"
          content="{{decodeStr($story->story_title)}} - A short story by {{decodeStr($story->author_name)}}"/>
    <meta name="twitter:description"
          content="Written by {{decodeStr($story->author_name)}} of {{$story->author_address}}, {{$story->author_country}}, short story '{{decodeStr($story->story_title)}}' is listed as {{decodeStr($story->category->category_title)}} under Short stories for {{decodeStr($story->subcategory->sub_category_title)}} in the theme of {{decodeStr($story->theme->theme_title)}} stories, with the chosen subject of {{decodeStr($story->subject->subject_title)}}."/>
    @if($story->image && $width >200 && $height > 200)
        <meta name="twitter:image" content="{{storage_url($story->image, 'story')}}"/>
    @else
        <meta property="twitter:image" content="https://www.storystar.com/assets/app/images/storystarcomfb.jpg"/>
    @endif

@endpush