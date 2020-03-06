<div class="sub-user-box" style="width:80%;">
    <span class="user-comment-img">
        @if($comment->user && $comment->user->avatar)
            <img src="{{Image::url(storage_url($comment->user->avatar,'users'), 212, 212, array('crop'))}}"
                 alt="user and $comment"
                 class="img-fluid">
        @else
            <img src="{{Image::url(storage_url("default.png",'users'), 212, 212, array('crop'))}}"
                 alt="users"
                 class="img-fluid">
        @endif
    </span>
    <div class="user-comment-box">
        <h4>
            @if($comment->user)
                <a href="{{route('app-profile',['user_id'=>$comment->user->user_id,'user_name'=>$comment->user->name])}}">
                    {{$comment->user->name}}
                </a>
            @else
            <a href="javascript:;">
                Anonymous User
            </a>
            @endif
        </h4>
        <span>{{($comment->created_at->diffForHumans())}}</span>
        <div class="blog-content-container">
            <p class="teaser" style="font-size: 14px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;">
                {!! nl2br($comment->comment) !!}                  
            </p>
            <a href="javascript:;" class="show-full" style="float:left;font-size:14px;font-weight: normal;" ><i style="cursor: pointer;color: #07588d;"> Read more</i></a> 
        </div>
    </div>
</div>
