<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @stack('js-first')
    

    
    @stack('meta-data')
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        $reqUri = '';
        $reqUri = trim($_SERVER['REQUEST_URI'],'/');
        $storyStarPageTitle = '';
        if (isset($pageData['PageTitle']) && !empty($pageData['PageTitle'])) {
            $storyStarPageTitle = $pageData['PageTitle'];
        } else {
            //$storyStarPageTitle = 'Where short story writers are the STARS & the best short stories shine!';
            $storyStarPageTitle = 'Storystar, for the best short stories by the world\'s short story writers!';
            //echo "Storystar is a totally FREE short stories site featuring some of the best short stories online, written by/for kids, teens, and adults of all ages around the world.";
        }
        switch ($reqUri) {
            case '':
                //$storyStarPageTitle = 'Storystar where short story writers are the STARS & the best short stories shine!';
                $storyStarPageTitle = 'Storystar, for the best short stories by the world\'s short story writers!';
                break;
            case 'about-us':
                $storyStarPageTitle = 'StoryStar.com – About us - Storystar is a free online library featuring the best short stories to read online.';
                break;
			case 'blog':
                $storyStarPageTitle = 'Storystar Blog | Storystar News & Information | StoryStar.com .';
                break;
			case 'login':
                $storyStarPageTitle = 'LOGIN TO YOUR ACCOUNT - Publish Story | StoryStar.com .';
                break;
			case 'sign-up':
                $storyStarPageTitle = 'Sign Up - CREATE YOUR ACCOUNT - Register| StoryStar.com .';
                break;
			case 'contact-us':
                $storyStarPageTitle = 'Contact Us - Contact / Suggestion Box | StoryStar.com ';
                break;
            //case 'stories':
            case 'read-short-stories':
                $storyStarPageTitle = 'Read short stories online | fiction & non-fiction | storystar';
                break;
            //case 'contests':
            case 'short-story-contests':
                $storyStarPageTitle = 'short story contest | storystar';
                break;
            case 'stories-category/1/true-life':
                $storyStarPageTitle = 'Real life Stories - Non-Fiction Stories';
                break;
            case 'stories-category/2/fiction':
                $storyStarPageTitle = 'Fiction Short Stories';
                break;
            case 'stories-subcategory/1/short-stories-for-kids':
                $storyStarPageTitle = 'Short Stories for Kids | Children’s Stories';
                break;
            case 'stories-subcategory/2/short-stories-for-teens':
                $storyStarPageTitle = 'StoryStar.com - Short stories for teens';
                break;
            case 'stories-subcategory/3/short-stories-for-adults':
                $storyStarPageTitle = 'StoryStar.com - Short stories for adults';
                break;
			case 'story-theme/41/classic-shorts':
                $storyStarPageTitle = 'Classic Short Stories by World Famous Writers';
                break;
					case 'story-theme/2/love-romance-2':
                $storyStarPageTitle = 'Read short love stories and romantic short stories';
                break;
				 case 'story-theme/35/science-fiction-2':
                $storyStarPageTitle = 'Read science fiction stories | storystar';
                break;
 case 'story-theme/31/mystery-crime-2':
                $storyStarPageTitle = 'Mysterious stories to read online | storystar';
                break;
 case 'story-theme/33/drama-interest-2':
                $storyStarPageTitle = 'Read human interest stories and dramatic stories';
                break;
 case 'story-theme/54/horror-scary-2':
                $storyStarPageTitle = 'Read horror stories and scary stories | storystar';
                break;
 case 'stories-subcategory/1/kids':
                $storyStarPageTitle = 'Short stories for kids | Storystar';
                break;
 case 'stories-subcategory/2/teens':
                $storyStarPageTitle = 'Short stories for teens | Storystar';
                break;
 case 'stories-subcategory/3/adults':
                $storyStarPageTitle = 'Short stories for adults | Storystar';
                break;
 case 'stories-category/1/true-life':
                $storyStarPageTitle = 'Real life Stories - Non-Fiction Stories';
                break;
 case 'stories-category/2/fiction':
                $storyStarPageTitle = 'Fiction Stories | storystar';
                break;

 case 'publish-story':
                $storyStarPageTitle = 'Publish Your Story';
                break;
 				 case 'story-subject/177/novels':
                $storyStarPageTitle = 'Free Online Novels and Books to Read.';
                break;
 case 'story-theme/3/family-friends-2':
                $storyStarPageTitle = 'Read short stories about family and friends.';
                break;
 case 'story-theme/32/inspirational-2':
                $storyStarPageTitle = 'Read inspirational stories | storystar';
                break;
 case 'story-theme/5/survival-success-2':
                $storyStarPageTitle = 'Read survival stories and success stories | storystar';
                break;
 case 'story-theme/36/fantasy-fairy-tale-2':
                $storyStarPageTitle = 'Read Fantasy stories and fairy tales | storystar';
                break;
 case 'story-theme/34/adventure-2':
                $storyStarPageTitle = 'Read adventure stories | storystar';
                break;
            default:
                $storyStarPageTitle = 'Storystar, where short story writers are the stars!';
        }
        echo $storyStarPageTitle;
        ?>
        {{--        {{ $pageData['PageTitle'] or 'Title Missing'}} | {{config('app.name')}}--}}
    </title>

   
    @stack('social-meta')
   
    <?php
    switch ($reqUri) {
		case '':
            echo '';
             break;
		case 'story-theme/41/classic-shorts':
            echo '<meta name="description" content="Read the Classics - Classic short stories by famous short Story writers around the world. Classic short fiction by the masters: Mark Twain, Victor Hugo, Virginia Woolf, James Joyce, H.G wells, Edger Allan Poe, Louisa May Alcott, Herman Melville, Rudyard Kipling, Leo tolstoy, Oscar Wilde, Zane Grey, Alice Munro, Jack London, Robert Louis, Stevenson, Hans Christian Andersen." />';
            break;
		case 'stories-category/1/true-life':
            echo '<meta name="description" content=" We have a wide variety of real life stories, true life stories, and non-fiction stories written by short story writers of all ages around the world for you to read online." />';
            break;
		case 'story-theme/41/classic-shorts':
            echo '<meta name="description" content="Read the Classics - Classic short stories by famous short Story writers around the world. Classic short fiction by the masters: Mark Twain, Victor Hugo, Virginia Woolf, James Joyce, H.G wells, Edger Allan Poe, Louisa May Alcott, Herman Melville, Rudyard Kipling, Leo Tolstoy, Oscar Wilde, Zane Grey, Alice Munro, Jack London, Robert Louis, Stevenson, Hans Christian Andersen." />';
            break;
		case 'stories-category/1/true-life':
            echo '<meta name="description" content=" We have a wide variety of real life stories, true life stories, and non-fiction stories written by short story writers of all ages around the world for you to read online." />';
            break;
		case 'stories-category/2/fiction':
            echo '<meta name="description" content="Read fiction stories online on storystar. We have a large collection of fiction short stories for kids, adults and teens. You can write and publish your own story too." />';

            break;
		case 'stories-subcategory/2/short-stories-for-teens':
            echo '<meta name="description" content="Short stories for teens, written by teens for teens, and by writers of all ages from around the world. We have a wide variety of short stories for teens in both fiction and non-fiction." />';
            break;
		case 'stories-subcategory/3/short-stories-for-adults':
            echo '<meta name="description" content="Read short stories for adults, written by writers from around the world. Our short stories collection includes fiction and non-fiction in theme categories such as love stories, funny stories, scary stories, science fiction, mystery, inspirational stories." />';
            break;
        case 'read-short-stories':
			echo '<meta name="description" content="Read Short Stories - Read the best short stories online by short story writers of all ages from around the world." />';
            break;
		case 'story-subject/177/novels':
            echo '<meta name="description" content=" Read free online novels, free books online and free eBooks online. Our free books to read section are a brand new feature so check back often for newly added online books to read." />';
            break;

		case 'stories-subcategory/1/short-stories-for-kids':
            echo '<meta name="description" content="Short stories for teens, written by teens for teens, and by writers of all ages from around the world. We have a wide variety of short stories for kids in both fiction and non-fiction." />';
            break;
		case 'story-theme/2/love-romance-2':
            echo '<meta name="description" content=" Read romance and love stories by writers of all ages from around the world. Storystar has the best short stories to read online, and romance lovers can read some of the most romantic love stories anywhere." />';
            break;
		case 'story-theme/3/family-friends-2':
            echo '<meta name="description" content=" Read the best short  stories online about family and friendship by short story writers of all ages from around the world. " />';
            break;
		case 'story-theme/32/inspirational-2':
            echo '<meta name="description" content=" Read the best short inspirational stories online by short story writers of all ages from around the world. Read our inspiring stories." />';
            break;
		case 'story-theme/5/survival-success-2':
            echo '<meta name="description" content=" Read the best short survival stories and success  stories  by short story writers of all ages from around the world. " />';
            break;
		case 'story-theme/36/fantasy-fairy-tale-2':
            echo '<meta name="description" content=" Read the best fairy tale and fantasy stories by short story writers of all ages from around the world.  " />';
            break;
        case 'story-theme/34/adventure-2':
            echo '<meta name="description" content=" Read the best short adventure stories online by short story writers of all ages from around the world. " />';
            break;
		case 'story-theme/35/science-fiction-2':
            echo '<meta name="description" content=" Read the best short science fiction stories online by short story writers of all ages from around the world. We have a large collection of science fiction to spark your intellect and imagination." />';
            break;
		case 'story-theme/31/mystery-crime-2':
            echo '<meta name="description" content=" Read mysterious stories and  crime stories by short story writers of all ages from around the world. Mysterious stories to read and true crime stories too." />';
            break;
		case 'story-theme/33/drama-interest-2':
            echo '<meta name="description" content=" Read the best short Dramatic stories and human interest stories by short story writers of all ages from around the world. " />';
            break;
		case 'story-theme/54/horror-scary-2':
            echo '<meta name="description" content=" Read the best short horror stories and scary stories, written by writers of all ages around the world." />';
            break;
		case 'short-story-contests':
            echo '<meta name="description" content=" Now accepting your short story submissions for our newest short story contests. You can win cash awards, front page stardom, and get published." />';
             break;
		case 'stories-subcategory/1/kids':
            echo '<meta name="description" content=" Short stories for kids, written by kids for kids, and by writers of all ages from around the world. We have a wide variety of short stories for kids in both fiction and non-fiction." />';
             break;
		case 'stories-subcategory/2/teens':
            echo '<meta name="description" content=" Short stories for teens, written by teens for teens, and by writers of all ages from around the world. We have a wide variety of short stories for teens in both fiction and non-fiction." />';
             break;
		case 'stories-subcategory/3/adults':
            echo '<meta name="description" content=" Read short stories for adults, written by writers from around the world. Our short stories collection includes fiction and non-fiction in theme categories such as love stories, funny stories, scary stories, science fiction, mystery, inspirational stories." />';
             break;
		
		//case stristr($reqUri,'story-theme'):
		case stripos($reqUri,'story-theme') !== false:
            echo '<meta name="description" content=" Short stories to read online free for everyone, including love stories, funny stories, scary stories, fantasy, mystery, inspirational, sci-fi, historical fiction, and many more..." />';
            break;




        default:
            echo '';
    }
    ?>


    <link href="{{app_assets("css/bootstrap.min.css")}}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/app/css/style.css?w=60') }}" rel="stylesheet" type="text/css">
