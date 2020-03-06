<style>

    p.teaser{
        text-align: justify!important;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        line-height: 1.5em;
        max-height: 2.9em;
        overflow: hidden;
        font-family: 'Arial';
        font-weight: normal;
        font-style: normal;
    }
    .stories-box .reply-box{        
        background: inherit!important;
        padding: 0px!important;
        display: block;
    }

    .stories-box-color .sub-user-box{
        background: #d0bcfe;
    }
    .sub-user-box{
        margin-left: 95px;
        border: 2px solid #fff;
        float: left;
        padding: 2px 10px;
        background-color: #d8e7fe;
        margin-left: 84px;
    }
    .user-comment-box h4 {
        font-size: 15px!important;
        margin-top: 2px;
        margin-bottom: 5px;
        float:left;
    }
    .user-comment-img img {

        width: 35px;
        border-radius: 25px!important;
    }
    .user-comment-img{
        float:left;
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
        font-size: 12px;
    }
    .comments-scroll-sub{
        margin-top: 40px;
    }

    .comments-scroll-sub p.teaser{        
        max-height: 4.5em;
    }

    a.load-more-reply{
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
        margin-top: 10px;
        float: right;
    }
    .user-comment-box{
        font-family: 'Oxygen-Bold';
        font-weight: bold;
        color: #07588d;
        font-size: 18px;

        letter-spacing: 0.6px;
    }
    .sub-user-box .user-comment-box {
        padding-left: 70px;
    }
    .user-comment-box span {
        font-family: 'Oxygen-Regular';
        font-weight: 600;
        color: #07588d;
        float: right;
        letter-spacing: 0.6px;
        width: 16%;
        text-align: right;
        font-style: italic;
    }    
    .user-comment-box p{
        float: left;
        width:100%
    }
    #Story_TBL_filter{
        width:50%;
    }

    a.pin-container > i {
        color: #000000;
        font-size: 20px;
    }
    a.pin-container.pin-active > i{
        color: #ff0000;
    }
</style>
@extends('admin.layout.two-column')
@section('SmallBanner')
@include('admin.components.small-banner')
@stop

