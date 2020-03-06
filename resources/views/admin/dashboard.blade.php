@extends('admin.layout.two-column')
@section('SmallBanner')
    @include('admin.components.small-banner')
@stop
@section('RightSide')

    <div id="content">


        <!-- widget grid -->
        <section id="widget-grid" class="dashboard">

            <!-- row -->

            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                    <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span>&gt; My Dashboard</span>
                    </h1>
                </div>
                {{--<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">--}}
                {{--<ul id="sparks" class="">--}}
                {{--<li class="sparks-info">--}}
                {{--<h5> Last Updated Time--}}
                {{--<span class="txt-color-blue">{{$lastProcessTime}}</span>--}}
                {{--</h5>--}}
                {{--</li>--}}

                {{--<li class="sparks-info">--}}
                {{--<h5> Success Backup--}}
                {{--<span class="txt-color-purple">--}}
                {{--<i class="fa fa-check-square ">--}}
                {{--</i>&nbsp;{{$totalPassed or 0}}</span>--}}
                {{--</h5>--}}
                {{--</li>--}}
                {{--<li class="sparks-info">--}}
                {{--<h5> Failed Backup--}}
                {{--<span class="txt-color-greenDark">--}}
                {{--<i class="fa fa-times "></i>&nbsp;--}}
                {{--{{$totalFailed OR 0}}--}}
                {{--</span>--}}
                {{--</h5>--}}
                {{--</li>--}}
                {{--<li class="sparks-info">--}}
                {{--<h5> Not Run Backup--}}
                {{--<span class="txt-color-purple">--}}
                {{--<i class="fa  fa-minus-square  ">--}}
                {{--</i>&nbsp;{{$totalNotRun or 0}}</span>--}}
                {{--</h5>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</div>--}}
            </div>


            <div class="row">


                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-user txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-site-member-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Member</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-site-member-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-commenting-o txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-stories-list", ["_all"]) ?>">
                                            <span style="color: #22262e;font-size: 23px;">Stories</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-stories-list", ["_all"]) ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-user txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-blog-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Blog</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-blog-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-suitcase  txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-theme-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Themes</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-theme-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-bullseye txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-subject-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Subjects</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-subject-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-check-circle-o  txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-category-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Categories</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-category-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-check-circle  txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-category-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Subcategories</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-category-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>


                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-star  txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-star-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Top Star Portraits</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-star-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-bookmark txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-ads-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Google Ads</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-ads-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-flag txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-flag-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Flagged Stories</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-flag-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>


                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-key  txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-member-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Back End Members</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-member-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-link  txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-links-edit", ['id' => 1]) ?>">
                                            <span style="color: #22262e;font-size: 23px;">Links</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-links-edit", ['id' => 1]) ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa-bank   txt-color-red fa-5x" style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-contest-edit", ['id' => 2]) ?>">
                                            <span style="color: #22262e;font-size: 23px;">Contest</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-contest-edit", ['id' => 2]) ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>


                <div class="col-sm-6 col-md-6 col-lg-4">
                    <!-- product -->
                    <div class="product-content product-wrap clearfix">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">

                                <div class="product-image">
                                    <i class="fa fa fa-newspaper-o  txt-color-red fa-5x"
                                       style="color: #22262e !important;"></i>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="product-deatil">

                                    <p class="price-container">
                                        <a href="<?= route("admin-subscriber-list") ?>">
                                            <span style="color: #22262e;font-size: 23px;">Subscriber</span>
                                        </a>
                                    <h5 class="name">
                                        <a href="<?= route("admin-subscriber-list") ?>">
                                            <span>Management</span>
                                        </a>
                                    </h5>

                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end product -->
                </div>

            </div>

        </section>

    </div>

@stop

