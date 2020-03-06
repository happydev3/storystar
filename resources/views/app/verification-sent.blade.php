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
                                <h1 class="story-info-title">Success</h1>
                                <div class="clearfix"></div>

                                @include('app.components.notification-messages')

                                <div class="form-select-boxes margin-bottom-remove">
                                    <div class="form-select-left clearfix font">
                                        <label class="title-padding">
                                            Already verified? <a href="{{ route('login') }}">Login</a>
                                        </label>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('app.components.footer')
        </div>
    </div>




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
