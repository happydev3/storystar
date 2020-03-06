@extends('app.layout.page')
@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">

                        <!--about us-->
                        <div coming-soon>
                        	<img src="{{app_assets("images/coming.png")}}" class="img-fluid" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
            @include("app.components.footer")
        </div>
    </div>
@endsection