<!--    <link href="{{app_assets("css/style.css")}}" rel="stylesheet" type="text/css">-->
    <link href="{{app_assets("css/font-awesome.min.css")}}" type="text/css" rel="stylesheet">
    <link href="{{app_assets("css/star-rating-svg.css")}}" type="text/css" rel="stylesheet">
    <!--link href="{{app_assets('css/app_style.css')}}" type="text/css" rel="stylesheet"-->
    <link href="{{ url('assets/app/css/app_style.css?v=4')}}" type="text/css" rel="stylesheet">

	<link rel="canonical" href="<?php echo 'https://www.storystar.com'.$_SERVER['REQUEST_URI'];?>" />
	
	

    
    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{app_assets('images/favicon/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{app_assets('images/favicon/favicon.ico')}}" type="image/x-icon">

    <script type="text/javascript" src="{{app_assets('js/jquery-3.2.0.min.js')}}"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="{{app_assets('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{app_assets('js/jquery.star-rating-svg.js')}}"></script>
    <script type="text/javascript" src="{{app_assets('js/jquery.customSelect.min.js')}}"></script>
    @stack('js-include')

    <script type="text/javascript" src="{{app_assets('js/app.js')}}"></script>
    <script type="text/javascript" src="{{app_assets('JavaScriptSpellCheck/include.js')}}"></script>

    <!-- Javascript Validation -->
    <script type="text/javascript" src="{{ url('public/vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    @stack('css')
    
    <meta name="google-site-verification" content="On-bcPdMpj0KwZlnSytBLsHmtGISxWo7iuftj3ISAmk" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-70090680-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-70090680-2');
    </script>
    

<!-- Schema -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://www.storystar.com/read-short-stories"
  },
  "headline": "Read Short Stories",
  "image": [
    "https://www.storystar.com/storage/themes/theme_7C3D3336-4E07-1096-87D7-8E631950E00A-image(96x66-crop).png",
    "https://www.storystar.com/storage/themes/theme_E7B0963A-70B1-26C2-9283-B4BF6328162F-image(96x66-crop).png",
    "https://www.storystar.com/storage/themes/theme_29EA0A2B-3256-15AF-898C-4CDCEE28006D-image(96x66-crop).png"
   ],
  "datePublished": "2018-10-23T08:00:00+08:00",
  "dateModified": "2018-10-23T09:20:00+08:00",
  "author": {
    "@type": "Person",
    "name": "Jd Larson"
  },
   "publisher": {
    "@type": "Organization",
    "name": "Story Star",
    "logo": {
      "@type": "ImageObject",
      "url": "https://www.storystar.com/assets/app/images/logo.png"
    }
  },
  "description": "Read the best short stories online by short story writers of all ages from around the world, listed below in order of the date they were published, with new 

stories first."
}
</script>


