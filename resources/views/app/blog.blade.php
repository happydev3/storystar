
@extends('app.layout.page')
@section('bodyContent')
<link href="/assets/app/css/pagination.css" rel="stylesheet" id="bootstrap-css">

<style>

    .author-heading{
        margin-top: 27px;
    }
    p.teaser{
        text-align: justify!important;
        text-overflow: ellipsis;
        display: -webkit-box!important;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        line-height: 1.5em;
        max-height: 7em;
        overflow: hidden;
        font-family: 'Arial';
        font-weight: normal;
        font-style: normal;
    }   
    .blog-container p.teaser {
        padding:0px!important;

    }
    .stories-box a.reply-btn {
        font-size: 14px;
        font-family: 'Oxygen-Regular';
        font-weight: 600;
        color: #07588d;
        float: right;
        text-align: right;
    }
    .stories-box .reply-box{        
        background: inherit!important;
        padding: 0px!important;
        display: block;
    }

    .stories-box-color .sub-user-box{
        background: #d8e5fe;
    }
    .sub-user-box{
        padding: 2px 10px;
    }
    .user-comment-box h4 {
        font-size: 15px!important;
        margin-top: 2px;
        margin-bottom: 5px;
    }
    .user-comment-img img {
        border-radius: 25px!important;
    }
    .sub-user-box .user-comment-img {
        width: 35px;
        border-radius: 25px!important;
        border: 2px solid #fff!important;
    }
    .user-comment-box span{
        font-size: 11px!important;
    }
    .user-comment-box  a.show-full{
        font-size: 20px;
    }   
    .sub-user-box:last-of-type{
        margin-bottom:10px;
    }
    .comments-scroll-sub p.teaser{        
        max-height: 4.5em;
    }

    a.load-more-reply,a.load-more-close{
        vertical-align: middle;
        text-align: center;
        cursor: pointer;
        /*        background: #fff080;
                background: -moz-linear-gradient(top, #fff080 0%, #f4cd00 100%);
                background: -webkit-linear-gradient(top, #fff080 0%, #f4cd00 100%);
                background: linear-gradient(to bottom, #fff080 0%, #f4cd00 100%);*/
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff080', endColorstr='#f4cd00', GradientType=0);
        border-radius: 40px;
        /*box-shadow: 0px 7px 12px rgba(0, 0, 0, 0.25);*/
        padding: 5px 15px 0px;
        width: 150px;
        font-weight: bold;
        font-size: 12px;
        font-family: 'TheSalvadorCondensed-Regular';
        margin-right: 35px;
        display: table-caption;
        color: blue!important;
    }
    .sub-user-box{
        margin-top: 5px!important;        
    }

    form#reply-box input{
        padding: 4px 25px!important;
        box-shadow: 0px 2px 0px #7b7c19!important;
        margin-bottom: 2px;
        margin-top: 2px;
        font-size: 13px;
    }
    .publishstory_bg .row #shownav{
        position: inherit;
        margin: 0px;
        margin-top: 62px;
        float: right;
    }
    .popup-container {
        position: fixed;
        width: 1047px;
        bottom: 0;
        z-index: 100;
    }
    .popup {
        float: right;
        background:#F1E412;
        width: 300px;
        height: 140px;
        text-align: center;
        border:1px solid;
        color: #003992;
        border-radius: 10px;
        vertical-align: middle;
        padding-top: 24px;
        font-weight: bold;
        display: none;
        margin-bottom: 5px;
    }

    @media only screen and (max-width: 767px) {
        div.author-middle-bg.publishstory_bg > .row {
            text-align: -webkit-center;
            width: 100%!important;
        }
        
        div.author-middle-bg.publishstory_bg > .row > a{
            width: fit-content;
            display: block;
        }
        div.author-middle-bg.publishstory_bg h1{
            width: 100%;
            display: -webkit-box;
            text-align: -webkit-center!important;
        }
        div.author-middle-bg.publishstory_bg  div.select-option{
            width: -webkit-fill-available!important;
            text-align: -webkit-center!important;
            display: block!important;
            margin-top: 20px!important;
        }
        div.author-middle-bg.publishstory_bg  div.select-option label {
            width: 37%;
        }
        div.author-middle-bg.publishstory_bg > .row > a #shownav {
            margin-top:10px; 
        }
        .user-comment-box a{
            float:left;
        }
    }
