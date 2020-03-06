<div class="stories-boxes">
    @forelse ($paginator as $story)
        <div id="story-{{$story->story_id}}" class="stories-box
            @if($loop->iteration  % 2 == 0) stories-box-color @endif">
            <div class="col-md-9 stories-box-title">
                <?php //if ($_SERVER['REMOTE_ADDR'] == "106.215.82.70") { 
                //print_r($story->theme);
                //echo $story->story_id."=>>".ucfirst(htmlspecialchars_decode(html_entity_decode($story->story_title)));
                $slug_theme = "";
                if (isset($story->theme)) {
                    $slug_theme = str_slug($story->theme->theme_slug);
                }   
                ?> 
                <a href="{{route("app-storynew",['story_id'=>$story->story_id,'user_name'=>str_slug($story->author_name),'category'=>str_slug($story->category->category_title),'theme'=>$slug_theme])}}"
                   class="stories-name-a">
                    {{ucfirst(htmlspecialchars_decode(html_entity_decode($story->story_title)))}}
                </a>
                <span class="nolink">
                    <span class="by">By</span>
                    {{isset($story->author_name)&&!empty($story->author_name)?ucfirst($story->author_name):ucfirst($story->user->name)}}
                </span>
                <?php
                $callFrom = isset($callFrom) ? $callFrom : '';
                ?>

                @if(\Auth::user())


                    @if($story->self_story == 1)


                        @if($callFrom =='favStories')

                            @php
                                $favAdded = ($story->favstories->where("user_id", "=", \Auth::user()->user_id)->where("story_id", "=", $story->story_id)->count());
                            @endphp


                            @if(Route::currentRouteName() =="app-fav-stories")

                                <span class="red-heart">

                                    <a href="javascript:void(0)"
                                       id="fav-story-{{$story->story_id}}"
                                       onclick="favAction({{$story->story_id}},'Remove')"
                                       title="Remove story from favorite stories list."
                                       style="{{$favAdded==0?'display: none;':''}}">
                                    <i class="fa fa-heart"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       id="fav-story-{{$story->story_id}}"
                                       onclick="favAction({{$story->story_id}},'Add')"
                                       title="Add story to favorite stories list."
                                       style="{{$favAdded==1?'display: none;':''}}">
                                    <i class="fa fa-heart-o"></i>
                                    </a>

                                </span>

                            @endif
                        @endif



                        @if( $story->user_id == \Auth::user()->user_id && $callFrom !='favStories')

                            @if(isset($story->is_rated)&&!empty($story->is_rated))

                                <a href="javascript:void(0)"
                                   class="story_edit"
                                   title="The Story is already rated. You can not update it now.">
                                    <i class="fa fa-pencil-square-o"
                                       style="opacity: 0.5;color: gray;cursor: not-allowed;"></i>
                                </a>

                            @else
                                @if($story->subject_id == "177")
                                    <a href="{{route('app-edit-novel',['story_id'=>base64_encode($story->story_id."__".time())])}}"
                                   class="story_edit" title="Edit Novel"> <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                @else
                                    <a href="{{route('app-edit-story',['story_id'=>base64_encode($story->story_id."__".time())])}}"
                                   class="story_edit" title="Edit Story"> <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                @endif
                            @endif

                        @endif



                    @endif


                @endif


            </div>

            @php
                $url = route("app-story-rating-no",[$story->story_id]);
                $totalRate = "0";
                $totalVotes = "0";
                $totalViews =  isset($story->views)?$story->views:0;



                if(isset($story->rate)):
                    $url = route("app-story-rating",[$story->rate->story_id]);
                    $totalVotes =  $story->rate->r1 + $story->rate->r2 + $story->rate->r3 + $story->rate->r4 + $story->rate->r5;
                    $totalRate = isset($story->rate->story_id)?number_format($story->rate->average_rate,1):0;

                endif;

            @endphp


            <div class="col-md-3">
                <a href="{{$url}}">
                    <div class="author-storie-star-box"
                         title="Please rate this story&#13Average Story Rating: {{$totalRate}}&#13No. of View(s): {{$totalViews}}  &#13No. of Vote(s): {{$totalVotes}}">
                        <div class="my-rating" data-rating="{{$totalRate}}"></div>
                    </div>
                </a>
            </div>

            <p>{{$story->short_description OR ''}}</p>

        </div>
    @empty
        <p style="text-align: center;color: #FFF;font-size: 20px;">No stories found</p>
    @endforelse