</head>

<body>

<style>
#canvas{
    height: 100%;
    width: 100%;
    position: fixed;
    z-index: -1;
}
</style>

<canvas id="canvas"></canvas>
<script>
    "use strict";

    var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d'),
        w = canvas.width = window.innerWidth,
        h = canvas.height = window.innerHeight,

        hue = 217,
        stars = [],
        count = 0,
        maxStars = 1400;

    // Thanks @jackrugile for the performance tip! https://codepen.io/jackrugile/pen/BjBGoM
    // Cache gradient
    var canvas2 = document.createElement('canvas'),
        ctx2 = canvas2.getContext('2d');
    canvas2.width = 100;
    canvas2.height = 100;
    var half = canvas2.width/2,
        gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
    gradient2.addColorStop(0.025, '#fff');
    gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
    gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
    gradient2.addColorStop(1, 'transparent');

    ctx2.fillStyle = gradient2;
    ctx2.beginPath();
    ctx2.arc(half, half, half, 0, Math.PI * 2);
    ctx2.fill();

    // End cache

    function random(min, max) {
        if (arguments.length < 2) {
            max = min;
            min = 0;
        }

        if (min > max) {
            var hold = max;
            max = min;
            min = hold;
        }

        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function maxOrbit(x,y) {
        var max = Math.max(x,y),
            diameter = Math.round(Math.sqrt(max*max + max*max));
        return diameter/2;
    }

    var Star = function() {

        this.orbitRadius = random(maxOrbit(w,h));
        // this.radius = random(60, this.orbitRadius) / 12;
        this.radius = random(200, this.orbitRadius) / 20;
        this.orbitX = w / 2;
        this.orbitY = h / 2;
        this.timePassed = random(0, maxStars);
        this.speed = 0;
        this.alpha = random(2, 10) / 10;

        count++;
        stars[count] = this;
    }

    Star.prototype.draw = function() {
        var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
            y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
            twinkle = random(100);

        if (twinkle === 1 && this.alpha > 0) {
            this.alpha -= 0.01;
        } else if (twinkle === 2 && this.alpha < 1) {
            this.alpha += 0.01;
        }

        ctx.globalAlpha = this.alpha;
        ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
        // this.timePassed += this.speed;
    }

    for (var i = 0; i < maxStars; i++) {
        new Star();
    }

    function animation() {
        ctx.globalCompositeOperation = 'source-over';
        ctx.globalAlpha = 0.8;
        ctx.fillStyle = 'hsla(' + hue + ', 100%, 28%, 1)';
        ctx.fillRect(0, 0, w, h)

        ctx.globalCompositeOperation = 'lighter';
        for (var i = 1, l = stars.length; i < l; i++) {
            stars[i].draw();
        };

        window.requestAnimationFrame(animation);
    }

    animation();
</script>


@if (session('csrf_error'))
    <div class="alert alert-block alert-danger">
        <a class="close" data-dismiss="alert" href="javascript:void(0)">×</a>
        <h5 class="alert-heading">Please Note!</h5>
        <p>
            {{ session('csrf_error') }}
        </p>
    </div>
@endif

<div class="main-wrapper main-wrapper1">
    <div class="inner-wrapper">
        @yield('header')
        @yield('bodyContent')


        <div class="clearfix"></div>
        <div id="toTop" class="btn btn-default">
            <i class="fa fa-chevron-up" aria-hidden="true"></i>
        </div>
    </div>
</div>
<div class="footer-bottom" style="background: url('/assets/app/images/footer.svg');background-size: cover;background-position: center top;">
    <form class="navbar-form footer-search footer-top-hidden" action="{{route("app-stories")}}" role="search">
        <div class="input-group add-on">
            <input name="s" id="s" class="form-control add-on-control" placeholder="Keyword Search Stories Here..."
                   type="text">
            <div class="input-group-btn">
                <button class="btn btn-default search-icon-footer" type="submit"><i
                        class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>
    <p class="copyright">&copy;2010-2020 <a href="{{route('app-main')}}">StoryStar</a>. All rights reserved.</p>
    <div class="row">
        <div class="col-xs-12" style="margin-top:20px;margin-bottom: 20px;">
            <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=storystar.com','SiteLock','width=600,height=600,left=160,top=170');"><img class="img-responsive loaded" alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/storystar.com" data-was-processed="true"></a> 
        </div>
    </div>
</div>


@stack('js')

{!! $jsValidator or '' !!}

<script type="text/javascript">
    $(function () {
        $("#menu").click(function () {
            $("#menutoggle").slideToggle("slow");
        });
    });

    $(function () {
        $("#sub-menu").click(function () {
            $("#sub-menutoggle").slideToggle("slow");
        });
    });

    $(window).scroll(function () {
        if ($(window).width() <= 767) {
            jQuery(this).scrollTop() > 100 ? jQuery("#toTop").fadeIn() : jQuery("#toTop").fadeOut();
        } else {
            jQuery("#toTop").hide();
        }
    });

    $(document).ready(function () {
        jQuery("#toTop").click(function () {
            return jQuery("html, body").animate({scrollTop: 0}, 800), !1
        });
    });
</script>



<style>
    #control {
        display: none;
    }
</style>

</body>
</html>










