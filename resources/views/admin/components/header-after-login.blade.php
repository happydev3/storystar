<header id="header">
    <div id="logo-group">
        <a href="{{route('admin-login')}}">
            <span id="logo">
                <img id="logoimg" src="{{app_assets('images/welcome-logo.png')}}" alt="{{config('app.name')}}">
            </span>
        </a>
        <a href="{{route("admin-flag-list")}}">

            <?php

            $StoryFlag = \App\Models\Flag::
            join('stories', 'stories.story_id', '=', 'flag_story.story_id')
                ->where("stories.status", "=", "Inactive")
                ->whereNull("stories.deleted_at")
                ->count();

            if (isset($StoryFlag) && !empty($StoryFlag)):
            ?>
            <span id="activity" class="">

                <i class="fa fa-flag"></i>
             <b class="badge bg-color-red bounceIn animated">  <?=$StoryFlag;?> </b>

        </span>
            <?php
            endif;
            ?>


        </a>
    </div>


    <div class="pull-right">


        <div id="hide-menu" class="btn-header pull-right">
                <span>
                    <a class="nav-btn" href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu">
                        <i class="fa fa-reorder"> </i>
                    </a>
                </span>
        </div>
        <div id="logout" class="btn-header transparent pull-right">
                <span>
                    <a class="nav-btn" href="{{route('admin-logout')}}"
                       title="Sign Out"
                       data-action="userLogout"
                       data-logout-msg="Are you sure you want to logout?"><i
                                class="fa fa-sign-out">
            </i>
        </a>
        </span>
        </div>
        <div id="fullscreen" class="btn-header transparent pull-right">
                <span>
                    <a class="nav-btn" href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen">
                        <i class="fa fa-arrows-alt"></i>
                    </a>
                </span>
        </div>
        <div id="Settings" class="btn-header transparent pull-right">
                <span>
                    <a class="nav-btn" href="{{route("admin-settings")}}" title="Account Settings">
                        <i class="fa fa fa-cogs"></i>
                    </a>
                </span>
        </div>


        <div id="PublishStory" class="btn-header transparent pull-right ">
                <span class=" ">
                    <a id="link2" href="{{route("admin-stories-add")}}" title=" Publish Story">
                   <i class="fa fa-edit fa-fw "></i> Publish Story
                    </a>
                </span>
        </div>

        <div id="ReadStories" class="btn-header transparent pull-right ">
                <span>
                    <a id="link1" class="clearStories" href="{{route("admin-stories-clear")}}"
                       title="  Read Stories">
                   <i class="fa fa-commenting-o"></i> Read Stories
                    </a>
                </span>
        </div>

    </div>

</header>

<script>

    $(document).ready(function () {
        $("#activity").click(function () {


            window.location = $(this).parent().attr("href");
        });
    })

</script>