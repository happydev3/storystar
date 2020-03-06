@extends('app.layout.page')
@section('bodyContent')
<style>
.publishstory-boxes .c_note{
	float:left;
	font-size:17px !important;
	font-family:Oxygen-Regular!important;
	padding-bottom:25px !important;
	font-weight:600;
}
</style>
    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <h1 class="text-xs-center author-heading text-uppercase">Publish Your Story</h1>

                        <p style="color: #fff;">Publish your short story right now and you could become our newest Story STAR! The best short stories and short story writers are featured on our front page every day, week, and month, in a variety of age categories, both fiction stories and non-fiction stories. Storystar is a totally FREE site for short story writers and readers, where short stories by writers of all ages around the world are celebrated every day!</p>
                    </div>

                    

                    <form class="publishStoy" id="publisForm" role="form" method="POST" enctype="multipart/form-data"
                          action="{{ route("app-publish-story",['story_id'=>isset($story->story_id)?$story->story_id:''])}}">
                        {{ csrf_field() }}


                        <div class="publishstory-boxes">
							<h5 class="c_note">(Note: If you have a NOVEL to post instead, please click <a href="{{route('app-publish-novel')}}">HERE</a>)</h5>

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
                                                <strong>THANK YOU! </strong>
                                            @elseif($msg=='info')
                                                <i class="fa-fw fa fa-info"></i>
                                                <strong>Info!</strong>
                                            @elseif($msg=='danger')
                                                <i class="fa-fw fa fa-times"></i>
                                                <strong>Error!</strong>
                                            @endif

                                            {!! Session::get('alert-' . $msg) !!}.

                                        </div>

                                    @endif
                                @endforeach


                            </article>
                            <!-- WIDGET END -->


                            <div class="checkbox-content input-group">
                                <label class="control control--checkbox">
                                    <input type="checkbox"
                                           <?=isset($story->story_id) && !empty($story->story_id) ? "checked" : ""?>  class=""
                                           name="agreement" id="agreement" value="1"/>
                                    <div class="control__indicator"></div>
                                </label>
                                <p>I have read and agree to the StoryStar &nbsp;<span>
                                        <a target="_blank" class="b-link" href="{{route("app-submission")}}">SUBMISSION AGREEMENT</a>.</span>
                                </p>
                            </div>
                            @if ($errors->has('agreement'))
                                <em id="agreement-error" class="invalid">{{ $errors->first('agreement') }}</em>
                            @endif

                            <?php
                            $user = \Auth::user();

                            $isAuthor = isset($user->is_author) && !empty($user->is_author) ? 1 : 0;
                            ?>

                            <style>
                                select.styled {
                                    width: 100%;
                                    padding: 7px;
                                }
                                .title-padding{
                                    padding: 8px;
                                }
                            </style>
                            @if(!$isAuthor)
                                <div class="our-story-info-box margin-bottom-remove">
                                    <h1 class="story-info-title">AUTHOR INFO</h1>
                                    <input name="authorInfo" value="1" type="hidden">
                                    <style>
                                        .form-correction{
                                            padding-right: 30px;
                                        }
                                    </style>
                                    <div class="form-select-boxes">
                                        <div class="form-correction form-select-left">
                                            <label class="title-padding">Name</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input type="text" class="custom-select custom-input"
                                                       id="name" name="name" maxlength="50"
                                                       placeholder="Name"
                                                       value="{{ucfirst($user->name)}}">

                                                @if ($errors->has('name'))
                                                    <em id="name-error"
                                                        class="invalid">{{ $errors->first('name') }}</em>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="form-select-left">
                                            <label class="title-padding">Email</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <input type="text" class="custom-select custom-input"
                                                       name="email" id="email"
                                                       readonly
                                                       disabled
                                                       placeholder="Email"
                                                       title="You can not update your email"
                                                       value="{{$user->email}}">
                                                @if ($errors->has('email'))
                                                    <em id="email"
                                                        class="invalid">{{ $errors->first('email') }}</em>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-select-boxes">
                                        <div class="form-correction form-select-left">
                                            <label class="title-padding">City / State</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input type="text"
                                                       class="custom-select custom-input"
                                                       placeholder="City / State" name="address"
                                                       id="address"
                                                       value="{{isset($user->address)&&!empty($user->address)?$user->address:old('address')}}">

                                                @if ($errors->has('address'))
                                                    <em id="address-error"
                                                        class="invalid">{{ $errors->first('address') }}</em>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="form-select-left">
                                            <label class="title-padding">Country</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select rm">
                                                <select class="styled" name="country" id="country">
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
                                    <div class="form-select-boxes margin-bottom-remove">
                                        <div class="form-correction form-select-left">
                                            <label class="title-padding">Born <i class="fa fa-question-circle"
                                                                                 data-toggle="tooltip" title="Your birth year is not mandatory, but it is information that readers appreciate
                                            knowing. Especially if you are planning to write and share stories for kids
                                            and/or teens, because young readers in these categories have a right to
                                            know the age of the author who is writing stories for them. IF you do not
                                            provide your birth year now, then every time in the future that you wish to
                                            post a story for kids or teens we will ask you to state whether you are a
                                            child, teen, or adult writer."></i></label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <select class="styled" name="dob" id="dob">
                                                    <?php

                                                    $startingYear = 1900;
                                                    $selectedYear = isset($user->dob) && !empty($user->dob) ? $user->dob : old('dob');
                                                    $endingYear = date("Y");
                                                    echo '<option value=""> Select Year</option>';

                                                    for ($startingYear; $startingYear <= $endingYear; $startingYear++) {
                                                        if ($startingYear == $selectedYear) {
                                                            echo '<option value="' . $startingYear . '" selected="selected">' . $startingYear . '</option>';
                                                        } else {
                                                            echo '<option value="' . $startingYear . '">' . $startingYear . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                                @if ($errors->has('dob'))
                                                    <em id="dob-error"
                                                        class="invalid">{{ $errors->first('dob') }}</em>
                                                @endif


                                            </div>
                                        </div>
                                        <div class="form-select-left">
                                            <label class="title-padding">Gender</label>
                                            <?php
                                            $user->gender = isset($user->gender) && !empty($user->gender) ? $user->gender : old('gender');
                                            ?>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove" style="width: 75%;">
                                                <style>
                                                    .label-corrector{
                                                        display: inline;
                                                        margin-right: 10px;
                                                        font-size: 16px !important;
                                                    }
                                                </style>
                                                <label class="control control1 control--radio label-corrector">
                                                    Male
                                                    <input type="radio" name="gender" value="Male"
                                                    <?= $user->gender == 'Male' ? 'checked' : '';?>>
                                                    <div class="control__indicator"></div>
                                                </label>
                                                <label class="control control1 control--radio label-corrector">
                                                    Female
                                                    <input type="radio" name="gender" value="Female"
                                                    <?= $user->gender == 'Female' ? 'checked' : '';?>>
                                                    <div class="control__indicator"></div>
                                                </label>
                                                <label class="control control1 control--radio label-corrector">
                                                    Unspecified
                                                    <input type="radio" name="gender" value="Unspecified"
                                                    <?= $user->gender == 'Unspecified' ? 'checked' : '';?>>
                                                    <div class="control__indicator"></div>
                                                </label>
                                                @if ($errors->has('gender'))
                                                    <em id="gender-error"
                                                        class="invalid">{{ $errors->first('gender') }}</em>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            @endif


                            <div class="our-story-info-box margin-bottom-remove">
                                <h2 class="story-info-title">YOUR STORY INFO</h2>

                                <div class="radio-boxes-top input-group">
                                    <span>The type of story you want to tell is</span>
                                    <?php
                                    $allCategories = getCategories();
                                    $selectedCategory = isset($story->category_id) ? $story->category_id : old('category_id');
                                    ?>

                                    @if($allCategories)
                                        @foreach($allCategories as $key=> $category)
                                            <label class="control control1 control--radio">
                                                {{strtoupper($category)}}
                                                <input type="radio" name="category_id"
                                                       {{$selectedCategory == $key?'checked="checked"':''}}  value="{{$key}}"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                        @endforeach
                                    @endif


                                </div>

                                @if ($errors->has('category_id'))
                                    <em id="name-error" class="invalid">{{ $errors->first('category_id') }}</em>
                                @endif

                                @if(!isset($user->dob)||empty($user->dob))
                                    <div class="radio-boxes-top">
                                        <div class="margin-bottom">The story is written by : <i
                                                    class="fa fa-question-circle" data-toggle="tooltip" title="Your birth year is not mandatory, but it is information that readers appreciate
                                            knowing. Especially if you are planning to write and share stories for kids
                                            and/or teens, because young readers in these categories have a right to
                                            know the age of the author who is writing stories for them. IF you do not
                                            provide your birth year now, then every time in the future that you wish to
                                            post a story for kids or teens we will ask you to state whether you are a
                                            child, teen, or adult writer."></i></div>
                                        <?php
                                        $allSubCategories = ["Child" => "CHILD", "Teen" => "TEEN", "Adult" => "ADULT"];

                                        $written_by = isset($story->written_by) ? $story->written_by : old('written_by');
                                        ?>
                                        @if($allSubCategories)
                                            @foreach($allSubCategories as $key=> $subCategory)

                                                <label class="control control1 control--radio
                                                    {{$loop->index ==0?'remove-margin-left':''}}

                                                {{$loop->index ==2?'margin-left-remove':''}}
                                                        ">
                                                    {{$key}}
                                                    <input type="radio" name="written_by"
                                                           {{$written_by == $subCategory?'checked="checked"':''}} value="{{$subCategory}}"/>
                                                    <div class="control__indicator"></div>
                                                </label>

                                            @endforeach
                                        @endif

                                    </div>
                                @else
                                    <input style="display: none;" type="radio" name="written_by"
                                           checked="checked"
                                           value="<?= isset($user->written_by) && !empty($user->written_by) ? $user->written_by : 0?>"/>
                                @endif
                                
                                @if ($errors->has('written_by'))
                                    <em id="written_by-error" class="invalid">{{ $errors->first('written_by') }}</em>
                                @endif
                                
                                <div class="radio-boxes-top">
                                    <div class="margin-bottom">The story is written for :</div>
                                    <?php
                                    $allSubCategories = getSubCategories("sub_category_title2");
                                    $selectedSubCategory = isset($story->sub_category_id) ? $story->sub_category_id : old('sub_category_id');
                                    ?>
                                    @if($allSubCategories)
                                        @foreach($allSubCategories as $key=> $subCategory)

                                            <label class="control control1 control--radio
                                                    {{$loop->index ==0?'remove-margin-left':''}}
                                            {{$loop->index ==2?'margin-left-remove':''}}
                                                    ">
                                                {{$subCategory}}
                                                <input type="radio" name="sub_category_id"
                                                       {{$selectedSubCategory == $key?'checked="checked"':''}} value="{{$key}}"/>
                                                <div class="control__indicator"></div>
                                            </label>

                                        @endforeach
                                    @endif

                                </div>

                                @if ($errors->has('sub_category_id'))
                                    <em id="sub_category_id-error"
                                        class="invalid">{{ $errors->first('sub_category_id') }}</em>
                                @endif

                                <div class="form-select-boxes">
                                    <div class="form-select-left">
                                        <label class="title-padding">Theme</label>
                                        <div class="pagination-left select-boxes-part-four remove-margin-right publish-select  input-margin-remove">


                                            <select class="styled " name="theme_id" id="theme_id">
                                                <?php
                                                $Themes = App\Models\Theme::orderBy("theme_order", "asc")->get()->toArray();
                                                $selectedTheme = isset($story->theme_id) ? $story->theme_id : old('theme_id');
                                                ?>
                                                <option value="">SELECT THEME</option>
                                                @if($Themes)
                                                    @foreach($Themes as $k =>$theme)

                                                        @if($theme['theme_id']!=41)
                                                            <option
                                                                    value="{{trim($theme['theme_id'])}}"
                                                                    {{$selectedTheme==$theme['theme_id']?"selected='selected'":""}}
                                                            >

                                                                {{strtoupper($theme['theme_title'])}}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('theme_id'))
                                                <em id="theme_id-error"
                                                    class="invalid">{{ $errors->first('theme_id') }}</em>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="form-select-left">
                                        <label class="title-padding">Subject</label>
                                        <div class="pagination-left select-boxes-part-four remove-margin-right publish-select  input-margin-remove">
                                            <select class="styled" name="subject_id" id="subject_id">
                                                <?php
                                                $Subjects = App\Models\Subject::where('subject_id','<>','177')->orderBy("subject_title", "asc")->get()->toArray();
                                                $selectedSubject = isset($story->subject_id) ? $story->subject_id : old('subject_id');
                                                ?>
                                                <option value="">SELECT SUBJECT</option>
                                                @if($Subjects)
                                                    @foreach($Subjects as $k =>$Subject)

                                                        <option
                                                            value="{{trim($Subject['subject_id'])}}"
                                                            {{$selectedSubject==$Subject['subject_id']?"selected='selected'":""}} >
                                                            {{strtoupper(html_entity_decode($Subject['subject_title']))}}
                                                        </option>
                                                    @endforeach
                                                @endif

                                            </select>

                                            @if ($errors->has('subject_id'))
                                                <em id="subject_id-error"
                                                    class="invalid">{{ $errors->first('subject_id') }}</em>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="form-select-boxes margin-bottom-remove">
                                    <div class="form-select-left" style="float: none;width: 100%;">
                                        <label class="title-padding">Title</label>
                                        <div style="width: 81%;" class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                            <input type="text" name="story_title" id="story_title" maxlength="40"
                                                   class="custom-select custom-input"
                                                   value="{{isset($story->story_title) ? $story->story_title : old('story_title')}}"
                                            >
                                            @if ($errors->has('story_title'))
                                                <em id="story_title-error"
                                                    class="invalid">{{ $errors->first('story_title') }}</em>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-select-boxes margin-bottom-remove">
                                    <div class="form-select-left" style="float: none;width: 100%;">
                                        <label class="title-padding">Description</label>
                                        <div style="width: 81%;" class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                            <input type="text"
                                                   name="short_description"
                                                   id="short_description"
                                                   maxlength="250"
                                                   class="custom-select custom-input"
                                                   value="{{isset($story->short_description) ? $story->short_description : old('short_description')}}"
                                            >

                                            @if ($errors->has('short_description'))
                                                <em id="short_description-error"
                                                    class="invalid">{{ $errors->first('short_description') }}</em>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <ul class="tab-heading">
                                <li><a target="_blank" class="b-link" href="{{route('app-posting')}}">STORY POSTING
                                        INSTRUCTIONS</a></li>
                                <li><a target="_blank" class="b-link" href="{{route('app-howtowrite')}}">HOW TO WRITE A
                                        GOOD STORY</a></li>
                            </ul>
                            <div class="our-story-info-box">
                                <div class="story-info-title">
									<h2 class="story-info-title" style="border: none;padding-bottom: 0px;">YOUR SHORT STORY</h2>
									<h5 style="display:none">(Note:If you have a NOVEL to post instead,please click <a href="{{route('app-publish-novel')}}">HERE</a>)</h5>
								</div>
                                
                            
                                <div class="your-story-text">Enter your short story in the box below : <span>(50,000 characters of text maximum)</span>
                                </div>
                                <p class="your-story-content">Please remember to keep a copy of your story on your
                                    own
                                    computer in case you want to submit it again in another category, or in case it
                                    is
                                    accidentally lost or erased. Thank you.</p>
                                <div class="textarea-box">
                                        <textarea id="the_story" name="the_story" rows="8" maxlength="50000"
                                                  onkeyup="countChar(this,50000)">{{isset($story->the_story) ? $story->the_story : old('the_story')}}</textarea>


                                    @if ($errors->has('the_story'))
                                        <em id="the_story-error"
                                            class="invalid">{{ $errors->first('the_story') }}</em>
                                    @endif

                                </div>
                                <div class="text-xs-center character-title">
                                    You have <span id="charNum">
                                           <?php
                                        $the_story = isset($story->the_story) && !empty($story->the_story) ? $story->the_story : '';
                                        $the_story = str_replace("\r\n", "\n", $the_story);
                                        $the_story = str_replace("\r", "\n", $the_story);

                                        echo(50000 - strlen($the_story));
                                        ?>
                                        </span>
                                    characters
                                    remaining for your story
                                </div>
                            </div>
                            <div class="our-story-info-box">
                                <h2 class="story-info-title">STORY IMAGE</h2>
                                <div class="img-upload">
                                    <input type="file" name="story_img" id="story_img">
                                    <span>(max up to 5MB)</span>
                                </div>
                                <p class="your-story-content">(This photo is for the purpose of enhancing your
                                    story,
                                    and should be related to the theme or subject of your story. Once you upload
                                    this
                                    photo it becomes a permanent part of this story and cannot be changed or
                                    deleted, so
                                    please select your image carefully. Note that you can upload your self
                                    portrait/author photo separately as part of your author profile.)</p>

                                @if ($errors->has('story_img'))
                                    <em id="story_img-error"
                                        class="invalid">{{ $errors->first('story_img') }}</em>
                                @endif
                            </div>
                            <div class="checkbox-content">
                                <label class="control control--checkbox">
                                    <input type="checkbox"
                                           <?=isset($story->story_id) && !empty($story->story_id) ? "checked" : ""?>  name="attest"
                                           id="attest" value="1"/>
                                    <div class="control__indicator"></div>
                                </label>
                                <p>I attest that this is my own original story, created and written by me, and that
                                    I
                                    have not copied nor borrowed from anyone else.</p>


                            </div>

                            @if ($errors->has('attest'))
                                <em id="attest-error"
                                    class="invalid">{{ $errors->first('attest') }}</em>
                            @endif


                            <div class="btn-style clearfix">
                                <div class="text-xs-center btn btn-readstory publish-btn">
                                    <button type="submit">
                                        {{isset($story->story_id)?"UPDATE":"PUBLISH STORY"}}
                                    </button>
                                </div>
                            </div>

                        </div>

                    </form>
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

    @if($jsValidation == true)
        {!! $validator !!}
    @endif
    
    <script type="text/javascript">
        $("button:submit").click(function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            if(form.valid()){
                $(this).attr('disabled','disabled');
                form.submit();
            }
        });
    </script>

@endsection



@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        //var $cs = $('.styled').customSelect();

        $(".custom-select").each(function () {
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
    });
</script>
<style>
    select.styled{
        width: 100%;
        padding: 7px;
    }
</style>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush


@push('meta-data')
<meta name="description" content="Writers are the stars at Storystar, where authors can publish their original short stories
online for readers to rate and share."/>
<meta name="keywords" content="read short story,read,publishers,online publishers,online publishing,publishing online,short
story publishers,publisher short stories,short fiction,new writing,stories,fiction,new short stories,original short stories,
short stories online,literature,original writing,new writers,romance stories,love stories,crime stories,sci-fi stories,science
fiction stories,humourous stories,horror stories,children's stories,fantasy,new fiction,short stories for kids,short story
for kids,short stories for children,short stories to read,read short stories online,fictional short stories,short love
stories,short story writers,teenage short stories,inspiring short stories,science fiction short stories,romance short
stories,short mystery stories,submit short stories,short story writing competitions,short story writing contests,short
story competition,short story contest,tell your story,tell your short story,tell my story,tell stories."/>
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

