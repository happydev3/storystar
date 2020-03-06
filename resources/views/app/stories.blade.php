@extends('app.layout.page')
@section('bodyContent')
<style>
	.pagination-left:first-child{width:24%;}
	.pagination-left .select-wrapper {
		*width: 156px;
		border: 3px solid #fff;
		background: none !important;
		*float:none;
	}
	.pagination-left .custom_m_s .select-wrapper {width: 90%;}
	.c_page_no{background:none !important;}
	#AdvanceContainer .checkbox-content {
		padding: 0px 23px 0px 23px !important;
	}
	#AdvanceContainer .search-icon{*margin-top: -45px;}
	.pagination-left .custom_m_s img {
		transform: rotate(180deg);
		-webkit-transform: rotate(180deg);
		-moz-transform: rotate(180deg);
		-ms-transform: rotate(180deg);
	}
	#page_no{
		background-color: #206bd9 !important;
		height: 32px;
		color: #fff;
		width: 100%;
		padding: 0px;
		text-align: left;
	}
	.pagination-middle ul li.arrow-bg-pagin{
		background-size: 80%;
	}
	.pagination-middle ul li.arrow-bg-pagin a .loading{
		margin: -6px 0 0 -5px;
	}
	.pg_go{
		vertical-align: middle;
		text-align: center;
		cursor: pointer;
		background: #fff080;
		background: linear-gradient(to bottom, #fff080 0%, #f4cd00 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff080', endColorstr='#f4cd00', GradientType=0);
		border-radius: 30px;
		box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.25);
		padding: 5px 15px;
		width: 50px;
		font-weight: bold;
		font-size: 16px;
		font-family: 'TheSalvadorCondensed-Regular';
		margin-top: -3px;
		float: right;
	}
	@media (max-width: 767px) {
		.pagination-left .select-wrapper {width: 156px;}.pg_go{width:100px;}
		#AdvanceContainer .checkbox-content {
			padding: 0px 0px 0px 0px !important;
		}
	}
	@media (min-width: 1024px) and (max-width: 1024px){
		.author-middle-bg .pagination-boxes:first-of-type{margin-top:-65px;}
		.pagination-boxes:first-of-type .pagination-left{
			width: 24%;
		}
	}
	#storiesSearchFrm .styled{
        height:36px;
        opacity:1!important;
        background: #206bd9 url('{{ url('assets/app/images/white-arrow.png') }}') no-repeat right center;
        border-color: white!important;
        color: white!important;
        height: 45px!important;
        padding: 0px 10px!important;
        background-position-x: 95%;
   }
    #storiesSearchFrm select::-ms-expand {    display: none!important; }
    #storiesSearchFrm select{
        -webkit-appearance: none!important;
        appearance: none!important;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
    <div class="container">
        <div class="row">


            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <form id="storiesSearchFrm" {{-- action="{{route("app-stories")}}" --}} action="" role="search">

                        <input type="hidden" name="sortby" id="sortby" value=""/>
                        <input type="submit" style="display: none"/>


                        <?php

                        $showAdvance = 0;
                        if ($pageData['theme'] == 41 || $pageData['subject'] == 177){
                        }
                        else{
                            if ($pageData['category'] ||
                                $pageData['subcategory'] ||
                                $pageData['subject'] ||
                                $pageData['theme'] ||
                                $pageData['s'] ||
                                $pageData['sd'] ||
                                $pageData['author'] ||
                                $pageData['country'] ||
                                $pageData['state']
                            ) {

                                $showAdvance = 1;
                            }
                        }
                        ?>


                        <div class="">
                            @if($showAdvance == 1)
                                <div id="shownav2" class="resetButton">
                                    Clear Search
                                </div>
                            @endif

                            <div id="shownav">
                                <span>{{($showAdvance==0)?"+":"-"}}</span> Search Stories
                            </div>
                        </div>


                        <div id="AdvanceContainer" class="select-boxes-part"
                             style="display:{{$showAdvance==0?"none;":''}}">



                                <div class="pagination-left select-boxes-part-four"><!-- color-backg-change -->
                                    <?php
                                    $Categories = getCategories();
                                    ?>

                                    <select class="styled customSelect" name="category" onchange="submitForm()">
                                        <option value="">Category</option>
                                        @if($Categories)
                                            @foreach($Categories as $k =>$Category)
												<?php
													if($k == 1){
														$cat_name= "real life / non-fiction";
													}else{
														$cat_name= $Category;
													}
												?>
                                                <option {{$pageData['category']== $k?'selected="selected"':'' }}
                                                        value="{{$k}}"
                                                >
                                                    <!--{{ucwords($Category)}}-->
                                                    {{ucwords($cat_name)}}
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="pagination-left select-boxes-part-four">
                                    <?php
                                    $subCategories = getSubCategories();
                                    ?>

                                    <select class="styled" name="subcategory" onchange="submitForm()">
                                        <option value="">Subcategory</option>
                                        @if($subCategories)
                                            @foreach($subCategories as $k =>$subCategory)

                                                <option {{$pageData['subcategory']== $k?'selected="selected"':'' }}
                                                        value="{{$k}}"
                                                >
                                                    {{ucwords($subCategory)}}
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="pagination-left select-boxes-part-four">
                                    <select class="styled" name="theme" onchange="submitForm()">
                                        <?php
                                        $Themes = App\Models\Theme::orderBy("theme_order", "asc")->get()->toArray();
                                        ?>
                                        <option value="">Theme</option>
                                        @if($Themes)
                                            @foreach($Themes as $k =>$theme)
                                                <option
                                                        {{$pageData['theme']== $theme['theme_id']?'selected="selected"':'' }}
                                                        value="{{trim($theme['theme_id'])}}">
                                                    {{ucwords($theme['theme_title'])}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div><div style="display:none;">{{$pageData['subject']}}</div>
                                <div class="pagination-left select-boxes-part-four remove-margin-right">
                                    <select class="styled" name="subject" onchange="submitForm()">
                                        <?php
										if(!empty($pageData['subject']) && $pageData['subject'] ==177)
											$clause = App\Models\Subject::orderBy("subject_title", "asc");
										else
											$clause = App\Models\Subject::where('subject_id','<>','177')->orderBy("subject_title", "asc");
										$Subjects = $clause->get()->toArray();
                                        ?>
                                        <option value="">Subject</option>
                                        @if($Subjects)
                                            @foreach($Subjects as $k =>$Subject)


                                                <option
                                                        {{$pageData['subject']== $Subject['subject_id']?'selected="selected"':'' }}
                                                        value="{{trim($Subject['subject_id'])}}">
                                                    {{ucwords(html_entity_decode($Subject['subject_title']))}}
                                                </option>


                                            @endforeach
                                        @endif

                                    </select>
                                </div>




                            <div class="pagination-left select-boxes-part-four  custom-search-box">
                                <input name="s" id="s" type="text" class="custom-select search-box"
                                       placeholder="Keyword Search"
                                       value="{{$pageData['s'] OR ''}}">
                                <img src="{{app_assets("images/search-icon.png")}}" id="searchIcon" alt=""
                                     class="search-icon searchIcon">
                            </div>


                            <div class="pagination-left select-boxes-part-four  custom-search-box">
                                <input name="author" type="text" class="custom-select search-box"
                                       placeholder="Author Search"
                                       value="{{$pageData['author'] OR ''}}">
                                <img src="{{app_assets("images/search-icon.png")}}" id="searchIcon" alt=""
                                     class="search-icon searchIcon">
                            </div>


                            <div class="pagination-left select-boxes-part-four custom-search-box">
                                <input name="state" type="text" class="custom-select search-box"
                                       placeholder="Location Search"
                                       value="{{$pageData['state'] OR ''}}">
                                <img src="{{app_assets("images/search-icon.png")}}" id="searchIcon" alt=""
                                     class="search-icon searchIcon">
                            </div>


                            <div class="pagination-left select-boxes-part-four  remove-margin-right">
                                <?php
                                // $Countries = getCountries();

                                $Countries = App\Models\Story::Select("author_country")->groupBy('author_country')->orderBy('author_country', 'asc')->get()->toArray();
                                $Countries = array_column($Countries, "author_country");
                                $Countries = array_combine($Countries, $Countries);

                                ?>
                                <select class="styled" name="country" onchange="submitForm()">
                                    <option value="">Country</option>
                                    @if($Countries)
                                        @foreach($Countries as $k =>$country)
											<?php if(!empty($k)){ ?>
                                            <option
                                                    {{$pageData['country']== $k?'selected="selected"':'' }}
                                                    value="{{$k}}">
                                                {{ucwords($k)}}
                                            </option>
                                            <?php } ?>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="checkbox-content input-group">
                                <label class="control control--checkbox">
                                    <input type="checkbox"
                                           <?=isset($pageData['in_content']) && !empty($pageData['in_content']) ? "checked" : ""?>  class=""
                                           name="in_content" id="in_content" value="1"/>
                                    <div class="control__indicator"></div>
                                </label>
                                <p>
                                    <!--When this option is checked your keyword will be searched throughout the entire text in all the stories, returning more results.-->
                                    When box is checked, keyword is searched through all story text, with more results.
                                </p>
                            </div>


                            {{--<div class="custom-center">--}}
                            {{--<div class="pagination-left select-boxes-part-four  custom-search-box">--}}
                            {{--<input name="sd" type="text" class="custom-select search-box"--}}
                            {{--placeholder="Search Description"--}}
                            {{--value="{{$pageData['sd'] OR ''}}">--}}
                            {{--<img src="{{app_assets("images/search-icon.png")}}" id="searchIcon" alt=""--}}
                            {{--class="search-icon searchIcon">--}}
                            {{--</div>--}}
                            {{--</div>--}}

                        </div>


                    </form>
                    <div class="author-middle-bg stories">
                        <div class="clearfix"></div>
                        
                        @include('app.components.notification-messages')
                        @if(!@Auth::user()->is_premium)
                        <div class="ad-section" style="padding-bottom: 0px !important;padding-top: 20px !important">
                            <div class="ads-box" style="margin-bottom: 10px;">
                                <a href="{{ url('/premium-membership') }}" class="disappear-ads" id="disappear-ads">Want to make ALL the advertising disappear?</a>
                            </div>
                            <div class="ad text-center" style="padding-bottom: 25px !important;padding-top: 25px !important;">
                                <?php
                                    $googleAds = App\Models\Ads::where("page_name", "=", "stories")->first();
                                ?>
                                @if(!@Auth::user()->is_premium)
                                    {!! $googleAds->ads_code !!}
                                @endif
                            </div>
                        </div>
                        @endif
                        <h1 class="text-xs-center author-heading text-uppercase" style="margin-bottom: 24px;padding-top: 70px">
							Read {{$pageData['subject']==177?'Novels':($pageData['theme']==41?'Classic Short Stories':'Short stories')}}
						</h1>

                        {{ $paginator->appends($pageData['queryString'])->render("app.components.pagination",["position"=>"top",'pageData'=>$pageData])}}
                        <span class="tell-story-text story_title" style="font-size:15px;padding: 0px 15px!important;">
						{!! $pageData['subject']==177?'Read these free books online by writers of all ages from around the world, listed below in order of the date they were published, with the newest first. This is a brand new category, so check back often for more free books to read online as this reading library grows. ':($pageData['theme']==41?'Read classic short stories by world famous authors.':'Read the best short stories online by short story writers of all ages from around the world,<br/> listed below in order of the date they were published, with new stories first.') !!}</span>
                        @include("app.components.story")
                        {{ $paginator->appends($pageData['queryString'])->render("app.components.pagination",["position"=>"bottom",'pageData'=>$pageData,'margin' => 0])}}


                    </div>

                    <div class="clearfix"></div>
                    <div class="star-border-box"><span class="star-border"></span></div>
                    <?php
                        $googleAds = App\Models\Ads::where("page_name", "=", "stories")->first();
                    ?>
                    @if(!@Auth::user()->is_premium && trim($googleAds->ads_code) != '')
                        <div class="ad-section">
                             <div class="ads-box" style="margin-bottom: 10px;">
                                <a href="{{ url('/premium-membership') }}" class="disappear-ads" id="disappear-ads">Want to make ALL the advertising disappear?</a>
                            </div>
                            <div class="ad text-center" style="padding-bottom: 5px !important;padding-top:5px !important;">
                                {!! $googleAds->ads_code !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @include('app.components.footer')


        </div>


    </div>

    <script>
    $('.pagination-middle').first().css( "display", "none" );

        var showAdvance = '{{($showAdvance==0)?"0":"1"}}';

        $('#shownav').click(function () {

            showAdvance = (showAdvance == 1) ? 0 : 1;

            $('#AdvanceContainer').slideToggle();
            this.toggle = !this.toggle;

            $(this).children("span").text(showAdvance == 0 ? "+" : "-");
            return false;
        });

        $('#shownav2').click(function () {
            window.location = '{{ \Request::url() }}';
        });

        $('#in_content').click(function () {

            if ($("#s").val()) {
                setTimeout(function () {
                    $("#storiesSearchFrm").submit();
                }, 1000);
            }
        });
    </script>

@endsection


@push('meta-data')
{{--<meta name="description" content="{{$pageData['MetaDescription'] OR 'Short stories to read online free for everyone, including love stories, funny stories, scary stories, fantasy, mystery, inspirational, sci-fi, historical fiction, and many more...'}}"/>--}}
<meta name="keywords" content="{!! $pageData['MetaKeywords'] OR ''!!}"/>
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
