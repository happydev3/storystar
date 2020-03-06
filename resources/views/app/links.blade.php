@extends( 'app.layout.page' )
@section( 'bodyContent' )

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <div about-us>
                            <a name="profile"></a>
                            <h1 class="text-xs-center author-heading">Links</h1>
                            <div class="author-profile-box">
                                <p class="author-top-content">

                                    <?php
                                    $Data = App\Models\Content::find(1);
                                    ?>
                                    {!!trim(convertLinks($Data->content)) !!}
                                </p>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!--author-middle-bg-->
                </div>

            </div>
            @include("app.components.footer")
        </div>
    </div>
@endsection