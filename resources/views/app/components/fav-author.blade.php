<div class="author_list">

    @forelse ($paginator as $author)
        @php
        $profileUrl = "";
        if ($author->author->stories()->count() ==1)
        {
                $profileUrl = route('app-story',['story_id'=>$author->author->stories()->first()->story_id]);
        }
        else
        {
        $profileUrl = route('app-profile',['user_id'=>$author->author->user_id,'user_name'=>str_slug($author->author->name)]);
        $profileUrl = $profileUrl."#profile";
        }
        @endphp



        <div class="stories-box" id="author-{{$author->author->user_id}}">
            <div class="col-md-12" style="display: flex;">
                <div class="author_img">
                    @if($author->author->avatar)
                        @if(file_exists(storage_path().'/users/'.$author->author->avatar ))
                            <a href="{{$profileUrl}}">
                                <img class="img-fluid" style="width: 75px" alt="{{ucfirst($author->author->name)}}"
                                     data-src="{{Image::url(storage_url($author->author->avatar,'users'), 212, 212, array('crop'))}}"
                                     width="75" height="75">
                            </a>
                        @else
                            <a href="{{$profileUrl}}">
                            <img class="img-fluid" style="width: 75px;"
                                 src="{{Image::url(storage_url('default.png', 'users'), 212, 212, array('crop'))}}"
                                 alt="default image">
                            </a>
                        @endif
                    @else
                        <img class="img-fluid" alt="{{ucfirst($author->author->name)}}"
                             data-src="{{Image::url(storage_url("default.png",'users'), 212, 212, array('crop'))}}"
                             width="75" height="75"
                        >
                    @endif

                </div>
                <div class="author-text">
                    <div class="author-details">
                        <span style="margin-left: 35px">
                            <a href="{{$profileUrl}}">
                                    {{ucfirst($author->author->name)}}
                                </a>
                        </span>
                    </div>

                    <div class="author-details">
                        <label>Country:</label>
                        <span><?= isset($author->author->country) && !empty($author->author->country) ? $author->author->country : ''?></span>
                    </div>
                    @if(\Auth::user())
                        @php
                            $favAdded = 1;
                        @endphp
                        <div class="author-heart-icon">
                            <a id="fav-user-{{$author->author_id}}" href="javascript:void(0)"
                               onclick="favAction({{$author->author_id}},'Remove')"
                               title="Remove {{strtoupper($author->name)}} from favorite list."
                               style="{{$favAdded==0?'display: none;':''}}"
                            >
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </a>
                            <a id="unfav-user-{{$author->author_id}}" href="javascript:void(0)"
                               onclick="favAction({{$author->author_id}},'Add')"
                               title="Add {{strtoupper($author->name)}} into favorite list."
                               style="{{$favAdded==1?'display: none;':''}}"
                            >
                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p style="text-align: center;color: #FFF;font-size: 20px;">No authors found</p>
    @endforelse

    <script>

        $(document).ready(function () {
            var $cs = $('.styled').customSelect();
        });

        function setSorting() {

            $("#sortby").val($("#sort").val());

            setTimeout(function () {
                $("#storiesSearchFrm").submit();
            }, 1000);
        }

        function favAction(user_id, action) {

            if (action == 'Add') {
                $("#unfav-user-" + user_id).hide()
                $("#fav-user-" + user_id).fadeIn()
            }
            else {
                $("#fav-user-" + user_id).hide()
                $("#unfav-user-" + user_id).fadeIn()
            }


            var formURL = '{{route("app-add-fav-author")}}/' + user_id + "/" + action;
            $.ajax({
                url: formURL,
                type: "get",
                success: function (data, textStatus, jqXHR) {

                    if (data.code == 200) {

                        $("#author-" + user_id).fadeOut()

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //if fails
                }
            });

            return false;

        }
    </script>

</div>

