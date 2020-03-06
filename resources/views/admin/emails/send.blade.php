@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')

    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-envelope-o fa-fw "></i>
                    Bulk email sending
                </h1>
            </div>
        </div>

        <div role="content">
            <div class="widget-body no-padding">
                <div class="smart-form">
                    <form action="{{route('admin.email.sending')}}" method="POST">
                        <fieldset class="html-form" style="width: 85%">
                            <div class="row">
                                <section class="col col-12">
                                    <strong>Select template:</strong>
                                </section>
                                @foreach($templates as $template)
                                    <section class="col col-md-12">
                                        <input type="radio" name="template" value="{{$template['Name']}}"
                                               id="{{$template['Name']}}">
                                        <label for="{{$template['Name']}}">{{$template['Name']}}</label>
                                    </section>
                                @endforeach
                            </div>

                            <div class="row margin-top-10 padding-top-15">
                                <section class="col col-12">
                                    <strong>Select users group:</strong>
                                </section>
                                <section class="col col-md-12">
                                    <input type="radio" name="group" value="1"
                                           id="group1">
                                    <label for="group1">All members ({{$all_count}} emails, about {{ceil($all_count/10/60)}} minutes)</label>
                                </section>
                                <section class="col col-md-12">
                                    <input type="radio" name="group" value="2"
                                           id="group2">
                                    <label for="group2">Writers ({{$writers_count}} emails, about {{ceil($writers_count/10/60)}} minutes)</label>
                                </section>
                                <section class="col col-md-12">
                                    <input type="radio" name="group" value="3"
                                           id="group3">
                                    <label for="group3">Readers ({{$readers_count}} emails, about {{ceil($readers_count/10/60)}} minutes)</label>
                                </section>
                                <section class="col col-md-12">
                                    <input type="radio" name="group" value="4"
                                           id="group4">
                                    <label for="group4">Premium members ({{$premium_members_count}} emails, about {{ceil($premium_members_count/10/60)}} minutes)</label>
                                </section>


                            </div>

                        </fieldset>
                        <footer>
                            <div class="row">
                                <section class="col col-md-12">
                                    <button class="btn bg-color-greenDark txt-color-white" type="submit" id="submit">
                                        <i class="fa fa-envelope"></i>
                                        Start sending e-mails
                                    </button>
                                </section>
                            </div>
                        </footer>
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
        </div>
    </div>






    <script>
        $('form').submit(function()
        {
            $("input[type='submit']", this)
                .val("Please Wait...")
                .attr('disabled', 'disabled');

            return true;
        });

    </script>
@stop
