@extends('admin.layout.two-column')


@section('SmallBanner')
    @include('admin.components.small-banner')
@stop



@section('RightSide')

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
                    @include('admin.components.notification-messages')

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
                            <h2>Detail Record</h2>
                        </header>

                        <!-- widget div-->
                        <div>


                            <div class="widget-body">
                                <fieldset>
                                    {{--<legend>Default Form Elements</legend>--}}



                                    @if (isset($actions) && !empty($actions))
                                        @forelse ($actions as $k => $action)
                                            <div class="setting_btn">
                                                {!! $action !!}
                                            </div>
                                        @empty
                                        @endforelse
                                    @endif

                                    <form class="form-horizontal">

					
                                        @if(isset($detailData)&&!empty($detailData))
                                            @forelse ($detailData as $k => $data)

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">
                                                        <b>{{$k}}</b>
                                                    </label>
                                                    <label class="col-md-10 control-label pull-left text-left">
                                                        {!! $data !!}
                                                    </label>
                                                </div>
                                            @empty
                                                <p>No Data Found</p>
                                            @endforelse
                                        @endif


                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <a href="{{ URL::previous() }}"
                                                       class="btn bg-color-magenta txt-color-white">
                                                        <i class="glyphicon glyphicon-chevron-left"></i>Back
                                                    </a>

                                                </div>
                                            </div>
                                        </div>

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

    <script>
        // When user click on delete btn . It is showing confirmation
        function confirmBox(value) {
            $.SmartMessageBox({
                title: ' <i class="fa fa-trash txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to delete this record?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }

        // When user click on delete btn . It is showing confirmation
        function confirmBoxOnBlock(value) {
            $.SmartMessageBox({
                title: ' <i class="fa  fa-exclamation txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to change status of this user?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }
    </script>
@stop



