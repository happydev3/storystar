
@if(isset($sub_comment->user)&&!empty($sub_comment->user))
    <div class="sub-user-box" style="width:85%;">
    <span class="user-comment-img">
    @if($sub_comment->user->avatar)
            <img src="{{Image::url(storage_url($sub_comment->user->avatar,'users'), 212, 212, array('crop'))}}"
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
                    if(isset($sub_comment->user->is_profile_complete)&&$sub_comment->user->is_profile_complete == 1){
                        $profileUrl = route('app-profile',['user_id'=>$sub_comment->user->user_id,'user_name'=>str_slug($sub_comment->user->name)]);
                        $profileUrl = $profileUrl."#profile";
                   }
            @endphp


                @if(isset($profileUrl)&&!empty($profileUrl))
                <h4>
                    <a href="{{$profileUrl}}">
                        {{ucfirst($sub_comment->user->name)}}
                    </a>
            </h4>
                @else
                <h4 style="color: inherit">
                    {{ucfirst($sub_comment->user->name)}}
                </h4>
                @endif


            <span>{{($sub_comment->created_at->format('m/d/Y'))}}</span>
            
            <p class="teaser">
                {!! str_limit(nl2br($sub_comment->comment), 200) !!}
                @if(strlen($sub_comment->comment)>200)
                    <i class="show-full" style="color:#07588d;cursor: pointer">Read More</i>
                @endif
            </p>
            <p class="complete hidden">{!! nl2br($sub_comment->comment) !!}</p>
         </div>
    </div>
@endif