@section('RightSide')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link  rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-table fa-fw "></i>
                {!! $pageData['MainNav'] or '' !!}
            </h1>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href= {{route('admin-blog')}} class="btn bg-color-darken btn-xl pull-right header-btn hidden-mobile" style="color: #FFF;"><i class="fa fa-circle-arrow-up fa-lg"></i>Add Blog
            </a>
        </div>
    </div>
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

                <div class="row">
                    <!-- NEW WIDGET START -->
                    <article class="col-sm-12">
                    </article>
                    <!-- WIDGET END -->

                </div>
                <div class="jarviswidget jarviswidget-color-magenta jarviswidget-sortable" id="add-frm" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-grid="false" data-widget-colorbutton="false" role="widget">
                    <header role="heading"><div class="jarviswidget-ctrls" role="menu">    <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                        <span class="widget-icon"> <i class="fa fa-table fa-fw"></i> </span>
                        <h2>Blog List </h2>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
                    <!-- widget div-->
                    <div role="content" style="padding-bottom: 10px">
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom: 10px">
                                <select class="form-control" onchange="window.location.href = this.value" >
                                    <option value="" selected="" disabled="">Select Blog Type</option>
                                    @foreach(\App\Models\Blogs::BLOG_SECTIONS as $key => $section)
                                        <option {{ $key == $type?'selected=""':'' }} value="{{ route('admin-blog-list',$key) }}">{{ $section }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                        </div>
                        
                        <table  class="table table-striped table-bordered dataTable" id="Story_TBL">

                            <thead>
                            <th class="hidden"style="width: 7%;text-align: center;"></th>
                            <th class="hidden"style="width: 7%;text-align: center;"></th>
                            <th style="width: 90%;text-align: center;">Blog</th>

                            <th style="width: 10%;text-align: center;">Actions</th>
                            </tr>
                            </thead>


                            @foreach($blog as $blogs)
                            <tr>
                                <td class="hidden">
                                    {{$blogs->is_pin}}
                                </td>
                                <td class="hidden">
                                    {{$blogs->created_at}}
                                </td>
                                <td class="stories-box">
                                    <div class="">
                                        <span class="bordered-bottom" style="border-bottom: 1px solid black;padding-bottom: 0px;">
                                            <span style="color: #0e007a;font-size: 18px;font-family: 'Arial';font-weight: bold;font-style: normal;">
                                                {{ucfirst($blogs->title)}}                                               
                                            </span>                                                
                                        </span>&nbsp;
                                        <a href='{{route('admin-pin-blog',$blogs->id)}}'  class="pin-container {{ $blogs->is_pin==1?'pin-active':'' }}"
                                                   @if( $blogs->is_pin==1)
                                                   onclick="return confirm('Do You want to unpin this Blog?')"
                                                   @else
                                                   onclick="return confirm('Do You want to pin this Blog?')"
                                                   @endif

                                                   >
                                                   <i class="fa fa-thumb-tack" aria-hidden="true" ></i>
                                        </a>


                                        <span class="blog-post-date pull-right" style="font-size: 14px;">{{ \Carbon\Carbon::parse($blogs->created_at)->diffForHumans() }}</span> 
                                        <p class="blog-post-container"style="padding: 0px!important;margin: 4px 0px 0px!important;font-family: 'Arial';font-weight: bold;font-style: normal;" >
                                            <span class="blog-post-user" style="color:#000;font-size: 14px;">Posted by
                                                <span style="color:#3f49cf">                                
                                                    Storystar Admin,
                                                </span>
                                            </span> 
                                            @if($blogs->section_id == 1)
                                            <span style='font-size: 14px;font-weight: normal;'>Writing Tips</span>
                                            @elseif($blogs->section_id == 2)
                                            <span style='font-size: 14px;font-weight: normal;'>Writing Inspiration</span>
                                            @elseif($blogs->section_id == 3)
                                            <span style='font-size: 14px;font-weight: normal;'>Interesting Articles for Writers</span>
                                            @else
                                            <span style='font-size: 14px;font-weight: normal;'> News & Information</span>
                                            @endif
                                        </p>

                                        <div class="blog-content-container">
                                            <p class="teaser" style="font-size: 18px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;font-family: 'Arial';font-weight: normal;font-style: normal;">
                                                {!! nl2br($blogs->content) !!}                          
                                            </p>
                                            <a href="javascript:;" class="show-full" style="float:left;" >
                                                <i style="cursor: pointer;color: #07588d;"> Read more</i>
                                            </a>                     
                                        </div>
                                    </div>
                                    <p class="complete hidden" style="font-size: 16px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;font-family: 'Arial';font-weight: normal;font-style: normal;">{!! nl2br($blogs->content) !!}</p>

                                    <div class="comments-scroll-sub" id="load-data-15868-1352">

                                        @if(count($blogs->blogcomment) > 0)                                        
                                        @foreach($blogs->blogcomment as $comment)
                                        @include("admin.components.blog-comment",['comment' => $comment ])
                                        @endforeach

                                        @endif
                                        <p style="text-align: -webkit-center;padding:0px 0px 0px 0px!important;">
                                            <a class="load-more-reply" data-count="2">Load More..</a>
                                        </p>                            
                                    </div>

                                </td>
                                <td style="text-align: center;">
                                    <a href={{route('admin-edit_blog',$blogs->id)}} class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="">
                                        <i class="glyphicon glyphicon-edit"></i> Edit</a><br>
                                    <a href={{route('admin-delete_blog',$blogs->id)}} class="btn btn-xs btn-danger txt-color-white" rel="tooltip" 
                                        onclick="return confirm('Do You want to Delete this Blog?')"
                                        data-placement="top" data-original-title="">
                                        <i class="glyphicon glyphicon-remove"></i> Delete</a>
                                </td>
                            </tr>
                            @endforeach

                        </table>

                    </div>

                </div>
            </article>
        </div>
    </section>
</div>

@endsection
@push('js')

<script type="text/javascript" src="/assets/app/js/common-ajax-submit.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#Story_TBL').DataTable({
        "order": [[0, "desc"]],
        "orders": [[1, "asc"]],
        "fnDrawCallback": function (oSettings) {
            isHaveReadMore();
            limitReplayCount();

        }
    });
});
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
    var count = $(this).data('count');
    console.log(count);
    $(this).data('count', count + 10);
    var $div = $(this).closest('.stories-box').find('.comments-scroll-sub');
    limtViewLoadMore($div, count + 10)
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