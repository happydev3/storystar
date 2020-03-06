@extends('app.layout.page')
@section('bodyContent')

    <style>
        .points-history-table {
            width: 70%;
        }

        .points-history-table td {
            border-top: 2px solid #2B75B3;
            border-bottom: 2px solid #2B75B3;
            width: 50%;
            text-align: center;
            color: #07588D;
        }

        .accordion {
            /*font-family: 'CaturritaBoldDisplay';*/
            color: #07588D;
            padding: 10px;
            width: 100%;
            border: none;
            background-color: #F0F3F6;
            border-bottom: 2px solid #2C709D;
            text-align: left;
            outline: none;
            font-size: 18px;
        }

        .accordion-btn-left {
            float: left;
        }

        .accordion-btn-right {
            float: right;
        }

        .accordion-pointer {
            cursor: pointer;
        }

        .accordion:nth-of-type(1) {
            border-top: 2px solid #2C709D;
        }

        .accordion:last-child {
            border-bottom: 0px;
            color: black;
            font-weight: bolder;
            font-size: 20px;
        }

        .accordion-pointer:hover {
            color: #02A6EE;
            font-weight: bold;
        }

        .panel {
            background-color: white;
            max-height: 0;
            overflow: auto;
        }

        .points-table {
            /*font-family: 'CaturritaBoldDisplay';*/
            color: #07588D;
            width: 100%;
            border-bottom: 1px solid;

        }

        .points-table td, th {
            padding: 5px;
            font-size: 14px;
            color: black;
        }

        .points-table th {
            font-size: 16px;
            font-weight: bold;
        }

        .points-table td {
            font-size: 14px;
            font-weight: normal;
        }

        .points-table td:nth-of-type(1), .points-table th:nth-of-type(1) {
            width: 60%;
        }

        .points-table td:nth-of-type(2), .points-table th:nth-of-type(2) {
            width: 20%;
        }

        .points-table td:nth-of-type(3), .points-table th:nth-of-type(3) {
            width: 20%;
        }

        .h6-heading {
            font-weight: bold;
            margin-left: 10px !important;
        }

        .bold-text {
            font-weight: bolder;
        }

        .story-box-label {
            margin-left: 90px;
        }

        @media only screen and (min-width: 300px) and (max-width: 800px) {
            .story-box-label {
                margin-left: 0px;
            }
            .upgrade-button {
                font-size: 8px !important;
            }
        }

    </style>

    <div class="container account_setting">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">


                        <h1 class="text-xs-center author-heading text-uppercase" style="margin-bottom: 25px">My Storystar</h1>
                        <div class="publishstory-boxes">

                            @if (Auth::user()->is_author == 1)
                            @else

                                {{--<a href="#" class="my-stories">Profile Set-Up Info</a>--}}
                                <div style="display: none">
                                    <h1 class="text-xs-center author-heading text-uppercase">Welcome to Storystar!</h1>
                                    <p> You can create a profile for yourself here. You can also keep lists of your
                                        favorite stories and authors.
                                        When you create a profile, whatever picture or information you provide will be
                                        linked to and displayed whenever you comment on a story.
                                        Note that if you are a WRITER then you should start by clicking the Publish
                                        Story link and submitting your author info along with your first story. Then you
                                        can create your Author Profile. A link to your Author Profile will then appear
                                        on your story, and all your future stories. And wherever your name appears on
                                        Storystar, such as in 'Read Stories' lists, and comments, it will be a clickable
                                        link to your profile and all of your stories.</p>
                                </div>
                            @endif

                        <!-- NEW WIDGET START -->
                            <article class="">

                                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                    @if(Session::has('alert-' . $msg))

                                        <div class="alert alert-{{ $msg }} fade in">
                                            <button class="close" data-dismiss="alert">
                                                ×
                                            </button>

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
                            <!-- WIDGET END -->

                            <?php
                            // Check if user is update his/her email. And account goes to inactive
                            $user = \Auth::user();
                            $link = "";
                            if (!isset($user->active) || empty($user->active)) {
                            $link = "An email with a link to verify your account has been sent to you. Please look into the junk box if it does not appear in your inbox. Click ";
                            $link .= "<a style='color: #07588d;text-decoration: underline;' href='" . route("resend.email.account",
                                    ['email' => $user->email]) . "'>";
                            $link .= "here";
                            $link .= "</a>";
                            $link .= " to resend";
                            ?>
                            <div class="alert alert-warning fade in">
                                <button class="close" data-dismiss="alert">
                                </button>
                                {!! $link !!}.
                            </div>
                            <?php
                            }

                            $accountSetting = $updatePassword = $pointsDetail = $pointsUsage = $pointsHistory =$profileSetup= false;
                            $pageName = \Request::route()->getName();

                            if ($pageName == "app-account"):
                                $accountSetting = true;
                            elseif ($pageName == "app-update-password-form"):
                                $updatePassword = true;
                            elseif ($pageName == "app-points-detail"):
                                $pointsDetail = true;
                            elseif ($pageName == "app-points-history"):
                                $pointsHistory = true;
                            elseif ($pageName == "app-points-usage"):
                                $pointsUsage = true;
                            elseif ($pageName == "app-profile-setup"):
                                $profileSetup = true;
                            endif;

                            ?>
                            <div class="our-story-info-box margin-bottom-remove">
                                <div class="tabs">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">

                                        @if(Auth::user()->is_author ==1)
                                        @else
                                            <li class="nav-item">
                                                <a id="pills-profile-tab" href="{{route('app-profile-setup')}}">
                                                    <h1 class="story-info-title <?=($profileSetup) ? "active" : ""?>">
                                                        <span>Profile Set-Up Info</span>
                                                    </h1>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a id="pills-home-tab" href="{{route("app-account")}}">
                                                <h1 class="story-info-title <?=($accountSetting) ? "active" : ""?>">
                                                    <span>My Profile</span>
                                                </h1>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="pills-profile-tab" href="{{route("app-update-password-form")}}">
                                                <h1 class="story-info-title <?=($updatePassword) ? "active" : ""?>">
                                                    <span>Change Password</span>
                                                </h1>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a id="pills-profile-tab" href="{{route("app-points-detail")}}">
                                                <h1 class="story-info-title <?=($pointsDetail || $pointsHistory || $pointsUsage) ? "active" : ""?>">
                                                    <span>My Points</span>
                                                </h1>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        @if($updatePassword)
                                            <form id="form-change-password" role="form" method="POST"
                                                  action="{{ route('app-update-password') }}" novalidate
                                                  class="form-horizontal">
                                                <div class="form-select-boxes margin-bottom-remove">
                                                    <div class="form-select-left clearfix">
                                                        <label class="title-padding">Current Password</label>
                                                        <div
                                                            class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}">
                                                            <input type="password" class="custom-select custom-input"
                                                                   id="current-password"
                                                                   name="current-password" placeholder="Password">
                                                            @if ($errors->has('current-password'))
                                                                <em id="current-password-error"
                                                                    class="invalid">{{ $errors->first('current-password') }}</em>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-select-left clearfix">
                                                        <label class="title-padding">New Password</label>
                                                        <div
                                                            class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                            <input type="password" class="custom-select custom-input"
                                                                   id="password"
                                                                   name="password"
                                                                   placeholder="Password">
                                                            @if ($errors->has('password'))
                                                                <em id="password-error"
                                                                    class="invalid">{{ $errors->first('password') }}</em>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-select-left clearfix">
                                                        <label class="title-padding">Confirm Password</label>
                                                        <div
                                                            class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                            <input type="password" class="custom-select custom-input"
                                                                   id="password_confirmation"
                                                                   name="password_confirmation"
                                                                   placeholder="Re-enter Password">
                                                            @if ($errors->has('password_confirmation'))
                                                                <em id="password_confirmation-error"
                                                                    class="invalid">{{ $errors->first('password_confirmation') }}</em>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-select-left btn-style clearfix">
                                                        <div class="text-xs-center btn btn-readstory publish-btn">
                                                            <button type="submit" class="btn btn-danger">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            @if($jsValidation == true)
                                                {!! $validator !!}
                                            @endif
                                        @endif

                                        @if($accountSetting)
                                            <?php
                                            $user = \Auth::user();
                                            $isAuthor = isset($user->is_author) && !empty($user->is_author) ? 1 : 0;
                                            ?>
                                            <form action="{{ route('ajaxImageUpload') }}"
                                                  id="profile-pic-frm"
                                                  enctype="multipart/form-data" method="POST">
                                                <div class="alert alert-danger print-error-msg" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button id="uploadBtn" type="submit" style="display: none"></button>
                                                <div class="profile-img text-center" style="position: relative">
                                                    <div id="loader" class="lds-dual-ring"></div>
                                                    @if($user->avatar)
                                                        <img id="avatarImage" alt="..."
                                                             data-src="{{Image::url(storage_url($user->avatar,'users'), 212, 212, array('crop'))}}"
                                                             width="75" height="75">
                                                    @else
                                                        <img id="avatarImage" alt="..."
                                                             data-src="{{Image::url(storage_url("default.png",'users'), 212, 212, array('crop'))}}"
                                                             width="75" height="75">
                                                    @endif
                                                </div>
                                                <div class="choose-file text-center">
                                                    <div class="up_error">
                                                        <label class="custom-file-upload">
                                                            <input type="file" name="image" id="image"
                                                                   class="input-profile-pic"
                                                                   accept="image/*">Upload Pic
                                                        </label>
                                                    </div>
                                                    @if ($errors->has('avatar'))
                                                        <em id="avatar-error"
                                                            class="invalid">{{ $errors->first('avatar') }}</em>
                                                    @endif
                                                </div>
                                            </form>
                                            <form id="form-change-password" role="form" method="POST"
                                                  action="{{ route('app-update-account') }}" novalidate
                                                  class="form-horizontal" enctype="multipart/form-data">
                                                <div class="form-select-boxes margin-bottom-remove">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="profile-img text-center" style="display: none">
                                                        @if($user->avatar)
                                                            <img alt="..."
                                                                 data-src="{{Image::url(storage_url($user->avatar,'users'), 212, 212, array('crop'))}}"
                                                                 width="75" height="75">
                                                        @else
                                                            <img alt="..."
                                                                 data-src="{{Image::url(storage_url("default.png",'users'), 212, 212, array('crop'))}}"
                                                                 width="75" height="75">
                                                        @endif
                                                    </div>
                                                    <div class="choose-file text-center" style="display: none">
                                                        <div class="up_error">
                                                            <label class="custom-file-upload">
                                                                <input type="file" name="avatar" id="avatar"
                                                                       class="input-profile-pic"
                                                                       accept="image/*">Upload Pic
                                                            </label>
                                                        </div>
                                                        @if ($errors->has('avatar'))
                                                            <em id="avatar-error"
                                                                class="invalid">{{ $errors->first('avatar') }}</em>
                                                        @endif
                                                    </div>
                                                    <div class="form-select-left clearfix">
                                                        <label class="title-padding">Name</label>
                                                        <div
                                                            class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove control1">
                                                            <input type="text" class="custom-select custom-input"
                                                                   id="name" name="name"
                                                                   placeholder="Name"
                                                                   maxlength="35"
                                                                   title="
                                                                    <?=isset($user->name) && !empty($user->name) ? 'You can\'t update the name."' : "max 35 characters"?>"
                                                                   <?=isset($user->name) && !empty($user->name) ? 'disabled="disabled"' : ""?>
                                                                   value="{{ucfirst($user->name)}}"
                                                            >
                                                            @if ($errors->has('name'))
                                                                <em id="name-error" class="invalid">
                                                                    {{ $errors->first('name') }}
                                                                </em>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-select-left clearfix">
                                                        <label class="title-padding">Email</label>
                                                        <div
                                                            class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove control1">
                                                            <input type="text" class="custom-select custom-input"
                                                                   name="email" id="email"
                                                                   placeholder="Email"
                                                                   value="{{$user->email}}">
                                                            @if ($errors->has('email'))
                                                                <em id="email"
                                                                    class="invalid">{{ $errors->first('email') }}</em>
                                                            @endif
                                                            <span class="email_text">
                                                                Please note that a change in your email address will require verification, so please be sure you can receive our emails before you change your email. Thanks.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-select-left clearfix">
                                                        <label class="title-padding">About Me</label>
                                                        <div
                                                            class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove control1">
                                                            <span>
                                                            <textarea type="text" class="custom-input"
                                                                      id="profile" name="profile"
                                                                      placeholder="About me"
                                                                      rows="5"
                                                                      maxlength="10000"
                                                                      onkeyup="countChar(this,10000)"
                                                            >{{ucfirst($user->profile)}}</textarea>

                                                                You have
                                                                <span id="charNum">
                                                                    <?php
                                                                    $profile = isset($user->profile) && !empty($user->profile) ? $user->profile : '';
                                                                    $profile = str_replace("\r\n", "\n", $profile);
                                                                    $profile = str_replace("\r", "\n", $profile);
                                                                    echo(10000 - strlen($profile));
                                                                    ?>
                                                                </span>
                                                                characters remaining
                                                                </span>

                                                            @if ($errors->has('profile'))
                                                                <em id="name-error"
                                                                    class="invalid">{{ $errors->first('profile') }}</em>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="becomeAuthor" value="1">

                                                    <div id="author-block">

                                                        @if(isset($user->gender)&&!empty($user->gender))
                                                            <input type="hidden" name="gender"
                                                                   value="{{$user->gender}}">
                                                        @else
                                                            <div class="form-select-left clearfix">
                                                                <label class="title-padding">Gender</label>
                                                                <?php
                                                                $user->gender = isset($user->gender) && !empty($user->gender) ? $user->gender : old('gender');
                                                                ?>
                                                                <div
                                                                    class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                <span>
                                                                <label class="control control1 control--radio">
                                                                    Male
                                                                    <input type="radio" name="gender" value="Male"
                                                                    <?= $user->gender == 'Male' ? 'checked' : '';?>>
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                                <label class="control control1 control--radio">
                                                                    Female
                                                                    <input type="radio" name="gender" value="Female"
                                                                    <?= $user->gender == 'Female' ? 'checked' : '';?>>
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                                   <label class="control control1 control--radio">
                                                                    Unspecified
                                                                    <input type="radio" name="gender"
                                                                           value="Unspecified"
                                                                    <?= $user->gender == 'Unspecified' ? 'checked' : '';?>>
                                                                    <div class="control__indicator"></div>
                                                                </label>
                                                                </span>
                                                                    @if ($errors->has('gender'))
                                                                        <em id="gender-error" class="invalid">
                                                                            {{ $errors->first('gender') }}
                                                                        </em>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="form-select-left clearfix">
                                                            <label class="title-padding">Birth year:</label>
                                                            <div
                                                                class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                <input type="text"
                                                                       class="custom-select custom-input"
                                                                       placeholder="Year of birth" name="dob"
                                                                       id="dob"
                                                                       <?php /* title="
                                                                          <?=isset($user->dob) && !empty($user->dob) ? 'You can\'t update dob."' : ""?>"
                                                                           <?=isset($user->dob) && !empty($user->dob) ? 'disabled="disabled"' : ""?>
                                                                           */
                                                                       ?>
                                                                       value="{{isset($user->dob)&&!empty($user->dob)?$user->dob:old('dob')}}">
                                                                @if ($errors->has('dob'))
                                                                    <em id="address-error"
                                                                        class="invalid">{{ $errors->first('dob') }}</em>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-select-left clearfix">
                                                            <label class="title-padding">Region / Location</label>
                                                            <div
                                                                class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                <input type="text"
                                                                       class="custom-select custom-input"
                                                                       placeholder="Region / Location" name="address"
                                                                       id="address"
                                                                       title="
                                                                          <?=isset($user->address) && !empty($user->address) ? 'You can\'t update the address."' : ""?>"
                                                                       <?=isset($user->address) && !empty($user->address) ? 'disabled="disabled"' : ""?>
                                                                       value="{{isset($user->address)&&!empty($user->address)?$user->address:old('address')}}">

                                                                @if ($errors->has('address'))
                                                                    <em id="address-error"
                                                                        class="invalid">{{ $errors->first('address') }}</em>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="form-select-left clearfix mt5">
                                                                <label>Country</label>
                                                                <div
                                                                    class="pagination-left select-boxes-part-four remove-margin-right publish-select rm">
                                                                    <select
                                                                        title="<?=isset($user->country) && !empty($user->country) ? 'You can\'t update country."' : ""?>"
                                                                        <?=isset($user->country) && !empty($user->country) ? 'disabled="disabled"' : ""?>
                                                                        style="width: 100%; padding: 8px;"
                                                                        name="country" id="country">
                                                                        <?php
                                                                        $countries = getCountries();
                                                                        $selectedCountry = isset($user->country) && !empty(($user->country)) ? $user->country : old('country');

                                                                        echo '<option value=""> Select Country</option>';

                                                                        foreach ($countries as $k => $country):
                                                                            if ($selectedCountry == $k) {
                                                                                echo '<option value="' . $k . '" selected="selected">' . $country . '</option>';
                                                                            } else {
                                                                                echo '<option value="' . $k . '">' . $country . '</option>';
                                                                            }
                                                                        endforeach;

                                                                        ?>
                                                                    </select>

                                                                    @if ($errors->has('country'))
                                                                        <em id="country-error"
                                                                            class="invalid">{{ $errors->first('country') }}</em>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-select-left btn-style clearfix">
                                                        <div class="text-xs-center btn btn-readstory publish-btn">
                                                            <button type="submit" class="btn btn-danger">Update</button>
                                                        </div>
                                                    </div>
                                                    @if (Auth::user()->is_author == 1)
                                                        <div class="text-center my-stories">
                                                            <a href="{{route('app-profile',['user_id'=>$user->user_id,'user_name'=>str_slug($user->name)])}}#stories">
                                                                View My Stories
                                                            </a>

                                                        </div>
                                                    @else
                                                        <div class="text-center my-stories">
                                                            <a href="/publish-story">
                                                                Publish story
                                                            </a>

                                                        </div>
                                                    @endif

                                                    @if(\App\Models\SiteUser::find(Auth::user()->user_id)->favorite_authors()->count()>0)
                                                        <div class="text-center my-stories">
                                                            <a href="{{route('app-fav-authors')}}">
                                                                View My Favorite Authors
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if(\App\Models\SiteUser::find(Auth::user()->user_id)->favorite_stories()->count()>0)
                                                        <div class="text-center my-stories">
                                                            <a href="{{route('app-fav-stories')}}">
                                                                View My Favorite Stories
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                            @if($jsValidation == true)
                                                {!! $validator !!}
                                            @endif
                                        @endif

                                        @if($pointsDetail)
                                            <div class="our-story-info-box">
                                                <div class="story-info-title">
                                                    <h2>Total : <?php echo Auth::user()->points; ?></h2>
                                                    @if($history)
                                                        <a href="{{ route('app-points-history') }}">(History)</a>
                                                    @endif
                                                </div>
                                                <div class="stories-box" style="height: 400px; overflow: auto;">
                                                    <h6 class="h6-heading" style="margin-left: 12px;">About Storystar
                                                        Reward Points :</h6>
                                                    <p>
                                                        The new points system has been created as a benefit for both readers and writers in order to encourage greater participation on the site, and as a way to reward those who enhance the Storystar experience for everyone. The more points you accumulate, the more rewards and spending power you can potentially earn. And for those who may not desire rewards, but want to contribute toward making Storystar better for everyone, we have provided a way for you to gift your points to others so that everyone can benefit.
                                                        <br/>
                                                        <br/>
                                                    </p>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">HOW EVERYONE CAN
                                                        EARN POINTS:</h6>
                                                    <ul>
                                                        <li><p>Rate a story (Note that 1 star ratings don't count): 5
                                                                points</p></li>
                                                        <li><p>New comment on a story: 5 points</p></li>
                                                        <li><p>Comment on Admin blog post: 5 points</p></li>
                                                        <li><p>Nominate a story for the Brightest Stars Anthology: 10
                                                                points<br/>(The more an author's stories are nominated the more chances they have to be published in an anthology. The points earned through nominating a story can be applied toward purchase of the anthology once it is published.) </p></li>
                                                        <li><p><br/></p></li>
                                                    </ul>
                                                    <br/>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">HOW WRITERS CAN
                                                        EARN POINTS:</h6>
                                                    <ul>
                                                        <li><p>Story is rated 4 stars or higher: 5 points</p></li>
                                                        <li><p>Story receives new comment: 5 points</p></li>
                                                        <li><p>Writer replies to a comment recieved on the story: 10 points</p></li>
                                                        <li><p>Story nominated for the Brightest Stars Anthology: 10
                                                                points</p></li>
                                                        <li><p>Story is chosen for front page featured for the day: 25
                                                                points</p></li>
                                                        <li><p>Story is chosen for front page featured for the week: 100
                                                                points</p></li>
                                                        <li><p>Writer is chosen for front page featured for the month:
                                                                500 points</p></li>
                                                        <li><p><br/></p></li>
                                                    </ul>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">HOW POINTS CAN BE
                                                        USED: (Note: 100 points = $1.00 USD)</h6>
                                                    <ol>
                                                        <li><p><span class="bold-text">1. Entering contests:</span> You can enter your own story, or someone else's story, into a writing contest and use your points to pay the contest entry fees. 500 points = $5.00 USD</p></li>
                                                        <li><p><span class="bold-text">2. Storystar's Brightest Stars Short Story Collection (Coming Soon):</span>
                                                                We are planning to publish anthologies of the best short stories on Storystar. When the new anthology is published you will be able to purchase copies with your points.</p></li>
                                                        <li><p><span class="bold-text">3. Gifting points:</span> When you have accumulated 100 points or more, you can gift your points to other users. There is a gift icon next to each person's name. For writers it is next to their name on all their stories and their Author Profile. When you click on the gift icon next to their name, just enter how many points you wish to gift them (100 or more), click 'gift', and the points will automatically be added to that person's total and deducted from yours. The gift will be documented in both of your 'My Points' history, which is found in your Storystar user profile.
                                                                <br/>
                                                                <br/>
                                                                (Note that in order to gift points to a reader, the reader must have created a Reader Profile, and then placed a comment on a story. When their name appears for a comment they have made, it will also be a link to their profile. Just click on their name to get to their profile, where there will be a gift box icon you can use.)
                                                            </p></li>
                                                        <li><p><br/></p></li>
                                                    </ol>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">PLEASE NOTE:</h6>
                                                    <p>
                                                        We hope the new reward points will be a fun benefit for everyone and increase the participation level throughout Storystar. However, we know it is possible for some people to abuse the points system by leaving bogus ratings and comments on stories they have not read. We will be watching and if we discover that someone has abused their rewards privileges their points will be removed by Admin and/or the user's account may be deleted and blocked from use of Storystar.<br/>
                                                        If you have questions or concerns about the Storystar Rewards system, or wish to report a user you believe is abusing the system, please send us an email at: admin@storystar.com. <br>
                                                        Thank you.
                                                    </p>
                                                </div>
                                                @if (\Auth::user()->is_premium == 0)
                                                <div class="stories-box">
                                                    <div class="your-story-text" style="padding: 20px; color: black;">
                                                         You can use your points to pay for Premium Membership. With Premium Membership you will enjoy an ads-free Storystar whenever you are logged in. And all Premium members will be given first dibs when we publish our limited edition ten year anniversary anthology of the best short stories on Storystar. Sign up now with 1200 points. (If you don't have enough points you can wait till you earn them, or you can just sign up with paypal immediately by paying $12. 
                                                         If you want to upgrade to premium membership with paypal, Please <a href="https://www.paypal.me/storystar1" target="blank"><span style="font-weight: 700;">click here.</span></a>)
                                                    </div>
                                                    <p class="your-story-content" style="text-align:center !important; margin-bottom: -50px;">
                                                        Note : 1200 points will be deducted from your total.
                                                    </p>

                                                    <form id="form-update-points" role="form" method="POST"
                                                          action="{{ url('/premium-with-point') }}" novalidate
                                                          class="form-horizontal">
                                                        <div class="form-select-boxes margin-bottom-remove">
                                                            <div class="form-select-left clearfix">
                                                                <div
                                                                    class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-select-left btn-style clearfix">
                                                                <div
                                                                    class="text-xs-center btn btn-readstory publish-btn">
                                                                    <button type="submit" class="btn btn-danger upgrade-button">
                                                                        Upgrade To Premium membership
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                @endif
                                                @if (\Auth::user()->is_author == 1 && ($stories))
                                                    <div class="stories-box">
                                                        <div class="your-story-text">
                                                            &nbsp;&nbsp; Use your points to enter into the contest. Just
                                                            select your story
                                                            and hit submit
                                                        </div>
                                                        <p class="your-story-content">
                                                            Note : 500 points will be deducted from your total.
                                                        </p>

                                                        <form id="form-update-points" role="form" method="POST"
                                                              action="{{ route('app-enter-contest') }}" novalidate
                                                              class="form-horizontal">
                                                            <div class="form-select-boxes margin-bottom-remove">
                                                                <div class="form-select-left clearfix">
                                                                    <label
                                                                        class="title-padding story-box-label">Story</label>
                                                                    <div
                                                                        class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                        <input type="hidden" name="_token"
                                                                               value="{{ csrf_token() }}">
                                                                        <select style="width: 100%; padding: 8px;"
                                                                                name="story" id="story">
                                                                            @foreach($stories as $k => $v)
                                                                                <option
                                                                                    value="{!! $k !!}">{!! $v !!}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-select-left btn-style clearfix">
                                                                    <div
                                                                        class="text-xs-center btn btn-readstory publish-btn">
                                                                        <button type="submit" class="btn btn-danger">
                                                                            Submit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @else
                                                    {{--<div class="stories-box">
                                                        <div class="your-story-text">
                                                            &nbsp;&nbsp; Promote an authors story by nominating it for a contest.
                                                        </div>
                                                        <p class="your-story-content">
                                                            Note : You need to have at least 100 points.
                                                        </p>

                                                        <form id="form-update-points" role="form" method="POST"
                                                              action="{{ //route('app-nominate-story') }}" novalidate
                                                              class="form-horizontal">
                                                            <div class="form-select-boxes margin-bottom-remove">
                                                                <div class="form-select-left clearfix">
                                                                    <label class="title-padding">Author</label>
                                                                    <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <select style="width: 100%; padding: 8px;" name="author" id="author">
                                                                            @foreach($authors as $k => $v)
                                                                                <option value="{!! $k !!}">{!! $v !!}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-select-left clearfix">
                                                                    <label class="title-padding">Story</label>
                                                                    <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <select style="width: 100%; padding: 8px;" name="story" id="author-story">
                                                                            @foreach($stories as $k => $v)
                                                                                <option value="{!! $k !!}">{!! $v !!}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-select-left btn-style clearfix">
                                                                    <div class="text-xs-center btn btn-readstory publish-btn">
                                                                        <button type="submit" class="btn btn-danger">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>--}}
                                                @endif

                                                @if(Session::has('error-message'))
                                                    {!! Session::get('error-message') !!}
                                                @endif
                                            </div>
                                        @endif

                                        @if($pointsUsage)
                                            <div class="our-story-info-box">
                                                <div class="story-info-title">
                                                    <h2>Benefits</h2>
                                                    <a href="{{ route('app-points-detail') }}">(Back)</a>
                                                </div>
                                                <div class="stories-box">
                                                    <h6 class="h6-heading" style="margin-left: 12px;">About Storystar
                                                        Reward Points :</h6>
                                                    <p>
                                                        The new points system has been created as a benefit for both
                                                        readers and writers in order to
                                                        encourage greater participation on the site, and as a way to
                                                        reward those who enhance the
                                                        Storystar experience for everyone. The more points you
                                                        accumulate, the more rewards and
                                                        spending power you can potentially earn. And for those who may
                                                        not desire rewards, but
                                                        want to contribute toward making Storystar better for everyone,
                                                        we have provided a way for you to gift your points to others
                                                        so that everyone can benefit.
                                                        <br/>
                                                        <br/>
                                                    </p>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">HOW EVERYONE CAN
                                                        EARN POINTS:</h6>
                                                    <ul>
                                                        <li><p>Rate a story (Note that 1 star ratings don't count): 5
                                                                points</p></li>
                                                        <li><p>New comment on a story: 5 points</p></li>
                                                        <li><p>Comment on Admin blog post: 5 points</p></li>
                                                        <li><p>Nominate a story for the Brightest Stars Anthology: 10
                                                                points</p></li>
                                                        <li><p><br/></p></li>
                                                    </ul>
                                                    <br/>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">HOW WRITERS CAN
                                                        EARN POINTS:</h6>
                                                    <ul>
                                                        <li><p>Story is rated 4 stars or higher: 5 points</p></li>
                                                        <li><p>Story receives new comment: 5 points</p></li>
                                                        <li><p>Story nominated for the Brightest Stars Anthology: 10
                                                                points</p></li>
                                                        <li><p>Story is chosen for front page featured for the day: 25
                                                                points</p></li>
                                                        <li><p>Story is chosen for front page featured for the week: 100
                                                                points</p></li>
                                                        <li><p>Writer is chosen for front page featured for the month:
                                                                500 points</p></li>
                                                        <li><p><br/></p></li>
                                                    </ul>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">HOW POINTS CAN BE
                                                        USED: (Note: 100 points = $1.00 USD)</h6>
                                                    <ol>
                                                        <li><p><span class="bold-text">1. Entering contests:</span> You
                                                                can enter your own story, or someone else's story, into
                                                                a writing contest and use your points to pay the contest
                                                                entry fees. 500 points = $5.00 USD</p></li>
                                                        <li><p><span class="bold-text">2. Storystar's Brightest Stars Short Story Collection (Coming Soon):</span>
                                                                We are planning to publish anthologies of the best short
                                                                stories on Storystar. You can nominate your own story,
                                                                or someone else's story, for anthology consideration and
                                                                use your points to pay the submission fee of $5. per
                                                                story. The more an author's stories are
                                                                entered/nominated the more chances they have to be
                                                                published in an anthology.</p></li>
                                                        <li><p><span class="bold-text">3. Gifting points:</span> When
                                                                you have accumulated 100 points or more, you can gift
                                                                your points to other users. There is a gift icon next to
                                                                each person's name in their reader or writer profile. A
                                                                profile is automatically created for every person who
                                                                publishes a story or who comments on a story, so you can
                                                                find their profile by clicking on their name or profile
                                                                link, then enter how many points you wish to gift them
                                                                when you click on the gift box icon.</p></li>
                                                        <li><p><br/></p></li>
                                                    </ol>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">COMING SOON:</h6>
                                                    <p>
                                                        We are busy creating new opportunities for you to spend your
                                                        reward points. When the new anthology is published you will be
                                                        able to purchase copies with your points. We also are working on
                                                        an exclusive subscription service which will offer readers
                                                        exclusive access to the best stories and novels that they will
                                                        not be able to find anywhere else, and will provide an income
                                                        for Storystar writers.
                                                        Other projects are in the works. If you have an idea that you
                                                        think could benefit Storystar writers and/or readers in the
                                                        future, please send us an email at: admin@storystar.com. Thank
                                                        you.
                                                        <br/>
                                                        <br/>
                                                    </p>
                                                    <h6 class="h6-heading" style="margin-left: 12px;">PLEASE NOTE:</h6>
                                                    <p>
                                                        We hope the new reward points will be a fun benefit for everyone
                                                        and increase the participation level throughout Storystar.
                                                        However, we know it is possible for some people to abuse the
                                                        points system by leaving bogus ratings and comments on stories
                                                        they have not read. We will be watching and if we discover that
                                                        someone has abused their rewards privileges their points will be
                                                        removed by Admin.<br/>
                                                        If you have questions or concerns about the Storystar Rewards
                                                        system, or wish to report a user you believe is abusing the
                                                        system, please send us an email at: admin@storystar.com. Thank
                                                        you.
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($pointsHistory)
                                            <div class="our-story-info-box">
                                                <div class="story-info-title">
                                                    <h2>History</h2>
                                                    <a href="{{ route('app-points-detail') }}">Back</a>
                                                </div>

                                                @if($history)
                                                    @foreach($history as $h)
                                                        <button
                                                            class="accordion {!! ($h['history_display'] == '1') ? 'accordion-pointer' : '' !!}"
                                                            data-type="{!! $h['type'] !!}"
                                                            data-history="{!! $h['history_display'] !!}">
                                                            <span class="accordion-btn-left">{!! $h['description'] !!}
                                                                : </span>
                                                            <span
                                                                class="accordion-btn-right">{!! $h['points'] !!}</span>
                                                        </button>
                                                        <div class="panel">
                                                            @if($history)
                                                                <table class="points-table content">
                                                                    <tr>
                                                                        <td colspan="3" style="text-align: center;">
                                                                            <img id="avatarImage"
                                                                                 src="/public/loader.gif" width="75"
                                                                                 height="75">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                    <button class="accordion">
                                                        <span class="accordion-btn-left">Total Points :</span>
                                                        <span
                                                            class="accordion-btn-right">{!! \Auth::user()->points !!}</span>
                                                    </button>
                                                @endif
                                            </div>
                                        @endif

                                        @if($profileSetup)
                                                <form id="form-change-password" role="form" method="POST"
                                                      action="{{ route('app-update-password') }}" novalidate
                                                      class="form-horizontal">
                                                    <div class="form-select-boxes margin-bottom-remove">
                                                        <p style="text-align: center;font-size: 20px;">
                                                            You can create a profile for yourself here. You can also keep lists of your
                                                            favorite stories and authors.
                                                            When you create a profile, whatever picture or information you provide will be
                                                            linked to and displayed whenever you comment on a story.</p>
                                                        <p style="text-align: center;font-size: 20px;">
                                                            Note that if you are a WRITER then you should start by clicking the Publish
                                                            Story link and submitting your author info along with your first story. Then you
                                                            can create your Author Profile. <br>A link to your Author Profile will then appear
                                                            on your story, and all your future stories. And wherever your name appears on
                                                            Storystar, such as in 'Read Stories' lists, and comments, it will be a clickable
                                                            link to your profile and all of your stories.</p>
                                                    </div>
                                                </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include("app.components.footer")
        </div>
    </div>

@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var $cs = $('.styled').customSelect();

            $(".custom-select").each(function () {
                $(this).wrap("<span class='select-wrapper'></span>");
                $(this).after("<span class='holder'></span>");
            });

            /* Show Hide Div on Change Select Value */
            $('#checkbox').change(function () {
                if (this.checked)
                    $('#author-block').fadeIn('fast');
                else
                    $('#author-block').fadeOut('fast');
            });

        });
    </script>
    <script type="text/javascript" src="https://www.storystar.com/assets/app/js/jquery.form.js?v=0.0.2"></script>
    <script type="text/javascript">
        $('#image').change(function () {
            $("#avatarImage").css("opacity", "0.5");
            $("#loader").fadeIn();
            $(this).parents("form").ajaxForm(options);
            $("#uploadBtn").trigger("click");
        });

        var options = {
            complete: function (response) {

                if ($.isEmptyObject(response.responseJSON.error)) {
                    $("#avatarImage").attr("src", response.responseJSON.newthumb).fadeIn();
                    $("#avatarImage").css("opacity", "1");
                    $("#loader").hide();
                    //alert('Image Upload Successfully.');
                } else {
                    $("#loader").hide();
                    printErrorMsg(response.responseJSON.error);
                }
            }
        };

        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
            var history = $(acc[i]).data('history');
            var val = parseInt(acc[i].getAttribute('data-history'), 10);
            if (val == 1) {
                acc[i].addEventListener("click", function () {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.maxHeight) {
                        panel.style.maxHeight = null;
                    } else {
                        panel.style.maxHeight = 200 + "px";
                    }
                });
            }
        }

        $(document).on('click', '.accordion', function () {
            var main = $(this);
            var type = $(this).data('type');
            $.ajax({
                url: '{!! route("app-history-item") !!}',
                data: {type: type},
                success: function (msg) {
                    var html = '';
                    var heading = type === 'gift_given' ? 'To' : 'From';
                    heading = (type === 'contest' || type === 'story_day_starred' || type === 'story_week_starred') ? 'Story' : heading;
                    html += '<tr class="header-row">';
                    html += '<th>' + heading + '</th>';
                    html += '<th>Points</th>';
                    html += '<th>Date</th>';
                    html += '</tr>';

                    $(msg).each(function (i, v) {
                        html += '<tr>';
                        html += '<td>' + v.element + '</td>';
                        html += '<td>' + v.points + '</td>';
                        html += '<td>' + v.created_at + '</td>';
                        html += '</tr>';
                    });
                    main.next().find('.content').html(html);
                }
            });
        });

        $(document).on('change', '#author', function () {
            var author = $(this).val();
            var options = '';
            $.ajax({
                url: '/author/stories/' + author,
                data: {},
                success: function (msg) {
                    console.log(msg);
                    $.each(msg, function (i, v) {
                        options += '<option value="' + i + '">' + v + '</option>';
                    });
                    $('#author-story').html(options);
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
    </script>
@endpush

<style>
    .lds-dual-ring {
        display: inline-block;
        width: 64px;
        height: 64px;
        position: absolute;
        left: 47.5%;
        top: 28%;
        display: none;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 46px;
        height: 46px;
        margin: 1px;
        border-radius: 50%;
        border: 5px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    .invalid {
        color: #C26565;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>