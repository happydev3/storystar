@extends('app.layout.page')

@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">

                              <div class="alert alert-success">
                                  <i class="fa-fw fa fa-check"></i>
                                  <strong>Success!</strong>
                                  You have been successfully unsubscribed
                              </div>


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

@push( 'meta-data' )

<meta property="og:url" content="http://www.storystar.com/"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="unsubscribed"/>
<meta property="og:description" content="unsubscribed"/>
<meta property="og:image" content="https://www.storystar.com/assets/app/images/storystarcomfb.jpg"/>


<meta name="description" content="unsubscribed."/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,no-follow"/>
<meta name="language" content="en, gb"/> @endpush
