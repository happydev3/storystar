@extends('app.layout.page')

@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <h1 class="text-xs-center author-heading text-uppercase">Reset Your Password</h1>
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">
                                <h1 class="story-info-title">Already Signed Up?
                                    <a href="{{route("login")}}">
                                        Login
                                    </a>
                                </h1>
                                <div class="clearfix"></div>


                                <form class="login" id="requestForm" method="POST"
                                      action="{{ route('password.email') }}">
                                    {{ csrf_field() }}


                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            <i class="fa-fw fa fa-check"></i>
                                            <strong>Success!</strong>
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">
                                            <i class="fa-fw fa fa-times"></i>
                                            <strong>Error!</strong>
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif


                                    <div class="form-select-boxes margin-bottom-remove">
                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">Your Email</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input id="email" type="email" class="custom-select custom-input"
                                                       name="email"
                                                       value="{{ old('email') }}" required autofocus>

                                            </div>
                                        </div>


                                        <div class="form-select-left btn-style clearfix">
                                            <div class="text-xs-center btn btn-readstory publish-btn">
                                                <button type="submit">Send Reset Link</button>
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
