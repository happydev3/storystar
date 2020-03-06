@extends('app.layout.page')

@push('js-include')
<script type="text/javascript" src="{{app_assets('js/jquery.jscroll.js')}}"></script>
@endpush

@section('bodyContent')
    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg author-middle-bg2">

                        <div class="individu-story-section">
                            <div class="harvesting-left" style="width: 100%;">

                                <h1 class="story-info-title">Your selected story,
                                    "{{replaceSlashWithAnd($story->story_title)}}", currently has
                                    the following ratings:
                                </h1>

                                <div class="story_rating_text" style="font-family: Verdana, Arial, Helvetica, sans-serif;">
									<p class="">1 star rating given by <strong>{{$Rating['r1'] OR 0}}</strong>
                                        readers.</p>
                                    <p class="">2 star rating given by <strong>{{$Rating['r2'] OR 0}}</strong>
                                        readers.</p>
                                    <p class="">3 star rating given by <strong>{{$Rating['r3'] OR 0}}</strong>
                                        readers.</p>
                                    <p class="">4 star rating given by <strong>{{$Rating['r4'] OR 0}}</strong>
                                        readers.</p>
                                    <p class="">5 star rating given by <strong>{{$Rating['r5'] OR 0}}</strong>
                                        readers.</p>
                                    <p class="">Total average  = {{number_format($Rating['average_rate'],1)}} {{$Rating['average_rate']>1?"stars":"star"}}.</p>
                                </div>

                                <h1 class="story-info-title" style="margin-top: 25px;">
                                    THE STORYSTAR RATING SYSTEM
                                </h1>
                               
								<p> <strong>Rating System :</strong> (1 star is the lowest, 5 stars is the highest.)</p>
                                <p> <strong>1 star </strong>= I would not recommend this story to others.</p>
                                <p> <strong>2 stars </strong>= This story might be enjoyed by others with similar interests.</p>
                                <p> <strong>3 stars </strong>= A good story that I think most people would enjoy reading.</p>
                                <p> <strong>4 stars </strong>= A great story that I would highly recommend to friends and family.</p>
                                <p> <strong>5 stars </strong>= An exceptional story in every way. A MUST READ story. </p>
                                <hr/>
                                <p>The story rating scores given are based on the combined average total score of all
                                    ratings received for a given story. Ratings are provided for the benefit of readers
                                    who have limited time and wish to only read stories recommended by others.</p>
                                <p>Stories are rated by visitors to Storystar who have read the story and wish to give
                                    their opinion about it for the benefit of other readers.</p>
                                <p>Those who wish to rate a story they have read are asked to take the following
                                    criteria into consideration:</p>
                                <p>1. Is the story easy to read and understand?</p>
                                <p>2. Does it grab your attention and keep it?</p>
                                <p>3. Can you relate to the character's in the story?</p>
                                <p>4. Does it have broad appeal to a wide variety of different people, or limited appeal
                                    to only some readers who may have interest in the particular subject or theme?</p>
                                <p>5. How well written is the story? (Please give child writers more latitude than
                                    adults.)</p>
                                <p>6. How relevent, moving, profound, meaningful, interesting, exceptional and/or
                                    inspirational is it?</p>
                                <p>7. IF the story is FICTION (True Life stories should not be judged this way), then
                                    how original and/or creative is it?</p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @include("app.components.footer")

        </div>
    </div>

    <style>
        .author-top-content {
            padding-top: 2px;
        }
    </style>

@endsection

@push('meta-data')
<meta name="title" content="{{decodeStr($story->story_title)}} - a short story by {{decodeStr($story->author_name)}}"/>
<meta name="description"
      content="Written by {{decodeStr($story->author_name)}} of St Louis Mo, United States, short story '{{decodeStr($story->story_title)}}' is listed as {{decodeStr($story->category->category_title)}} under Short stories for {{decodeStr($story->subcategory->sub_category_title)}} in the theme of {{decodeStr($story->theme->theme_title)}} stories, with the chosen subject of {{decodeStr($story->subject->subject_title)}}."/>
<meta name="keywords"
      content="short story, short stories, read short stories online, {{decodeStr($story->category->category_title)}} story, {{decodeStr($story->theme->theme_title)}} story, {{decodeStr($story->story_title)}}, {{decodeStr($story->subject->subject_title)}}"/>
<meta name="distribution" content="{{decodeStr($story->story_title)}}"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/>
@endpush
