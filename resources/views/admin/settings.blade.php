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
                    <i class="fa fa-tasks  fa-fw "></i>
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

                    <div class="jarviswidget jarviswidget-color-green"
                         id="add-frm"
                         data-widget-togglebutton="true"
                    >


                        <header>
                            <span class="widget-icon"> <i class="fa fa-cogs"></i> </span>
                            <h2>Account Settings</h2>

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
@stop