</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".my-rating").starRating({
            initialRating: 0,
            starSize: 25,
            strokeWidth: 20,
            strokeColor: '#e5c71c',
            emptyColor: '#E7E7E7',
            //emptyColor: 'transparent',
            hoverColor: '#ffdb00',
            readOnly: true,
            starGradient: {
                start: '#ffff00',
                end: '#ffab00'
            }
        });


        var $cs = $('.styled').customSelect();

        $(".custom-select").each(function () {
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });

        $(".searchIcon").click(function () {
            submitForm();
        });

        $(".jq-star").hover(function () {
            var title = $(this).parent().parent().attr("title");
            $(this).attr("title", title);
        });
        
        $('.c_page_no').keypress(function (e) {
            var key = e.which;
            if(key == 13)  // the enter key code
            {
                var page_no = $("#last_page_no").val();
                goToPage(page_no);
                return false;  
            }
        });
        /*Added by MT*/
        $('.c_page_no').keyup(function(e) {
            var txtVal = $(this).val();
            $('.c_page_no').val(txtVal);
        });
        
        $(".c_page_no").on("click",function(){
            $(".c_page_no").removeAttr("placeholder");
        });
        
        $(".c_page_no").on("focusout",function(){
            if($(".c_page_no").hasAttr("value")){
                $(".c_page_no").attr("placeholder","Jump to pg:____");
            }else{
                $(".c_page_no").removeAttr("placeholder");
            }
        });
        
        $(".c_page_no").on('click',function(){
            if($(this).val()!=""){
                $(".c_page_no").removeAttr("value");
            }
        });

        /*Added by MT*/
    });
    function submitForm() {
        $("#storiesSearchFrm").submit();
    }
    function setSorting() {

        $("#sortby").val($("#sort").val());

        setTimeout(function () {
            $("#storiesSearchFrm").submit();
        }, 1000);
    }

    function goToPage(obj) {
        console.log(obj);
        $(".c_page_no").closest("span").css("border", "3px solid #fff");
        //$("#page_no").closest("span").css("border", "3px solid #fff");    
        var last_page = parseInt(obj);
        //var page_no = parseInt($("#page_no").val());
        var x = $($(".c_page_no")[0]).val();
        if(x){
            var page_no = parseInt(x);
        }else{
            var page_no = parseInt($($(".c_page_no")[1]).val());
        }           
                
        if(page_no > 0){
            console.log('yesh');
            if(page_no > last_page){
                console.log('wrong page number enter!');
                $(".c_page_no").closest("span").css("border", "3px solid red");
                //$("#page_no").closest("span").css("border", "3px solid red");
            }else{
                window.location = 'https://www.storystar.com/read-short-stories?page='+page_no;
            }
        }else{
            //$("#page_no").closest("span").css("border", "3px solid red");
            $(".c_page_no").closest("span").css("border", "3px solid red");
        }       
        console.log(page_no);       
        //window.location = obj.val();
    }

    function changeLimit(obj) {


        setTimeout(function () {

            $("#limit").val(obj.val());
            $("#storiesSearchFrm").submit();
        }, 1000);


        //    window.location = obj.val();

    }


    function favAction(story_id, action) {


        $("#story-" + story_id).fadeOut()

        var formURL = '{{route("app-add-fav-stories")}}/' + story_id + "/" + action;
        $.ajax({
            url: formURL,
            type: "get",
            success: function (data, textStatus, jqXHR) {

                if (data.code == 200) {

                    $("#story-" + story_id).fadeOut()

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //if fails
            }
        });
        return false;
    }
</script>