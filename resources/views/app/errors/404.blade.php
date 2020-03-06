<?php
$pageData['PageTitle'] = 'Page Not Found';
?>



@extends('app.layout.error')


@section('bodyContent')

    <section class="404" style="background-image: url('http://185.56.85.247/~dynamolo/storystar/assets/app/images/footer-bg.png');">
        <div class="body404" >
            <p class="error_404">
                404
                <img src="{{app_assets('/images/star.png')}}">
            </p>
            <p class="heading_error">
                PAGE NOT FOUND
            </p>
            <p class="para_error">My Gosh!! The page you are trying to visit does not exist or is not accessible.</p>
            <p class="para_error">Please Try your luck again.</p>
            <div class="text-xs-center btn btn-readstory read-mobile" style="background: none;box-shadow: none;">
                <a href="{{url('/')}}/read-short-stories">
                    Read Stories
                </a>
            </div>
        </div>

    </section>
    <style>
        .error_404 {
            font-size: 210px;
            font-weight: bold;
            position: relative;
            margin: 0px;
            color: white;
            text-shadow: 3px 0 0 #ffffff, -3px 0 0 #ffffff, 0 3px 0 #ffffff, 0 -3px 0 #ffffff, 2px 2px #ffffff, -2px -2px 0 #ffffff, 2px -2px 0 #ffffff, -2px 2px 0 #ffffff;
            /*letter-spacing: 25px;*/
        }
        .error_404 img{
             position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -75px;
            margin-top: -75px;
        }
        .body404{
            margin-top: 6%;
            padding-bottom: 95px;
        }
        .heading_error{
            color: #f8e515;
            font-size: 30px;
            text-shadow: 0px 0px 31px rgba(255,255,255,0.9);
            color: #fff;
            letter-spacing: 0.5px;
            line-height: 49px;
            font-family: 'TheSalvadorCondensed-Regular';
            font-weight: normal;

            text-transform: uppercase;
            color: #f4e21e;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 3px 0 0 #316797, -3px 0 0 #316797, 0 3px 0 #316797, 0 -3px 0 #316797, 2px 2px #316797, -2px -2px 0 #316797, 2px -2px 0 #316797, -2px 2px 0 #316797;
        }
        .para_error{
            font-family: 'Oxygen-Regular';
            font-size: 22px;
            color: #fff;
            font-weight: bold;
        }
        }
    </style>
@endsection




