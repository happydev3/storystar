@extends('app.layout.page')

@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <h1 class="text-xs-center author-heading text-uppercase">Create Your Account</h1>
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">
                                <h1 style="z-index:999;" class="story-info-title">Already Signed Up?
                                    <a href="{{route('login')}}">
                                        Login
                                    </a>
                                </h1>
                                <div class="clearfix"></div>


                                <form class="login" id="registerForm" role="form" method="POST"
                                      action="{{route("register")}}">
                                    {{ csrf_field() }}

                                    <div class="form-select-boxes margin-bottom-remove">
                                        <div class="form-select-left clearfix">
                                            <label class="title-padding" {{ $errors->has('name') ? ' has-error' : '' }}>
                                                Your Name
                                            </label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <input id="name" type="text" class="custom-select custom-input"
                                                       name="name" value="{{ old('name') }}"
                                                maxlength="35" title="max 35 characters">
                                                @if ($errors->has('name'))
                                                    {{ $errors->first('name') }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-select-left clearfix {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="title-padding">Your Email</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <input id="email" type="email" class="custom-select custom-input"
                                                       name="email"
                                                       value="{{ old('email') }}">
                                                @if ($errors->has('email'))
                                                    {{ $errors->first('email') }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-select-left clearfix  {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label class="title-padding">Password</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input id="password" type="password" class="custom-select custom-input"
                                                       name="password">
                                                @if ($errors->has('password'))
                                                    {{ $errors->first('password') }}
                                                @endif
                                            </div>
                                        </div>

                                        {{--<div class="form-select-left clearfix">--}}
                                        {{--<label class="title-padding">Confirm Password</label>--}}
                                        {{--<div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">--}}

                                        {{--<input id="password-confirm" type="password"--}}
                                        {{--class="custom-select custom-input"--}}
                                        {{--name="password_confirmation">--}}
                                        {{--@if ($errors->has('password_confirmation'))--}}
                                        {{--<span class="help-block">{{$errors->first('password_confirmation')}}</span>--}}
                                        {{--@endif--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        
                                       
                                        <div class="form-select-left btn-style clearfix">
                                            <div class="text-xs-center btn btn-readstory publish-btn">
                                                <button type="submit">Sign up</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                             <div style="z-index: -999; display: block; position: relative; text-align: center; color: #197cc7; margin-top: 10px; padding: 5px;">
                                            <span>If you're interested in becoming a Premium Member, click <a href="{{route('app-help')}}" target="blank" style="text-decoration: underline;">here</a> to learn more.</span>
                                        </div>

                        </div>
                    </div>
                </div>
            </div>
            @include('app.components.footer')
        </div>
    </div>

    @if($jsValidation == true)
        {!! $validator !!}
    @endif

@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        $(".custom-select").each(function () {
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom-select").change(function () {
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
    })
</script>
@endpush

@push('meta-data')
<meta name="description"
      content="Sign Up - CREATE YOUR ACCOUNT. A Totally FREE short stories site featuring some of the best short stories online."/>
<meta name="keywords" content="Sign Up, CREATE YOUR ACCOUNT"/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/>
@endpush