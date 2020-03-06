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
                        <span class="widget-icon"> <i class="fa fa-table fa-fw"></i> </span>
                        <h2>Edit Comment </h2>
                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
                    <!-- widget div-->
                    <div role="content">
                        <div class="widget-body no-padding">
                            <form method="POST" action="{{route('admin-update_comment',$edit_comment->id)}}" accept-charset="UTF-8" id="ThemeFrm" name="ThemeFrm" class="smart-form" novalidate="novalidate" enctype="multipart/form-data">
                                <input name="_method" type="hidden" value="PATCH">
                                {{ csrf_field() }}
                                <fieldset class="html-form">                                   

                                    <div class="row">
                                        <section class="col col-6 no">Comment:
                                            <label class="input ">                                                
                                                <textarea rows="8" cols="70" id="theme_title" name="comment" type="text">{{$edit_comment->comment}}</textarea>
                                               
                                            </label>
                                        </section>
                                    </div>
                                </fieldset>
                                <footer>
                                    <div class="col-md-12">

                                        <button class="btn bg-color-magenta txt-color-white" type="submit">
                                            <i class="fa fa-save"></i>
                                            Update
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
                    </div>
                </div>
            </article>
        </div>
    </section>

</div>
@stop