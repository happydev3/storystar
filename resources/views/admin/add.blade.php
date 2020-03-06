@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
    <style>
        .c_note {
            float: left;
            font-size: 16px !important;
            font-family: "Open Sans", Arial, Helvetica, Sans-Serif !important;
            padding-bottom: 2px !important;
            padding-left: 12px;
        }
    </style>
    @if(Request::segment(2)=="contest")
        <script src="https://www.storystar.com/assets/tinymce/js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: 500,
                theme: 'modern',
                plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help code',
                toolbar1: 'formatselect| fontsizeselect | sizeselect  | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
                image_advtab: false,
                fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                body_class: "mceBlackBody",
                content_css: "/assets/tinymce/js/tinymce/skins/lightgray/content.min.css?6",
            });
        </script>
    @endif

    <!-- MAIN CONTENT -->
    <div id="content">
        @if(Request::segment(2)=="stories")
            <div class="row">
                <div style="display:block">
                    <h5 class="c_note">(Note: If you have a NOVEL to post instead, please click
                        <a href="{{route('admin-novels-add')}}">HERE</a>)</h5>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-table fa-fw "></i>
                    {!! $pageData['MainHeading'] or '' !!}
                    <span>List {{$categoryStr or ''}}</span>
                </h1>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                @if(\Request::route()->getName() =="admin-stories-edit")
                    <a href="<?=route('admin-comments-list', \Request::route()->id);?>"
                       class="btn bg-color-darken btn-xl pull-right header-btn hidden-mobile" style="color: #FFF;">
                        <i class="fa fa-circle-arrow-up fa-lg"></i>Manage Story Comment
                    </a>
                @endif
            </div>
        </div>

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('admin.components.notification-messages')
                    <div class="jarviswidget jarviswidget-color-magenta"
                         id="add-frm"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-editbutton="false"
                         data-widget-grid="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                            <h2>{{$pageData['NavHeading'] or ''}} </h2>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                {!! $form or 'No Form Available' !!}
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->
                    </div>
                </article>
            </div>
        </section>
    </div>
    <!-- END MAIN CONTENT -->

    @if(\Request::route()->getName() =="admin-stories-edit")
        @include('admin.components.list')
    @endif

@stop



