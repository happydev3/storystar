
<div class="sub-user-box" style="width:80%;">
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
        if(isset($comment->user) && isset($comment->user->is_profile_complete)&&$comment->user->is_profile_complete == 1){
        $profileUrl = route('app-profile',['user_id'=>$comment->user->user_id,'user_name'=>str_slug($comment->user->name)]);
        $profileUrl = $profileUrl."#profile";
        }
        @endphp
        <h4 >
            @if(isset($profileUrl)&&!empty($profileUrl))
            <a href="{{$profileUrl}}" style="font-size: 16px">
                {{($comment->user)?ucfirst($comment->user->name):'Anonymous User'}}
            </a>
            @else
            {{($comment->user)?ucfirst($comment->user->name):'Anonymous User'}}
            @endif
        </h4>
        <span style="font-size: 13px!important">{{($comment->created_at->diffForHumans())}}</span>
        <div class="blog-content-container">
            <p class="teaser" style="font-size: 16px;line-height: 1.42857143;color: #333;padding: 0px 0px 0px;">
                {!! nl2br($comment->comment) !!}
                

            </p>
            <a href="javascript:;" class="show-full" style="float:left;" ><i style="cursor: pointer;color: #07588d;"> Read more</i></a>
            
        </div>        
    </div>   
    <br><a href={{route('admin-edit_comments',$comment->id)}} class="btn btn-xs btn-primary" style="float:right;margin-left:3px;">
                    <i class="glyphicon glyphicon-edit"></i></a> 
                <a href={{route('admin-delete_comment',$comment->id)}} class="btn btn-xs btn-danger txt-color-white" style="float:right">
                    <i class="glyphicon glyphicon-remove"></i></a>
</div>



