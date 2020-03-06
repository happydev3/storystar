<div class="add-comment-box" style="display: none;">
    <form method="post" id="mycomment-box"
          action="{{route("app-post-comment",['story_id'=>$story])}}"
          id="reply-box"
          onsubmit="return postComment($(this))">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="anonymous" value="{{ @$anonymous }}">

        <div>
            <textarea name="comment" id="" cols="30" rows="6"
                      placeholder="Write a comment" maxlength="5000" onkeydown="textCounter(this,'countera1',5000);"></textarea>

            <input class="comment-counter" disabled  maxlength="3" size="3" value="5000" id="countera1">
            
            <div>
                Please note the 5,000 character limit for your comment, after which the remaining text will be cut off.
            </div>
            
        </div>

        <div>
            <input type="submit" id="submit-post" value="Post">
        </div>
    </form>
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


<div class="comments-scroll">
    @foreach (array_chunk($comments->all(), 4) as $row)

        @foreach($row as $comment)
            @include("app.components.comment")
        @endforeach

    @endforeach

    {!! $comments->links() !!}

</div>