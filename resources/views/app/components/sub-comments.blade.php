<div class="comments-scroll-sub" id="load-data-{{$story->story_id}}-{{$parentComment}}">
    @foreach($replies as $reply)
        @include("app.components.subcomment",['sub_comment'=>$reply])
    @endforeach
    <div style="clear: both"></div>
    @if($subCommentsCount>2)
        <div id="remove-row-{{$story->story_id}}-{{$parentComment}}" style="text-align: center; padding-top: 20px;">
            <button id="btn-more-{{$story->story_id}}-{{$parentComment}}"
                    data-id="{{$reply->comment_id}}"
                    data-story_id="{{$story->story_id}}"
                    data-parent_id="{{$parentComment}}"
                    class="btn-more">
                Load More
            </button>
        </div>
        <div id="loader-{{$story->story_id}}-{{$parentComment}}"></div>
    @endif
</div>
