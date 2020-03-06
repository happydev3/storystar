@extends('admin.layout.two-column')


@section('SmallBanner')
    @include('admin.components.small-banner')
@stop



@section('RightSide')

    <script src="{{assets('js/plugin/jcrop/jquery.Jcrop.min.js')}}"></script>

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-server fa-fw "></i>
                    {{$pageData['MainHeading'] or ''}}

                </h1>
            </div>

        </div>


        <!-- widget grid -->
        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">

                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    <div class="jarviswidget jarviswidget-color-blueDark"
                         id="wid-id-1"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-editbutton="false"
                         data-widget-grid="false"
                         data-widget-colorbutton="false"
                         data-widget-sortable="false"

                    >

                        <header>
                            <span class="widget-icon"> <i class="fa fa-server"></i> </span>
                            <h2>Edit Star Thumbnails </h2>
                        </header>

                        <!-- widget div-->
                        <div>


                            <div class="widget-body">
                                <fieldset>

                                    <form class="form-horizontal star-portraits" method="POST"
                                          action="{{route('admin-star-thumb-creation',["id"=>59])}}">


                                        @if(isset($detailData)&&!empty($detailData))
                                            @forelse ($detailData as $k => $data)


                                                <div class="form-group">
                                                    <label class="col-md-10 control-label pull-left text-left">
                                                        <img src="{!! $data !!}"
                                                             id="target-{{$loop->iteration}}"/>
                                                    </label>

                                                    <input name="cor_{{$loop->iteration}}" type="hidden"
                                                           id="cor-{{$loop->iteration}}" style="color: red"/>

                                                    <input name="img_{{$loop->iteration}}" type="hidden"
                                                           id="img_{{$loop->iteration}}" style="color: red"
                                                           value="{{$data}}"/>

                                                </div>

                                                <script>

                                                    var aspect_ratio{{$loop->iteration}} = function () {


                                                        var thumbnail{{$loop->iteration}},
                                                            jcrop_api{{$loop->iteration}};

                                                        // Instantiate Jcrop
                                                        $('#target-{{$loop->iteration}}').Jcrop({
                                                            aspectRatio: 1,
                                                            // onChange: updateCoords{{$loop->iteration}},
                                                            //onSelect: updateCoords{{$loop->iteration}},
                                                            setSelect: [20, 20, 250, 170],
                                                            bgColor: 'blue',
                                                            bgOpacity: .4,
                                                            boxWidth: 400,
                                                            allowSelect:false,

                                                        }, function () {
                                                            jcrop_api{{$loop->iteration}} = this;
                                                            thumbnail{{$loop->iteration}} = this.initComponent('Thumbnailer', {
                                                                width: 180,
                                                                height: 180,
                                                                class: 'sss'
                                                            });

                                                            this.ui.preview = thumbnail{{$loop->iteration}};
                                                        });
                                                        //var jcrop_api{{$loop->iteration}} = $('#target-{{$loop->iteration}}').Jcrop('api').container;

                                                        console.log(jcrop_api{{$loop->iteration}});

                                                        jcrop_api{{$loop->iteration}}.ui.selection.element.on('cropmove', function (e, s, c) {
                                                            console.log(JSON.stringify(c));
                                                            $("#cor-{{$loop->iteration}}").val(JSON.stringify(c));
                                                        });
                                                        jcrop_api{{$loop->iteration}}.ui.selection.element.on('cropcreate', function (e, s, c) {
                                                            console.log(JSON.stringify(c));
                                                            $("#cor-{{$loop->iteration}}").val(JSON.stringify(c));
                                                        });


                                                    }

                                                    $(window).load(function () {
                                                        aspect_ratio{{$loop->iteration}}();
                                                    })


                                                </script>

                                            @empty
                                                <p>No Data Found</p>
                                            @endforelse
                                        @endif


                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">


                                                    <button class="btn bg-color-green txt-color-white" type="submit">
                                                        <i class="glyphicon glyphicon-fullscreen"></i>
                                                        Crop Thumbnails
                                                    </button>

                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="_method" value="patch">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">


                                    </form>
                                </fieldset>


                            </div>


                        </div>
                        <!-- end widget div -->

                    </div>


                </article>

            </div>


        </section>

    </div>
    <!-- END MAIN CONTENT -->


    <style>


        .jcrop-thumb {
            top: 15px;
            right: -20px;
            border: 1px black solid;
        }

        .jcrop-thumb:after {
            content: '';
            position: absolute;
            top: -15px;
            right: -9px;
            bottom: 0;
            left: -9px;
            display: block;
            opacity: .5;
        }

        .star-portraits .form-group:nth-child(1) .jcrop-thumb:after {
            background-image: url({{assets('img/star-1.png')}});
        }

        .star-portraits .form-group:nth-child(3) .jcrop-thumb:after {
            background-image: url({{assets('img/star-2.png')}});
        }

        .star-portraits .form-group:nth-child(5) .jcrop-thumb:after {
            background-image: url({{assets('img/star-3.png')}});
        }


    </style>

@stop



