<style>
    
</style>
<div class="post row">
    <div class="user-boxes ">
                  <span class="user-comment-img">
                      @if($comment->user && $comment->user->avatar)
                          <img src="{{Image::url(storage_url($comment->user->avatar,'users'), 212, 212, array('crop'))}}"
                               alt=""
                               class="img-fluid">
                      @else
                          <img src="{{Image::url(storage_url("default.png",'users'), 212, 212, array('crop'))}}"
                               alt=""
                               class="img-fluid">
                      @endif
                  </span>
        <div class="user-comment-box">

            @php
                $profileUrl = "";
                    if(isset($comment->user) && isset($comment->user->is_profile_complete) && $comment->user->is_profile_complete == 1){
                        $profileUrl = route('app-profile',['user_id'=>$comment->user->user_id,'user_name'=>str_slug($comment->user->name)]);
                        $profileUrl = $profileUrl."#profile";
                   }
            @endphp


                @if(isset($profileUrl) && !empty($profileUrl))
                <h4>
                    <a href="{{$profileUrl}}">
                        {{($comment->user)?ucfirst($comment->user->name):'Anonymous User'}}
                    </a>
                </h4>
                @else
                <h4 style="color: inherit">
                    {{($comment->user)?ucfirst($comment->user->name):'Anonymous User'}}
                </h4>
                @endif


            <span>{{($comment->created_at->format('m/d/Y'))}}</span>
            
            <p class="teaser">
                {!! str_limit(nl2br($comment->comment), 400) !!}
                @if(strlen($comment->comment)>400)
                <br><i class="show-full" style="color:#07588d;cursor: pointer">Read More</i>
                @endif
            </p>
            <p class="complete hidden">{!! nl2br($comment->comment) !!}</p>
           
<!--            <p class="teaser">
                {!! str_limit(nl2br($comment->comment), 550) !!}
                @if(strlen($comment->comment)>550)
                <i class="show-full" style="cursor: pointer;color: #07588d;"> Read more</i>
                @endif
            </p>
            <p class="complete hidden">{!! nl2br($comment->comment) !!}</p>-->

            <a href="javascript:void(0)" data-comment_id="{{$comment->comment_id}}"
               class="reply-btn" style="float:right;">Reply</a>
               
        </div>

        <div class="reply-box" id="reply-{{$comment->comment_id}}">
            <form method="post"
                  action="{{route("app-post-comment-reply",['story_id'=>$story,'comment_id'=>$comment->comment_id])}}"
                  id="reply-box"
                  onsubmit="return postReplay($(this))"
            >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="replycomment">

                    <textarea name="comment" id="replyText" cols="30" rows="2"
                                          placeholder="Write a comment" maxlength="5000" onkeydown="textCounter(this,'countera{{$comment->id}}',5000);"></textarea>

                    <input class="comment-counter" disabled  maxlength="3" size="3" value="5000" id="countera{{$comment->id}}" style="background: initial;
    border: none;
    border-radius: 0;    font-family: 'Oxygen-Regular';
    float: none;    letter-spacing: initial;">
                    <div style="text-align: left;padding-left: 94px;font-weight: bold;">Please note the 5,000 character limit for your comment, after which the remaining text will be cut off.</div>
                </div>
                <div>
                    <input type="submit" placeholder="Reply" value="Reply"/>
                </div>
            </form>
        </div>
        <div>
        </div>

        <script>
            function textCounter(field,field2,maxlimit)
            {
                var countfield = document.getElementById(field2);
                if ( field.value.length > maxlimit ) {
                    field.value = field.value.substring( 0, maxlimit );
                    return false;
                } else {
                    countfield.value = maxlimit - field.value.length;
                }
            }
        </script>


        <?php
        $subComments = $comment->children()->get();
        $subCommentsCount = $subComments->count();
        $parentComment = $comment->comment_id;


        $replies = [];


        if (isset($subCommentsCount) && $subCommentsCount > 0) {

        $repliesPages = $comment->children()->paginate(2);
        $replies = $repliesPages->all();


        ?>
        @include("app.components.sub-comments")
        <?php
        }
        ?>
    </div>
</div>
