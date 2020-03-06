@extends('app.layout.page')

@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <h1 class="text-xs-center author-heading text-uppercase">Reset your password</h1>
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">

                                <h1 class="story-info-title">Already Signed Up?
                                    <a href="{{route("login")}}">
                                        Login
                                    </a>
                                </h1>

                                <div class="clearfix"></div>


                                <form class="login" id="resetPasswordForm" method="POST"
                                      action="{{ route('password.request') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">
                                            <i class="fa-fw fa fa-times"></i>
                                            <strong>Error!</strong>
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif

                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            <i class="fa-fw fa fa-check"></i>
                                            <strong>Success!</strong>
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <div class="form-select-boxes margin-bottom-remove">
                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">Your Email</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input id="email" type="email" class="custom-input custom-select"
                                                       name="email"
                                                       value="{{ $email or old('email') }}" required autofocus>

                                                {{--@if ($errors->has('email'))--}}
                                                    {{--<span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span>--}}
                                                {{--@endif--}}

                                            </div>
                                        </div>


                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">Password</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">


                                                <input id="password" type="password" class="custom-select custom-input"
                                                       name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                                @endif

                                            </div>
                                        </div>


                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">Confirm Password</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input id="password_confirm" type="password"
                                                       class="custom-select custom-input"
                                                       name="password_confirmation" required/>


                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="form-select-left btn-style clearfix">
                                            <div class="text-xs-center btn btn-readstory publish-btn">
                                                <button type="submit">Reset Password</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('app.components.footer')
        </div>
    </div>

    @if(isset($jsValidation)&& $jsValidation == true)
        {!! $validator or '' !!}
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

