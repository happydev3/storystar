@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
<style>
   ol {
       padding-left: 0px !important;
       margin-left: 13px !important;
       font-size: 16px !important;
       font-weight: 600 !important;
   }
</style>
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-envelope-o fa-fw "></i>
                    E-mail preview
                </h1>
            </div>
        </div>

        <div role="content">
            <div class="widget-body no-padding">
                <div class="smart-form">
                    <form action="{{route('admin.email.store')}}" method="POST">
                        {!! csrf_field() !!}
                        <fieldset class="html-form" style="width: 85%">
                            <div class="row">
                                <section class="col col-12">
                                    Template name:
                                </section>
                                <section class="col col-12 no">
                                    <label class="input ">
                                        <i class="icon-append fa fa-terminal"></i>
                                        <input placeholder="Title" id="templateName" autocomplete="off" name="templateName"
                                               type="text" value="Random name">
                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-terminal txt-color-teal"></i>
                                            Please enter template name
                                        </b>
                                    </label>
                                </section>
                            </div>
                            <div class="row margin-bottom-10">
                                <section class="col col-12">
                                    Email subject:
                                </section>
                                <section class="col col-12 no">
                                    <label class="input ">
                                        <i class="icon-append fa fa-terminal"></i>
                                        <input placeholder="Title" id="subject" autocomplete="off" name="subject"
                                               type="text" value="This important news!">
                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-terminal txt-color-teal"></i>
                                            Please enter email subject
                                        </b>
                                    </label>
                                </section>
                            </div>


                            <div class="row">
                                <section class="col col-12">
                                    Greeting:
                                </section>
                                <section class="col col-12 no">
                                    <label class="input ">
                                        <i class="icon-append fa fa-terminal"></i>
                                        <input placeholder="Title" id="greeting" autocomplete="off" name="greeting"
                                               type="text" value="Hello!">
                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-terminal txt-color-teal"></i>
                                            Please enter first line
                                        </b>
                                    </label>
                                </section>
                            </div>

                            <div class="row" id="first-line">
                                <div style="width: 100%">
                                    <section class="col col-12">
                                        Message body:
                                    </section>
                                    <section class="col col-12 no" style="margin-bottom: 10px">
                                        <label class="input">
                                            <i class="icon-append fa fa-terminal"></i>
                                            <textarea name="introLines" id="introLines" style="min-width: 100%;max-width: 100%;min-height: 150px">First line
Second line</textarea>
                                            <b class="tooltip tooltip-top-right">
                                                <i class="fa fa-terminal txt-color-teal"></i>
                                                Please enter text
                                            </b>
                                        </label>
                                    </section>
                                </div>
                            </div>

                            <div style="padding: 20px; border-radius: 10px; border: solid 2px #e4e4e4; margin: 30px 0">
                                <div class="row">
                                    <section class="col col-12" style="display: flex;align-items: center;justify-content: center">
                                        Button action required:
                                        <input type="checkbox" name="button" id="button-checkbox" checked style="width: 20px;height: 20px;margin: 0;margin-left: 10px;">
                                    </section>
                                </div>

                                <div class="row">
                                    <section class="col col-12">
                                        Button text:
                                    </section>
                                    <section class="col col-12 no">
                                        <label class="input ">
                                            <i class="icon-append fa fa-terminal"></i>
                                            <input placeholder="Title" id="actionText" autocomplete="off" name="actionText"
                                                   type="text" value="Open website">
                                            <b class="tooltip tooltip-top-right">
                                                <i class="fa fa-terminal txt-color-teal"></i>
                                                Please enter first line
                                            </b>
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-12">
                                        Button link:
                                    </section>
                                    <section class="col col-12 no">
                                        <label class="input ">
                                            <i class="icon-append fa fa-terminal"></i>
                                            <input placeholder="Title" id="actionUrl" autocomplete="off" name="actionUrl"
                                                   type="text" value="https://www.storystar.com/">
                                            <b class="tooltip tooltip-top-right">
                                                <i class="fa fa-terminal txt-color-teal"></i>
                                                Please enter first line
                                            </b>
                                        </label>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <section class="col col-12">
                                    Signature:
                                </section>
                                <section class="col col-12 no">
                                    <label class="input ">
                                        <i class="icon-append fa fa-terminal"></i>
                                        <textarea name="salutation" id="salutation" style="min-width: 100%;max-width: 100%;min-height: 50px">Sincerely,
StoryStar Admin</textarea>
                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-terminal txt-color-teal"></i>
                                            Please enter first line
                                        </b>
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                        <footer>
                            <div class="col-md-6">
                                <button class="btn bg-color-red txt-color-white" style="float: left" id="refresh" type="button">
                                    <i class="fa fa-repeat"></i>
                                    Refresh preview
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn bg-color-greenDark txt-color-white" type="submit">
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>
                            </div>
                        </footer>
                    </form>

                </div>
            </div>
        </div>


        <div style="margin: 10px;border: solid;" id="HTML">
            {!! $HTML !!}
        </div>
    </div>

    <script>
        $('#refresh').click(function () {
            var greeting = $('input[name="greeting"]').val();
            var body = $('#introLines').val();
            var actionText = '';
            var actionUrl = '';
            if ($('#button-checkbox').prop('checked')){
                actionText = $('#actionText').val();
                actionUrl = $('#actionUrl').val();
            }
            var salutation = $('#salutation').val();
            $.ajax({
                method: "POST",
                url: "ajax",
                data: {
                    introLines: body,
                    greeting:greeting,
                    actionUrl:actionUrl,
                    actionText: actionText,
                    salutation: salutation,
                    _token: "{{ csrf_token() }}"
                },
            })
                .done(function( html ) {
                    $("#HTML").html( html );
                });
        });
    </script>
@stop
