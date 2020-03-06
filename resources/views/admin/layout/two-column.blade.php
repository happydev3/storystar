<?php use App\Models\Apps; ?>

@extends('admin.layout.master')

@section('header')
    @include('admin.components.header-after-login')
@stop

@section('bodyContent')

    <aside id="left-panel">
        <!-- User info -->
        <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it -->
            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                @if(Auth::user()->avatar == "")
                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="online"/>
                @else
                    <img src="{{Image::url(avatar_url(Auth::user()->avatar),100,100,array('crop'))}}"
                         alt="me" class="online"/>
                @endif
                <span>
                    {{Auth::user()->name}}
                </span>

            </a>
        </span>
        </div>
        <!-- end user info -->

        <nav>
            <!--
            NOTE: Notice the gaps after each icon usage <i></i>..
            Please note that these links work a bit different than
            traditional href="" links. See documentation for details.
            -->
            <ul>
                <li class="{{$pageData['MainNav']=='Dashboard'?'active':''}}">
                    <a href="{{route('admin-dashboard')}}" title="Dashboard">
                        <i class="fa fa-lg fa-fw fa-home"></i>
                        <span class="menu-item-parent">Dashboard</span>
                    </a>
                </li>
                {!! adminSideNavigation() !!}
            </ul>
        </nav>
        <span class="minifyme" data-action="minifyMenu">
            <i class="fa fa-arrow-circle-left hit"></i>
        </span>
    </aside>

    <div id="main" role="main">
        @yield('SmallBanner')
        @yield('RightSide')
    </div>

    <div class="page-footer" style="position:fixed;">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <span class="txt-color-white">
                    StoryStar 1.0 <span class="hidden-xs"> - CMS</span> © 2010-2020
                </span>
            </div>
            <div class="col-xs-6 col-sm-6 text-right hidden-xs">
                <div class="txt-color-white inline-block">
                    {{--<i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i>--}}
                    {{--<strong>52 mins ago &nbsp;</strong> </i>--}}
                </div>
            </div>
        </div>
    </div>

    <div id="shortcut" style="display:none;">
        {{--<ul>--}}
        {{--</ul>--}}
    </div>

@endsection