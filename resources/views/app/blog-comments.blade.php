<style>
    .author-heading {
        margin-top: 27px;
    }

    p.teaser {
        text-align: justify !important;
        text-overflow: ellipsis;
        display: -webkit-box !important;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        line-height: 1.5em;
        max-height: 7em;
        overflow: hidden;
    }

    .footer-bottom {
        padding: 65px 0px 1px !important;
    }

    .blog-container p.teaser {
        padding: 0px !important;
    }

    .publishstory_bg .row #shownav {
        position: inherit;
        margin: 0px;
        margin-top: 10px;
        float: right;
    }

    @media only screen and (max-width: 767px) {
        div.author-middle-bg.publishstory_bg > .row {
            text-align: -webkit-center;
            margin-bottom: 20px;
        }

        div.author-middle-bg.publishstory_bg > .row > a {
            width: fit-content;
            display: flex;
        }

        div.author-middle-bg.publishstory_bg > .row > a #shownav {
            margin-right: 0px !important;
        }
    }
</style>
@extends('app.layout.page')
@section('bodyContent')
    <link href="/assets/app/css/pagination.css" rel="stylesheet" id="bootstrap-css">
    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">

                    <div class="author-middle-bg publishstory_bg">
                        <div class="row">
                            <a href="{{ route('app-blog') }}">
                                <div id="shownav" style="width:118px;padding: 2px 15px;margin-right: 14px;">
                                    Admin Blog
                                </div>
                            </a>
                        </div>
                        <h1 class="text-xs-center author-heading text-uppercase"
                            style="margin-top: 0px;margin-bottom: 0px;padding-top: 0px;">Comments</h1>
                        <h4 style="margin:8px 15px 27px 15px;color: white;text-align: center;font-size: 16px">
                            Below is a live feed in real time of all the comments being left on the stories that people
                            are talking about, posted in order of the time the comments were made with the newest
                            comments at the top of the page. Please feel free to join in the conversation by clicking on
                            the link to the story that is being commented on.
                        </h4>
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($comments as $key => $comment)
                                    {{--{{dump($comment)}}--}}

                                    <div id="story-15868"
                                         class="stories-box {{ $key%2 == 1 ?'stories-box-color ':'' }}">
                                        <p class="chat-img pull-left"
                                           style="padding: 0px;font-family: 'Arial';font-weight: bold;font-style: normal; ">
                                    <span class="bordered-bottom"
                                          style="border-bottom: 1px solid white;padding-bottom: 0px;">


                                        <a target="_blank" style="color: #0e007a;font-size: 14px;"
                                           href="{{
                                    route("app-storynew",[ 'story_id' => $comment->story->story_id,
                                                        'user_name'=> str_slug($comment->story->author_name),
                                                        'category'=>str_slug($comment->story->category->category_title),
                                                        'theme'=> $comment->story->getSlugTheme()])
                                           }}"
                                        >{{ $comment->story->story_title }}</a>


                                        {{--@php--}}
                                        {{--$profileUrl = "";--}}
                                        {{--if (isset($comment->story->self_story) && $comment->story->self_story == 1){--}}
                                        {{----}}
                                        {{--if(isset($comment->story->user->is_profile_complete)&&$comment->story->user->is_profile_complete == 1){--}}
                                        {{--$profileUrl = route('app-profile',['user_id'=>$comment->story->user_id,'user_name'=>str_slug($comment->story->user->name)]);--}}
                                        {{--$profileUrl = $profileUrl."#profile";--}}
                                        {{--}--}}
                                        {{--}--}}
                                        {{--$Country =  isset($comment->story->author_country)&&!empty($comment->story->author_country)?ucfirst($comment->story->author_country):"";--}}

                                        {{--@endphp--}}


                                        <span class="auther-data-container"
                                              style="font-size: 13px;color:#000;font-family: 'Arial';font-weight: normal;font-style: normal;">
                                            &nbsp;(A short story by

                                            @if (isset($comment->story->user->is_profile_complete) and $comment->story->user->is_profile_complete == 1)
                                                <a href="{{route('app-profile',['user_id'=>$comment->story->user_id,'user_name'=>str_slug($comment->story->author_name)])}}">{{ucfirst($comment->story->author_name)}}</a>
                                                )
                                            @else
                                                {{ucfirst($comment->story->author_name)}})
                                            @endif
                                            {{--<a style="color:#3f49cf " href="{{$profileUrl}}">{{isset($comment->story->author_name)?ucfirst($comment->story->author_name):""}}--}}
                                            {{--</a>{{!empty($Country)?' of '.$Country:''}})--}}
                                        </span>
                                    </span>
                                            <span class="blog-post-date pull-right"
                                                  style="font-size: 12px;">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                        </p>
                                        <p class="blog-post-container"
                                           style="margin: 4px 0px 0px!important;font-family: 'Arial';font-weight: bold;font-style: normal;">
                                    <span class="blog-post-user" style="color:#000;font-size: 12px;">Comment posted by
                                        {{--@php--}}
                                        {{--if($comment->user) {--}}
                                        {{--$name = isset($comment->story->author_name) && !empty($comment->story->author_name)?ucfirst($comment->story->author_name):ucfirst($comment->story->user->name);--}}
                                        {{--$url = route('app-profile',['user_id'=>$comment->user->user_id,'user_name'=>str_slug($name)]);--}}
                                        {{--} else  {--}}
                                        {{--$url = 'javascript:;';--}}
                                        {{--}--}}
                                        {{--@endphp--}}
                                        {{--<a style="color:#3f49cf" href="{{ $url }}" >--}}
                                        {{--{{($comment->user)?ucfirst($comment->user->name):'Anonymous User'}}--}}
                                        {{--</a> {{ ($comment->user && $comment->user->country)?'of '.$comment->user->country:'' }}:--}}


                                        @if ($comment->user and (isset($comment->user->profile) or isset($comment->user->avatar)))
                                            <a href="{{route('app-profile',['user_id'=>$comment->user->user_id,'user_name'=>str_slug($comment->user->name)])}}">{{ucfirst($comment->user->name)}}</a>
                                        @else
                                            {{ucfirst($comment->user->name)}}
                                        @endif
                                    </span>
                                        <div style="display: none">{{dump($comment->user)}}</div>

                                        </p>
                                        <div class="blog-content-container">
                                            <p class="teaser"
                                               style="font-size: 14px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;font-family: 'Arial';font-weight: normal;font-style: normal;">
                                                {!! nl2br($comment->comment) !!}
                                            </p>
                                            <a href="javascript:;" class="show-full">
                                                <i style="cursor: pointer;color: #07588d;"> Read more</i>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12" align="center">
                            <div class="row">
                                <div class="page-number col-md-3  col-lg-push-2"
                                     style="font-size: 20px;font-weight: bold;color:white;margin-top: 10px;text-align: left;padding: 0px;">
                                    Page {{$comments->currentPage()}} of {{$comments->lastPage()}}
                                </div>
                                <div class="col-md-6 col-lg-push-2" align="center"
                                     style="margin-top: 10px;padding: 0px">
                                    @php
                                        $paginator = $comments;
                                    @endphp
                                    @if ($paginator->hasPages())
                                        <ul class="pagination pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($paginator->onFirstPage())
                                                <li class="disabled"><span>
                                        <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt=""
                                             class="loading" data-was-processed="true"/>
                                    </span></li>
                                            @else
                                                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><img
                                                            src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}"
                                                            alt="" class="loading" data-was-processed="true"/></a></li>
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
                                                <li class="hidden-xs"><a
                                                        href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                                                </li>
                                            @endif

                                            {{-- Next Page Link --}}
                                            @if ($paginator->hasMorePages())
                                                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next"> <img
                                                            src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}"
                                                            alt="" class="loading" data-was-processed="true"
                                                            style="transform: rotate(180deg)"></a></li>
                                            @else
                                                <li class="disabled"><span>
                                        <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt=""
                                             class="loading" data-was-processed="true"
                                             style="transform: rotate(180deg)">
                                    </span></li>
                                            @endif
                                        </ul>
                                    @endif
                                </div>
                                <div class="page-number jmp_to col-md-3"
                                     style=" margin-top: 10px;padding: 0px;float:right;width: 15%;">
                                    <form action="" method="GET">
                                        <input type="text" name="page"
                                               style="width:100%;height: 38px;background-color: #206bd9 !important;color:white;padding: 10px;border: 3px solid;"
                                               placeholder="Jump to Page:____">
                                        <button type="submit"
                                                style="transform: rotate(180deg);padding: 5px;background-color:Transparent;border: 0px;padding: 5px;position: absolute;right: 0px;top: 3px;">
                                            <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt=""
                                                 class="loading" data-was-processed="true">
                                        </button>
                                    </form>
                                </div>
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
        $(document).ready(function () {
            $(window).resize(function () {
                location.reload();
            });
            $(document).on('click', 'a.show-full', function (e) {
                e.preventDefault();
                $(this).closest('div').find('p.teaser').css('-webkit-line-clamp', 'initial').css('max-height', 'inherit');
                $(this).hide();
            });

            $('.blog-content-container').each(function () {
                var height = $(this).find('p.teaser').height();
                var fullHeight = $(this).find('p.teaser')[0].scrollHeight;
                if (fullHeight && fullHeight <= height + 2) {
                    $(this).find('a').remove();
                }
            });
        });
    </script>
@endpush