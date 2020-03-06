<div class="clearfix"></div>
<footer>
    <div class="footer-top">
        <div class="row">
            <div class="col-md-4 footer-top-visible">
                <form class="navbar-form footer-search" action="{{route("app-stories")}}" role="search">
                    <div class="input-group add-on">
                        <input name="s" id="s" class="form-control add-on-control" placeholder="Keyword Search Stories Here..." type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Keyword Search Stories Here...'">
                        <div class="input-group-btn">
                            <button class="btn btn-default search-icon-footer" type="submit"><i
                                        class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-xs-center">
                <h2 class="footer-title footer-title-border">FOLLOW US ON</h2>
                <ul class="footer-title footer-social-links twitter-link">
                    <li>
                        <a href="{{twitter_url}}" target="_blank">Twitter</a>
                    </li>
                </ul>
                <h2 class="footer-title footer-title-border">LIKE US ON</h2>
                <ul class="footer-title footer-social-links">
                    <li>
                        <a href="{{facebook_url}}" target="_blank">Facebook</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 text-xs-center">
                <h2 class="footer-title footer-title-border story-categories">STORY CATEGORIES</h2>
                <ul class="footer-title footer-social-links">

                    <li class="padding-remove-footer">
                        <?php
                        $allCategories = getCategories();
                        ?>
                        @if($allCategories)
                            @foreach($allCategories as $key=> $category)
                                <a href="{{route("app-story-category",["category"=>$key,"slug"=>str_slug($category)])}}"
                                   class="true-two {{$loop->last?"border-remove":""}}">
                                    {{strtoupper($category)}}
                                </a>
                            @endforeach
                        @endif
                    </li>
                    <?php
                    $allSubCategories = getSubCategories();
                    ?>
                    @if($allSubCategories)
                    <li>
                        @foreach($allSubCategories as $key=> $subcategory)
                            <a href="{{route("app-story-subcategory",["subcategory"=>$key,"slug"=>str_slug($subcategory)])}}" class="true-two">
                                {{strtoupper($subcategory)}}
                            </a>
                        @endforeach
                    </li>
                    @endif
                </ul>
            </div>
            <div class="col-md-4 text-xs-center">
                <h2 class="footer-title footer-title-border quick-title">QUICK LINKS</h2>
                <ul class="footer-title footer-social-links">
                    <li>
                        <a href="{{route("app-publish-story")}}">Publish Story</a>
                    </li>
                    <li>
                        <a href="{{route("app-stories")}}">Read Stories</a>
                    </li>
                    <li class="padding-remove-footer">
                        <!-- <a href="{{route("app-main")}}" class="true-two">Home</a> -->
                        <a href="{{route("app-contact")}}" class="true-two border-remove">Contact us</a>
                    </li>
                    <li>
                        <a href="{{route("app-about")}}">About us</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/10.3.3/lazyload.min.js"></script>
<script>  new LazyLoad(); </script>