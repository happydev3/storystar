@extends('app.layout.page')
@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <a name="profile"></a>
                        <h1 class="text-xs-center author-heading">
                            HOW TO WRITE A GOOD STORY 
                        </h1>
                        <div class="author-profile-box">
                            <h1 class="story-info-title pt-2"> 
                                HOW TO WRITE A GOOD STORY
                            </h1>
                            <p class="author-top-content">
                                Remember that Storystar is for short stories, whether from true life or works of fiction. Writing short stories is different than writing long stories and novels. The below tips for writing a good story are directed toward writing a good short story.
                            </p>
                            <h1 class="story-info-title">
                                Tips for writing a good short story
                            </h1>
                            <p class="author-top-content">To make your short stories more effective, try to keep in mind these pointers:</p>
                            <p class="author-top-content pt-0">
                                <b class="text-primary">Have a clear theme.</b> What is the story about? That doesn't mean what is the plot line, the sequence of events, or the character's actions; it means what is the underlying message or statement behind the words? Get this right and your story will have more resonance in the minds of your readers. <br><br>
                                <b class="text-primary">Focus.</b> The best stories are the ones that follow a narrow subject line or idea. What is the point of your story? Its point is its theme. It's tempting to digress, but in a 'short' story you have to follow the straight and narrow otherwise you will end up with either a novel beginning or a hodgepodge of ideas. Every detail you present should reinforce your theme. Everything you put in the story should be integral, nothing should be gratuitous. Remember John Steinbeck's advice to "Know your story in 10 words before you tell it in 1000." <br> <br>
                                <b class="text-primary">An effective short story covers a very short time span.</b> You can't fit in an entire life story, so focus on a point in time, an experience, an idea, or a lesson learned. It may be one single event that proves pivotal in the life of the character, and that event will illustrate the theme.<br><br>
                                <b class="text-primary">Don't have too many characters or events.</b> Each new character or event will bring a new dimension to the story, and for an effective short story too many diverse dimensions (or directions) will dilute the theme. Have only enough characters and/or events to effectively illustrate the theme or purpose of your story.<br><br>
                                <b class="text-primary">Make every word count.</b> There is no room for unnecessary expansion in a short story. If each word is not working towards putting across the theme or idea in the most effective way possible then delete it or replace it with a better word.<br><br>
                                <b class="text-primary">Make the ending interesting.</b> A twist, something to make you think, a final profound thought, or a resolution to make the reader feel satisfied.<br><br>
                                <b class="text-primary">Proof read!</b> Nothing can kill a potentially great story faster than bad grammar and spelling errors. Many readers will not bother to continue reading if in the first few sentences they encounter errors in your story. Careless errors, left for readers to stumble on, make a statement that you do not care enough about your story to proof read it. So then why should readers care enough to bother to read it?
                                <b class="text-primary">Rewrite.</b> Rewrite again. Great stories require hard work. Most great writers rewrite their stories over and over again, each time improving it until they can no longer find anything in their story that can be made better. Some writers can spend hours just working on one sentence. A great idea for a story may come off the top of your head onto the paper or the computer screen. But if you leave it that way, exactly as you first wrote it, chances are no one will be very impressed. Great stories, like great wine, need time. After you've first written your story, give it time. Come back to it later and reread it. See if there is something you can improve. Perhaps a sentence can be structured differently to become more clear. Perhaps a more descriptive word can be used here and there. Once you have improved everything you can think of in your story, give it even more time to settle in your mind. Then come back to it again, and rewrite it again, perfecting everything just a little more. If you do this with every story you write, you will have a good chance of creating a truly great story.<br><br>
                                <b class="text-primary">Write about what you know.</b> In general, if you want to write convincing stories, you should write about what you know deeply, from your own EXPERIENCE. If you want to write convincingly about what you haven't experienced, you should do intensive research and interviews, and/or possess a world class imagination.<br><br>
                                Use the above guidelines to create a "map" for your story, a general idea of where you want to go, but allow writing to be a process of discovery. The first sentence of the story is crucial, since it hooks the reader, and often sums up the theme. Write and rewrite your story until you are satisfied. Reading your story aloud is a great way to comb out awkward language.<br><br>
                                Burn this phrase into your brain and act on it: <b class="text-primary">Writers are readers!</b> Remember the advice of Shakespeare's contemporary Ben Johnson: "For a man to write well, there are required three necessities: to read the best authors, observe the best speakers, and much exercise of his own style."<br><br>
                                Good stories provide a way of bridging the silent gulf between people. They are a form of companionship and an expression of what is most essential and meaningful about human life. Express in your stories some of what you believe human life is all about, your viewpoint on the meaning of existence. If you write about what is meaningful to you, about your own experience, and about what you know and/or think about human life, then your story will surely resonate with readers, and perhaps even touch someone more deeply than you could have imagined.<br><br>
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