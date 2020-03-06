
@extends('admin.layout.two-column')
@section('SmallBanner')
@include('admin.components.small-banner')
@stop

@section('RightSide')
<div id="content">


    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-table fa-fw "></i>

                {!! $pageData['SubNav'] or '' !!}
            </h1>
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
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Add Blog </h2>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body no-padding">
                            <form method="POST" action="{{route('admin-blog')}}" accept-charset="UTF-8" id="ThemeFrm" name="ThemeFrm" class="smart-form" novalidate="novalidate" enctype="multipart/form-data">
                                <input name="_method" type="hidden" value="POST">
                                {{ csrf_field() }}
                                <fieldset class="html-form">
                                    <label>Add To:</label>
                                    <select name="section_id" class="form-control" style="width: auto!important;">
                                        <option value="{{$news}}">News & Info</option>
                                        <option value="{{$tip}}">Writing Tips</option>
                                        <option value="{{$inspiration}}">Writing Inspiration</option>
                                        <option value="{{$articles}}">Useful Articles</option>                                      
                                    </select><br>
                                    <div class="row">
                                        <section class="col col-6 no">Title:
                                            <label class="input ">

                                                <input placeholder="Title" id="theme_title" autocomplete="off" name="title" type="text" value="">
                                                <b class="tooltip tooltip-top-right">
                                                    <i class="fa fa-terminal txt-color-teal"></i>
                                                    Please enter title.
                                                </b>
                                            </label>
                                        </section>
                                    </div>

                                    <div class="row">
                                        <section class="col col-6 no">Content:
                                            <label class="input ">
                                                <textarea id="summernote" name="content" rows="4"></textarea>
                                               <b class="tooltip tooltip-top-right">
                                                    <i class="fa fa-terminal txt-color-teal"></i>
                                                    Please enter content.
                                                </b>
                                            </label>
                                        </section>
                                    </div>
                                </fieldset>
                                <footer>
                                    <div class="col-md-12">

                                        <button class="btn bg-color-magenta txt-color-white" type="submit">
                                            <i class="fa fa-save"></i>
                                            Submit
                                        </button>
                                        <a href="{{ URL::previous() }}">
                                            <button class="btn bg-color-red txt-color-white" type="button" id="cancelBtn" url="http://www.storie-star.lz/story-admin/theme/list">
                                                <i class="fa fa-chevron-left "></i>
                                                Cancel
                                            </button>
                                        </a>
                                    </div>

                                </footer>


                            </form>
                            <style>
                                .invalid {
                                    color: red !important;
                                }

                                textarea#the_story {
                                    resize: vertical;
                                    font-size: 17px;
                                    line-height: 23px;
                                }
                            </style>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>


            </article>

        </div>


    </section>
</div>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 

<!-- include summernote css/js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#summernote').summernote({
        toolbar: [],
        height:'150px'        
    });
});
</script>
@stop

