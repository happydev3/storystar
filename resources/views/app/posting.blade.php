@extends('app.layout.page')
@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <a name="profile"></a>
                        <h1 class="text-xs-center author-heading">
                            Story Posting Instructions
                        </h1>
                        <div class="author-profile-box">
                            <h1 class="story-info-title pt-2">INSTRUCTIONS FOR USING OUR STORY POSTING FORM</h1>
                            <p class="author-top-content">
                                It is best not to write your story off the top of your head. We suggest you write your story on your own word processor, run it through your spell checker, reread it over several times for errors, and rewrite it until you and your best critic think it is perfect. Then you can copy/paste it into our Storystar story writing text box. But please do not paste anything into our story posting form except for just plain text with no html code, bolding, underlining, pictures, etc....
                                <br><br>
                                Remember that once you submit your story to this website it becomes a permanent published record
                                of your writing skills at this moment in time. So please be sure you have given your story your best 
                                effort and that you are proud of it before you place it online for the world to read and judge.
                                <br><br>
                                Please note that we have a story size limit of 30,000 characters of text, or about 5,000 words. If you 
                                submit a story that is longer than that the end of your story will be cut off when you submit it.
                                <br><br>
                                You can find out whether your story fits into the form by pasting it in and then hitting the ENTER 
                                key on your keyboard. The Storystar character counter will then tell you how many characters of space 
                                you have left, if it is less than 30,000 characters long. OR, it will cut off the end of your story 
                                that exceeds the length limit and show 0 characters remaining on the counter. Each letter, and each 
                                space between words, counts as one character. A big space between paragraphs, or a full line of blank 
                                space, counts as two characters. Our story window accepts up to 74 characters per line, so your story 
                                can be a maximum of about 405 lines of text long.
                                <br><br>
                                Once you copy/paste your story into the text box please check to make sure it retained all the same 
                                spacing and punctuation you intended. If not, then adjust it accordingly before you submit it. The 
                                story will look exactly the same on the permanent web page as it does in the story writing box.
                                <br><br>
                                Please remember that R rated and racist stories and language are not accepted on Storystar. If you 
                                have used R rated language but your story is not R rated then you'll need to either replace the words 
                                or replace some of the letters with symbols.
                                <br><br>
                                If you have a story you want to publish that is too long you'll have to condense it and take out as 
                                many non-essential parts as possible. Remember that Storystar is for SHORT stories. Please check out 
                                our helpful tips on how to write a good short story.
                                <br><br>
                                Thanks for sharing your short stories with us!
                                <br><br>
                            </p>
                            {{--<a href=""><h1 class="text-center" style="font-size: 20px;">Back to story submission page</h1></a>--}}
                        </div>
                        <div class="clearfix"></div>


                    </div>
                </div>
            </div>
            @include("app.components.footer")
        </div>
    </div>
@endsection