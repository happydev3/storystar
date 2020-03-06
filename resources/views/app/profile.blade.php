@extends('app.layout.page')
@section('bodyContent')

    <style>
        .gift-container {
            width: 33%;
            margin-left: 52px;
            cursor: pointer;
            position: absolute;
        }

        .author-heading1 {
            margin-bottom: -45px;
        }

        @media only screen and (max-width: 1100px)
        {
            .pagination-boxes .pagination-left {
                width: 25%;
            }
        }

        @media (max-width: 1024px) and (min-width: 992px) {
            .author-heading1 {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 991px) and (min-width: 768px){
            .author-heading1 {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 767px) and (min-width: 320px){
            .author-heading1 {
                margin-bottom: 10px;
            }
        }

    </style>
    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <a name="profile"></a>
                        @if($paginator->count())
                            <h1 class="text-xs-center author-heading">AUTHOR PROFILE</h1>
                            <br/>
                            <br/>
                        @else
                            <h1 class="text-xs-center author-heading">READER PROFILE</h1>
                            <br/>
                            <br/>
                        @endif
                        <div class="new_border">
                            <div class="author-profile-box">
                                <div class="col-md-8" style="text-align: left;">
                                    <article class="">
                                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                            @if(Session::has('alert-' . $msg))
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

                                    <div class="author-name">
                                        <label>Name:</label>
                                        <span>{{strtoupper($author['name'])}}</span>

                                        @if(\Auth::user() && $author['user_id'] != \Auth::user()->user_id)
                                            <div class="author-heart-icon">
                                                <div class="gift-container">
                                                    <a style="position: absolute; left:14px;" class="gift-points"
                                                       data-user_id="{{$author['user_id']}}"
                                                       title="Gift points to {{strtoupper($author['name'])}}.">
                                                        <i class="fa fa-gift" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <a id="fav-user-{{$author['user_id']}}" href="javascript:void(0)"
                                                   onclick="favAction({{$author['user_id']}}, 'Remove')"
                                                   title="Remove {{strtoupper($author['name'])}} from favorite list."
                                                   style="{{$favAdded==0?'display: none;':''}}"
                                                >
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </a>
                                                <a id="unfav-user-{{$author['user_id']}}" href="javascript:void(0)"
                                                   onclick="favAction({{$author['user_id']}}, 'Add')"
                                                   title="Add {{strtoupper($author['name'])}} into favorite list."
                                                   style="{{$favAdded==1?'display: none;':''}}">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @else
                                            <div class="author-heart-icon">
                                                <a id="unfav-user-{{$author['user_id']}}" href="{{route("login")}}"
                                                   title="Add {{strtoupper($author['name'])}} into favorite list.">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="author-name">
                                        <label>Gender:</label>
                                        @php
                                            $auther_gender = 'N-A';
                                            if(!empty(trim($author->gender)))
                                            {
                                                $auther_gender = $author->gender;
                                            }
                                            else
                                            {

                                                foreach($paginator as $story):
                                                 if(!empty(trim($story->author_gender))){
                                                    $auther_gender = $story->author_gender;
                                                    break;
                                                 }
                                                endforeach;
                                            }
                                        @endphp
                                        <span>{{ $auther_gender }}</span>

                                    </div>


                                    <div class="author-name">
                                        <label>Birth year:</label>
                                        @php
                                            $auther_dob = 'N-A';
                                            if(!empty(trim($author->dob)))
                                            {
                                                $auther_dob = $author->dob;
                                            }
                                            else
                                            {

                                                foreach($paginator as $story):
                                                 if(!empty(trim($story->author_dob))){
                                                    $auther_dob = $story->author_dob;
                                                    break;
                                                 }
                                                endforeach;
                                            }
                                        @endphp
                                        <span>{{ $auther_dob }}</span>
                                    </div>

                                    <div class="author-name">
                                        <label>Region / Location:</label>
                                        @php
                                            $auther_address = 'N-A';
                                            if(!empty(trim($author->address)))
                                            {
                                                $auther_address = $author->address;
                                            }
                                            else
                                            {

                                                foreach($paginator as $story):
                                                 if(!empty(trim($story->author_address))){
                                                    $auther_address = $story->author_address;
                                                    break;
                                                 }
                                                endforeach;
                                            }
                                        @endphp

                                        <span>{{ $auther_address }}</span>
                                    </div>
                                    <div class="author-name">
                                        <label>Country:</label>
                                        @php
                                            $auther_country = 'N-A';
                                            if(!empty(trim($author->country)))
                                            {
                                                $auther_country = $author->country;
                                            }
                                            else
                                            {

                                                foreach($paginator as $story):
                                                 if(!empty(trim($story->author_country))){
                                                    $auther_country = $story->author_country;
                                                    break;
                                                 }
                                                endforeach;
                                            }
                                        @endphp
                                        <span>{{ $auther_country }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="img-border">


                                        @if($author['avatar'])

                                            @if(file_exists(storage_path().'/users/'.$author['avatar']))

                                                <?php
                                                $data = getimagesize(storage_path() . '/users/' . $author['avatar']);
                                                $imgWidth = $data[0];
                                                $imgHeight = $data[1];

                                                if ($imgWidth > 233 && $imgHeight > 233) {
                                                ?>
                                                <img src="{{Image::url(storage_url($author['avatar'],'users'), 233, 233, array('crop'))}}"
                                                     alt=""
                                                     class="img-fluid">
                                                <?php
                                                } else {

                                                $imgWidth = ceil($imgWidth + ($imgWidth * 0.50));
                                                $imgHeight = ceil($imgHeight + ($imgHeight * 0.50));
                                                ?>
                                                <img src="{{Image::url(storage_url($author['avatar'],'users'), $imgWidth, $imgHeight, array('crop'))}}"
                                                     alt=""
                                                     class="img-fluid">

                                                <?php
                                                }
                                                ?>


                                            @else
                                                <img class="img-fluid"
                                                     src="{{Image::url(storage_url('default.png', 'users'), 233, 233, array('crop'))}}"
                                                     alt="">
                                            @endif


                                        @else
                                            <img src="{{Image::url(storage_url("default.png",'users'), 233, 233, array('crop'))}}"
                                                 alt=""
                                                 class="img-fluid">
                                        @endif


                                    </div>
                                </div>
                                <div class="col-md-12 pb20 aboutme_text">

                                    @if($author['profile'])
                                        <div class="author-name">
                                            <label class="aboutme">About Me</label>
                                        </div>
                                        <p class="author-top-content" style="padding-top: 0;">
                                            {!! nl2br($author['profile']) !!}
                                        </p>
                                    @endif


                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <a name="stories"></a>
                        @if($paginator->count())
                            <h2 class="text-xs-center author-heading author-heading1">AUTHOR’S STORIES</h2>
                            <form id="storiesSearchFrm" action="" role="search">
                                <input type="hidden" name="sortby" id="sortby" value=""/>
                                <input type="hidden" name="sortby" id="sortby" value=""/>
                                <input type="hidden" id="limit" name="limit" value="">
                                <input type="submit" style="display: none"/>
                                <?php
                                $pageData['callFrom'] = 'UserProfile';
                                ?>
                                {{ $paginator->appends($pageData['queryString'])->render("app.components.pagination",["position"=>"top",'pageData'=>$pageData])}}
                                @include('app.components.fav-story')
                                {{ $paginator->appends($pageData['queryString'])->render("app.components.pagination",["position"=>"bottom",'pageData'=>$pageData])}}

                            </form>
                        @else
                            <br/>
                            <br/>
                            <br/>
                        @endif
                    </div>
                </div>
            </div>
            @include("app.components.footer")
        </div>
    </div>

    <!-- BEGIN # MODAL LOGIN -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <img class="img-circle" id="img_logo" src="http://bootsnipp.com/img/logo.jpg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>

                <!-- Begin # DIV Form -->
                <div id="div-forms">

                    <!-- Begin # Login Form -->
                    <form id="login-form">
                        <div class="modal-body">
                            <div id="div-login-msg">
                                <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-login-msg">Type your username and password.</span>
                            </div>
                            <input id="login_username" class="form-control" type="text" placeholder="Username (type ERROR for error effect)" required>
                            <input id="login_password" class="form-control" type="password" placeholder="Password" required>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                            </div>
                            <div>
                                <button id="login_lost_btn" type="button" class="btn btn-link">Lost Password?</button>
                                <button id="login_register_btn" type="button" class="btn btn-link">Register</button>
                            </div>
                        </div>
                    </form>
                    <!-- End # Login Form -->

                    <!-- Begin | Lost Password Form -->
                    <form id="lost-form" style="display:none;">
                        <div class="modal-body">
                            <div id="div-lost-msg">
                                <div id="icon-lost-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-lost-msg">Type your e-mail.</span>
                            </div>
                            <input id="lost_email" class="form-control" type="text" placeholder="E-Mail (type ERROR for error effect)" required>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
                            </div>
                            <div>
                                <button id="lost_login_btn" type="button" class="btn btn-link">Log In</button>
                                <button id="lost_register_btn" type="button" class="btn btn-link">Register</button>
                            </div>
                        </div>
                    </form>
                    <!-- End | Lost Password Form -->

                    <!-- Begin | Register Form -->
                    <form id="register-form" style="display:none;">
                        <div class="modal-body">
                            <div id="div-register-msg">
                                <div id="icon-register-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-register-msg">Register an account.</span>
                            </div>
                            <input id="register_username" class="form-control" type="text" placeholder="Username (type ERROR for error effect)" required>
                            <input id="register_email" class="form-control" type="text" placeholder="E-Mail" required>
                            <input id="register_password" class="form-control" type="password" placeholder="Password" required>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                            </div>
                            <div>
                                <button id="register_login_btn" type="button" class="btn btn-link">Log In</button>
                                <button id="register_lost_btn" type="button" class="btn btn-link">Lost Password?</button>
                            </div>
                        </div>
                    </form>
                    <!-- End | Register Form -->

                </div>
                <!-- End # DIV Form -->

            </div>
        </div>
    </div>
    <!-- END # MODAL LOGIN -->

    <script>
        //Clip text show more Code
        $(document).on('click', '.show-full', function () {
            $(this).parent().hide();
            $(this).parent().next().fadeIn();
        });

        function favAction(user_id, action) {


            if (action == 'Add') {
                $("#unfav-user-" + user_id).hide()
                $("#fav-user-" + user_id).fadeIn()
            }
            else {
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
                        }
                        else {
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

        $.fn.loop = function (callback, thisArg) {
            var me = this;
            return this.each(function (index, element) {
                return callback.call(thisArg || element, element, index, me);
            });
        };

        $(document).on('click', '.story-link', function (event) {
            event.preventDefault();
            window.location = $(this).attr("href") + "#stories";
        });

        $(document).on('click', '.gift-points', function (event) {
            event.preventDefault();
            var html = '';
            html += '<form style="width:80%; margin-top:-8px;" id="form-update-points" role="form" method="POST" action="{{ route('app-gift-points') }}" novalidate class="form-horizontal">';
            html += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
            html += '<input type="hidden" name="to_user" value="'+$(this).data('user_id')+'"/>';
            html += '<input type="text" name="points" id="gift-points" placeholder=" "' +
                'style="height:38px; width:60px; background:#F6FFBC; border:1px solid #3A93EC; margin-top:20px;"/>'
            html += '<button type="submit" class="btn btn-info" style="margin-top:-5px; height:37px; margin-left:10px;">Gift</button>';
            html += ' ({!! isset(\Auth::user()->points) ? \Auth::user()->points : '0' !!} available)';
            html += '</form>';
            $(this).replaceWith(html);
        });
    </script>
@endsection

<?php
$width = 0;
$height = 0;

if ($author['avatar']) {
    if (file_exists(storage_path() . '/users/' . $author['avatar'])) {
        if (isset($author['avatar']) && !empty($author['avatar'])) {
            list($width, $height) = (getimagesize('storage/users/' . $author['avatar']));
        }
    }
}
?>

@push('social-meta')

    @if($author['avatar'] && $width >200 && $height > 200)
        <meta property="og:image" content="{{storage_url($author['avatar'],'users')}}"/>
        <meta name="twitter:image" content="{{storage_url($author['avatar'],'users')}}"/>
    @else
        <meta property="og:image" content="https://www.storystar.com/storage/users/default.png"/>
        <meta property="twitter:image" content="https://www.storystar.com/storage/users/default.png"/>
    @endif

@endpush