</style>

<div class="container">
    <div class="popup-container">
        <div class="popup">
            <h3 style="font-weight:1000;">Congratulations !</h3>
            <br/>
            <p>You have been awarded points. <br />Thank you for your reply !</p>
        </div>
    </div>

    <div class="row">
        <div class="nav-boxes middle-top-border">
            <div class="nav-boxes-inner middle-top-border-inner">
                <div class="author-middle-bg publishstory_bg">
                    <div class="select-option" style="float: left;margin-top: 62px;width:29%" align="center">
                        <label style="color:white;float:left;font-size: 20px;padding-right: 6px;">READ</label>
                        <select onChange="window.location.href = this.value" class="form-control" style="width: 63%;float:left;border: 3px solid #fff;background-color: #2f6bd9;color:white;padding: 0px;border-radius: 0px;height: 30px;">
                            
                            <option value="{{ route('app-blog') }}"
                                    @if (\Request::is('blog'))  
                                    selected
                                    @endif
                                    >News & Info</option>
                            <option value="{{ route('app-blog-tip','tip') }}" 
                                    @if (\Request::is('blog-tip/*'))  
                                    selected
                                    @endif
                                    >Writing Tips</option>                                           
                            <option value="{{ route('app-blog-inspiration','inspiration') }}"
                                    @if (\Request::is('blog-inspiration/*'))  
                                    selected
                                    @endif
                                    >Writing Inspiration</option>
                            <option value="{{ route('app-blog-articles','articles') }}"
                                    @if (\Request::is('blog-articles/*'))  
                                    selected
                                    @endif
                                    >Useful Articles</option> 
                            
                        </select><br>
                    </div>

                    <div class="row" style="width: fit-content;float: right;"> 

                        <a href="{{ route('app-blog','comments') }}" >
                            <div id="shownav" style="width: 178px;padding: 2px 15px;margin-right: 14px;"> 
                                Live Comments Feed                    
                            </div>
                        </a>
                    </div>

                    <h1 class="text-xs-center author-heading text-uppercase" style="margin-top: 0px;margin-bottom: 0px;padding-top: 38px;width: max-content;">Storystar Blog</h1>

                    <h4 style="color: white;text-align: center;font-size: 17px;margin-top: 8px;margin-bottom: 27px;width: fit-content;;text-align: center;font-size: 17px;padding-left: 6px;">Storystar News & Information</h4>
                    <div class="row" style="width: auto!important;">
                        <div class="col-md-12">
		    @if(count($blogs) > 0)
                    @foreach($blogs as $key => $blog)
                    <div id="story-{{$blog->id}}" class="stories-box blog-container {{ $key%2 == 1 ?'stories-box-color ':'' }}">

                            <p class="chat-img pull-left" style="padding: 0px!important;font-family: 'Arial';font-weight: bold;font-style: normal; ">
                                <span class="bordered-bottom"style="border-bottom: 1px solid white;padding-bottom: 0px;">
                                    <a target="_blank" style="color: #0e007a;font-size: 14px;"
                                       href="javascript:;"
                                       >{{ ucfirst($blog->title) }}</a>                                    
                                </span>                                
                                <span class="blog-post-date pull-right" style="font-size: 12px;">{{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</span> 
                            </p>
                            <p class="blog-post-container"style="padding: 0px!important;margin: 4px 0px 0px!important;font-family: 'Arial';font-weight: bold;font-style: normal;" >
                                <span class="blog-post-user" style="color:#000;font-size: 12px;">Posted by
                                    <span style="color:#3f49cf">                                
                                        Storystar Admin,
                                    </span>                                    
                                </span>
                                @if($blog->section_id == 1)
                                <span style='font-size: 12px;'>Writing Tips</span>
                                @elseif($blog->section_id == 2)
                                <span style='font-size: 12px;'>Writing Inspiration</span>
                                @elseif($blog->section_id == 3)
                                <span style='font-size: 12px;'>Interesting Articles for Writers</span>
                                @else
                                <span style='font-size: 12px;'> News & Information</span>
                                @endif
                            </p>

                            <div class="blog-content-container">
                                <p class="teaser" style="font-size: 14px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;font-family: 'Arial';font-weight: normal;font-style: normal;">
                                    {!! nl2br($blog->content) !!}                          
                                </p>
                                <a href="javascript:;" class="show-full">
                                    <i style="cursor: pointer;color: #07588d;"> Read more</i>
                                </a>                     
                            </div>
                            <p class="complete hidden" style="font-size: 14px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;font-family: 'Arial';font-weight: normal;font-style: normal;">{!! nl2br($blog->content) !!}</p>
                            <p style="padding: 0px!important;width:50%;float:right;">
                                <a 
                                    @if(Auth::check())
                                    href="javascript:void(0)" data-comment_id="{{$blog->id}}" 
                                    data-target="#reply-{{$blog->id}}" data-type="show"
                                    data-toggle="show-hidden" 
                                    @else
                                    href="{{ route('login') }}"
                                    @endif
                                    class="reply-btn" 
                                    >
                                    Reply
                            </a>                            
                        </p>
                        <div class="reply-box hidden" id="reply-{{$blog->id}}"> 
                            <form method="post" class="blog-reply-comments" action="{{route('app-blog-comments',$blog->id)}}" id="reply-box" data-plugin="ajaxForm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="replycomment">
                                    <textarea name="comment" id="replyText" cols="30" rows="2"
                                              placeholder="Write a comment"></textarea></div>
                                <div>
                                    <input type="submit" placeholder="Reply" value="Reply"/>
                                </div> 
                            </form>
                        </div>
                        <div class="comments-scroll-sub" id="load-data-15868-1352">

                            @if(count($blog->blogcomment) > 0)
                            @foreach($blog->blogcomment as $comment)
                            @include("app.components.blog-comment",['comment' => $comment ])
                            @endforeach
                            @endif
                            <p style="text-align: -webkit-center;padding:0px 0px 0px 0px!important;">
                                <a class="load-more-reply" data-count="2">Load More..</a>
                                <a class="load-more-close hidden" style="color: blue!important">Close</a>
                            </p> 

                        </div>                        
                    </div>
                    @endforeach 
                    @else
                    <div class="col-md-12" align="center" >
                    <p style="text-align: center;font-family: 'TheSalvadorCondensed-Regular';color: #f7df51;
    font-size: 23px;">No Blogs found</p>
                     </div>
                    @endif
                    </div>
                </div>
                
                <div class="col-md-12" align="center">
                    <div class="row">
                        <div class="page-number col-md-3  col-lg-push-2" style="font-size: 20px;font-weight: bold;color:white;margin-top: 10px;text-align:left;padding:0px;">
                            Page {{$blogs->currentPage()}} of {{$blogs->lastPage()}}
                        </div>
                        <div class="col-md-6 " align="center" style="margin-top: 10px">
                            @php 
                            $paginator = $blogs;
                            @endphp
                            @if ($paginator->hasPages())
                            <ul class="pagination pagination">
                                {{-- Previous Page Link --}}
                                @if ($paginator->onFirstPage())
                                <li class="disabled"><span>                                        
                                    <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt="" class="loading" data-was-processed="true" />
                                </span></li>
                                @else
                                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt="" class="loading" data-was-processed="true" /></a></li>
                                @endif

                                @if($paginator->currentPage() > 2)
                                <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
                                @endif
                                @if($paginator->currentPage() > 3)
                                <li><span>...</span></li>
                                @endif
                                @foreach(range(1, $paginator->lastPage()) as $i)
                                @if($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1)
                                @if ($i == $paginator->currentPage())
                                <li class="active"><span>{{ $i }}</span></li>
                                @else
                                <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                                @endif
                                @endif
                                @endforeach
                                @if($paginator->currentPage() < $paginator->lastPage() - 3)
                                <li><span>...</span></li>
                                @endif
                                @if($paginator->currentPage() < $paginator->lastPage() - 2)
                                <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($paginator->hasMorePages())
                                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"> <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt="" class="loading" data-was-processed="true" style="transform: rotate(180deg)"></a></li>
                                @else
                                <li class="disabled"><span>
                                    <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt="" class="loading" data-was-processed="true" style="transform: rotate(180deg)">
                                </span></li>
                                @endif
                            </ul>
                            @endif
                        </div>
                        @if( $blogs->lastPage()>10)
                        <div class="page-number col-md-3" style=" max-width: 280px;margin-top: 10px;padding: 0px;float:right;width: 15%;">
                            <form action="" method="GET">
                                <input type="text" name="page" style="width:100%;height: 38px;background-color: #206bd9 !important;color:white;padding: 10px;border: 3px solid;" placeholder="Jump to Page:____">
                                <button type="submit" 
                                        style="transform: rotate(180deg);padding: 5px;background-color:Transparent;border: 0px;padding: 5px;position: absolute;right: 20px;top: 3px;">
                                    <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt="" class="loading" data-was-processed="true">
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
    @include('app.components.footer')
</div>
</div>

@endsection
@push('js')
<script type="text/javascript" src="/assets/app/js/common-ajax-submit.js"></script>
<script type="text/javascript">
                        $(document).on('click', 'a.show-full', function (e) {
                            e.preventDefault();
                            $(this).closest('div')
                                    .find('p.teaser')
                                    .css('-webkit-line-clamp', 'initial')
                                    .css('max-height', 'inherit');
                            $(this).hide();
                        });
                        $(document).ready(function () {
                            limitReplayCount();
                            isHaveReadMore();
                            $('.blog-reply-comments').on('af.success', function (e, data) {
                                e.preventDefault();
                                $(this).closest('.stories-box').find('.comments-scroll-sub').prepend(data.div);
                                isHaveReadMore();
                                $(this)[0].reset();
                                $(this).closest('.stories-box').find('.reply-btn').trigger('click');

                                $(this).closest('.stories-box').parent().prepend($(this).closest('.stories-box'));
                                var $storyBox = $(this).closest('.stories-box');
                                $('html, body').animate({
                                    scrollTop: $storyBox.offset().top
                                }, 500);
                                if (data.points == 'success') {
                                    $(".popup").fadeIn('slow');
                                    setTimeout(function(){
                                        $(".popup").fadeOut('slow');
                                    }, 4000);
                                }
                            });

                        });

                        $(document).on('click', 'a[data-toggle="show-hidden"]', function (e) {
                            e.preventDefault();
                            var type = $(this).data('type');
                            var target = $(this).data('target');
                            console.log(target);
                            console.log(type);
                            if (type == 'close') {
                                $(this).data('type', 'show');
                                $(this).html('Reply').css('color', '#07588d');
                                $(this).closest('.stories-box').find(target).addClass('hidden');
                            } else {
                                $(this).data('type', 'close');
                                $(this).html('Close').css('color', 'red');
                                $(this).closest('.stories-box').find(target).removeClass('hidden');
                            }
                        });


                        $(document).on('click', 'a.load-more-reply', function (e) {
                            e.preventDefault();
                            $(this).closest('.stories-box').find('.comments-scroll-sub').children('div').removeClass('hidden');
                            $(this).closest('.stories-box').find('.comments-scroll-sub').find('a.load-more-reply').addClass('hidden');
                            $(this).closest('.stories-box').find('.comments-scroll-sub').find('a.load-more-close').removeClass('hidden');
                        });

                        $(document).on('click', 'a.load-more-close', function (e) {
                            e.preventDefault();
                            var $div = $(this).closest('.stories-box').find('.comments-scroll-sub');
                            limtViewLoadMore($div, 2);
                        });

                        function isHaveReadMore() {
                            $(document).find('.blog-content-container').each(function () {
                                var height = $(this).find('p.teaser').height();
                                var fullHeight = $(this).find('p.teaser')[0].scrollHeight;
                                if (fullHeight && fullHeight <= height) {
                                    $(this).find('a').remove();
                                }
                            });
                        }

                        function limitReplayCount(count = 2) {
                            $(document).find('.comments-scroll-sub').each(function () {
                                limtViewLoadMore($(this), count)
                            });
                        }
                        function limtViewLoadMore($div, count) {
                            $div.find('a.load-more-close').addClass('hidden');
                            if ($div.children('div').length <= count) {
                                $div.find('a.load-more-reply').addClass('hidden');
                            } else {
                                $div.find('a.load-more-reply').removeClass('hidden').css('margin-top', '5px');
                            }
                            $div.children('div').addClass('hidden');
                            for (i = 0; i < count; i++) {
                                $div.children('div').eq(i).removeClass('hidden');
                            }
                            isHaveReadMore();
                        }
</script>
@endpush
