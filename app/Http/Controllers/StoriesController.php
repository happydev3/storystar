<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ContestEntries;
use App\Models\NominatedStory;
use App\Models\Rater;
use App\Models\Rating;
use App\Models\StoryView;
use App\Models\SubCategory;
use App\Models\PointsHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Admin;
use App\Models\Flag;
use App\Models\SiteUser;
use App\Models\StoryCategory;
use App\Models\FavoriteAuthor;
use App\Models\FavoriteStory;
use App\Models\Category;
use App\Models\Theme;
use App\Models\BlockedIpAddress;
use App\Models\StoryLikeRates;

use App\Jobs\SendFavoriteAuthorPublishStoryEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use JsValidator;
use Illuminate\Support\Facades\Validator;
use App\Notifications\StoryPublishedNotification;
use App\Notifications\NovelPublishedNotification;
use App\Notifications\StoryFlaggedNotification;
use App\Notifications\StoryRatingNotification;
use App\Notifications\StoryCommentedNotification;
use App\Notifications\StoryCommenterNotification;
use App\Notifications\StoryCommenterReplyNotification;
use App\Notifications\SuspiciousCommentNotification;
use App\Notifications\BlockedUserNotification;

use App\Events\UpdateStoryViewCall;
use DB;

class StoriesController extends Controller
{
    public $pageData = [];
    public $perPage = 15;
    protected $jsValidation = true;
    protected $publishValidationRules = [
        'story_title' => 'required|string|max:40',
        'short_description' => 'required|string|max:300',
        'subject_id' => 'required',
        'theme_id' => 'required',
        'category_id' => 'required',
        'written_by' => 'required',
        'sub_category_id' => 'required',
        'agreement' => 'required',
        'attest' => 'required',
        'the_story' => 'required|string|max:50000',
        'story_img' => 'mimes:jpeg,jpg,png,gif|max:5000',
    ];
    protected $publishValidationMessages = [
        'story_title.required' => 'Please add your story title.',
        'short_description.required' => 'Please add short description.',
        'theme_id.required' => 'Please choose your story theme.',
        'subject_id.required' => 'Please choose your story subject.',
        'category_id.required' => 'Please select your story category.',
        'written_by.required' => 'Please select your age group.',
        'sub_category_id.required' => 'Please select subcategory.',
        'agreement.required' => 'Please check on Agree to accept guidelines.',
        'attest.required' => 'Please check that this is your original story.',
        'the_story.required' => 'Please add your story',
        'the_story.max' => 'The story can not be greater than 50000 characters.',
        'story_img.mimes' => 'Your photo couldn\'t be uploaded. Photos should be of less than 5 Mb and saved as JPG, JPEG or PNG files',
        'story_img.max' => 'Your photos couldn\'t be uploaded. Photos should be smaller than 5 MB.',
    ];
    /*Validation rule for publish novel starts*/
    protected $publishNovelValidationRules = [
        'story_title' => 'required|string|max:40',
        'short_description' => 'required|string|max:500',
        'subject_id' => 'required',
        'theme_id' => 'required',
        'category_id' => 'required',
        'written_by' => 'required',
        'sub_category_id' => 'required',
        'agreement' => 'required',
        'attest' => 'required',
        'the_story' => 'required|string|max:500000',
        'story_img' => 'mimes:jpeg,jpg,png,gif|max:5000',
    ];
    protected $publishNovelValidationMessages = [
        'story_title.required' => 'Please add your novel title.',
        'short_description.required' => 'Please add short description.',
        'theme_id.required' => 'Please choose your novel theme.',
        'subject_id.required' => 'Please choose your novel subject.',
        'category_id.required' => 'Please select your novel category.',
        'written_by.required' => 'Please select your age group.',
        'sub_category_id.required' => 'Please select subcategory.',
        'agreement.required' => 'Please check on Agree to accept guidelines.',
        'attest.required' => 'Please check that this is your original novel.',
        'the_story.required' => 'Please add your novel',
        'the_story.max' => 'The novel can not be greater than 500000 characters.',
        'story_img.mimes' => 'Your photo couldn\'t be uploaded. Photos should be of less than 5 Mb and saved as JPG, JPEG or PNG files',
        'story_img.max' => 'Your photos couldn\'t be uploaded. Photos should be smaller than 5 MB.',
    ];
    /*Validation rule for publish novel ends*/
    protected $authorRules = [
        'name' => 'required|string|max:50',
        'gender' => 'required',
        // 'dob' => 'required',
        'address' => 'required',
        'country' => 'required'
    ];
    protected $authorMessages = [
        'name.required' => 'Please enter your name',
        'gender.required' => 'Please select your gender',
        // 'dob.required' => 'Please select your birth year',
        'address.required' => 'Please enter your city/state',
        'country.required' => 'Please select your country',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth')->except([
            'index',
            'stories',
            'story',
            'getMoreComments',
            'storyRatingDetail',
            'postComment',
            'AddThumbsupStories'
        ]);
        $this->pageData['s'] = isset($request->s) ? $request->s : '';
        $this->pageData['sd'] = isset($request->sd) ? $request->sd : '';
        $this->pageData['state'] = isset($request->state) ? $request->state : '';
        $this->pageData['author'] = isset($request->author) ? $request->author : '';
        $this->pageData['theme'] = isset($request->theme) ? $request->theme : '';
        $this->pageData['subject'] = isset($request->subject) ? $request->subject : '';
        $this->pageData['category'] = isset($request->category) ? $request->category : '';
        $this->pageData['subcategory'] = isset($request->subcategory) ? $request->subcategory : '';
        $this->pageData['sortby'] = isset($request->sortby) ? $request->sortby : 'desc';
        $this->pageData['user_id'] = isset($request->user_id) ? $request->user_id : '';
        $this->pageData['page'] = isset($request->page) ? $request->page : '';
        $this->pageData['country'] = isset($request->country) ? $request->country : '';
        $this->pageData['in_content'] = isset($request->in_content) ? $request->in_content : '';
        $this->pageData['queryString'] = Input::only([
            's',
            'sd',
            'theme',
            'subject',
            'category',
            'subcategory',
            'sortby',
            'country',
            'state',
            'author',
            'in_content'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.home')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function stories(Request $request)
    {
        /*if ($this->pageData['sortby'] == 'oldest')
            $this->pageData['sortby'] = 'asc';
        else
            $this->pageData['sortby'] = 'desc';*/

        $this->pageData['perPage'] = $this->perPage;
        $story = new Story();
        if (request()->segment(1) == 'read-short-stories') {
            $this->pageData['segment'] = 'read-short-stories';
        } elseif (request()->segment(1) == 'story-subject') {
            $this->pageData['segment'] = 'story-subject';
        } else {
            $this->pageData['segment'] = '';
        }
        $paginator = $story->getStories($this->pageData);

//        dd($paginator->links());


        //else:
        //$paginator = $story->where("subject_id","=","177")->getStories($this->pageData);
        //endif;
        // Set Title And Meta.

        $setData = [];
        if ($this->pageData) {
            foreach ($this->pageData as $k => $q) {
                if (in_array($k, ['s', 'state', 'author', 'theme', 'subject', 'category', 'subcategory', 'country'])) {
                    if (isset($q) && !empty($q)) {
                        $setData[] = $k;
                    }
                }
            }
        }

        if (count($setData) == 1 && $setData[0] == 'theme') {
            $this->pageData['Theme'] = Theme::find($this->pageData['theme']);
            $this->pageData['PageTitle'] = config('app.name') . '.com - ' . $this->pageData['Theme']->page_title;
            $this->pageData['MetaDescription'] = isset($this->pageData['Theme']->meta_description) ? $this->pageData['Theme']->meta_description : '';
            $this->pageData['MetaKeywords'] = isset($this->pageData['Theme']->meta_keywords) ? $this->pageData['Theme']->meta_keywords : '';
        } elseif (count($setData) == 1 && $setData[0] == 'subcategory') {
            $this->pageData['SubCategory'] = SubCategory::find($this->pageData['subcategory']);
            $this->pageData['PageTitle'] = config('app.name') . '.com - ' . $this->pageData['SubCategory']->page_title;
            $this->pageData['MetaDescription'] = isset($this->pageData['SubCategory']->meta_description) ? $this->pageData['SubCategory']->meta_description : '';
            $this->pageData['MetaKeywords'] = isset($this->pageData['SubCategory']->meta_keywords) ? $this->pageData['SubCategory']->meta_keywords : '';
        } elseif (count($setData) == 1 && $setData[0] == 'category') {
            $this->pageData['Category'] = Category::find($this->pageData['category']);
            $this->pageData['PageTitle'] = config('app.name') . '.com - ' . $this->pageData['Category']->page_title;
            $this->pageData['MetaDescription'] = isset($this->pageData['Category']->meta_description) ? $this->pageData['Category']->meta_description : '';
            $this->pageData['MetaKeywords'] = isset($this->pageData['Category']->meta_keywords) ? $this->pageData['Category']->meta_keywords : '';
        } else {
            $this->pageData['PageTitle'] = config('app.name') . '.com - Read Short Stories - Read the best short stories online by short story writers of all ages from around the world.';
            $this->pageData['MetaDescription'] = 'Read Short Stories - Read the best short stories online by short story writers of all ages from around the world.';

            $this->pageData['MetaKeywords'] = "
                read short story,read short stories,short stories for kids,
                good short stories, nonfiction stories,publish short stories online,short story competition,
                short story submissions, read,short story contests,short story,love story,funny short stories,
                short scary stories,love stories, short stories,read short stories online,short fiction,fiction stories,
                short fiction stories,new writing,stories,fiction,new short stories,original short stories,
                short stories online,literature,original writing, romance stories,crime stories,sci-fi stories,
                science fiction stories,humorous stories,horror stories, children's stories,
                fantasy stories,new fiction,short stories for teens,short story for adults, short stories for children,
                short stories to read, fictional short stories,short love stories,short story writers,
                teenage short stories, inspiring short stories,science 
                fiction short stories,romance short stories,short mystery stories,read a story.
            ";
        }

        return view('app.stories')->with(['pageData' => $this->pageData])->with(compact('paginator'));
    }

    public function story(Request $request, $story_id, $user_name, $category, $theme, $anonymous = null)
    {
        /* Update the view in database for this story*/
//        UpdateStoryViewCall::dispatch($request);
//
//      
        $user = Story::find($story_id);
        $story_test = Story::find($story_id);
        
        $count = StoryLikeRates::where('story_id', $story_id)->count();
        
        $like = StoryLikeRates::where('story_id', $story_id)->where('ip_address', $request->ip())->count();
        

        if (empty($story_test)) {
            return redirect()->route('app-stories');
        }
        
        if($story_test->subject_id == 177 && !\Auth::user()){
            $request->session()->put('url.intended', url()->full());
            return redirect()->route('login');
        }

        $story_view = new StoryView;

        $story_view->story_id = $request->story_id;
        $story_view->ip = $request->ip();
        $story_view->save();


        $story_test->views = $story_test->views + 1;
        $story_test->save();

        $story = $favAdded = $comments = $nominateAdded  = "";

        if ($story_id) {
            $story = Story::select('stories.*')->with("favstories")
                // users join
                ->leftJoin('users', function ($join) {
                    $join->on('users.user_id', '=', 'stories.user_id')
                        ->whereNull('users.deleted_at')
                        ->where('users.active', "=", 1);
                })
                ->where("status", "=", "Active")
                ->find($story_id);

            //dd($story);
            /* If user is deleted from admin.
               or story id is invalid*/

            if (!$story) {
                return abort(404);
            }

            if (isset($story->self_story) && $story->self_story == 1) {
                if (empty($story->user) || !isset($story->user)) {
                    return abort(404);
                }
            }

            $favAdded = 0;
            $nominateAdded = 0;
            


//            dd(Auth::user()->favorite_stories()->where('stories.story_id','=',$story_id)->count());


            if (\Auth::user() && $story->user_id != \Auth::user()->user_id) {
                $favAdded = (Auth::user()->favorite_stories()->where('stories.story_id', '=', $story_id)->count());

                $nominateAdded = ($story->nominatedstories->where('user_id', '=', \Auth::user()->user_id)->where('story_id', '=',
                    $story_id)->count());

                $nominateAdded = isset($nominateAdded) ? $nominateAdded : 0;
            }
            
        }

        $comments = Comment::with('children')->with('user')
            ->where('story_id', '=', $story->story_id)
            ->whereNull('parent_comment_id')
            ->orderBy('comment_id', 'desc')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->paginate($this->perPage);

        $this->pageData['PageTitle'] = decodeStr($story->story_title);
        if ($story->author_name) {
            $this->pageData['PageTitle'] .= ' - A short story by ' . $story->author_name;
        }

        $favAddedAuthor = 0;
        if (\Auth::user() && $story->user_id != \Auth::user()->user_id) {
            if (isset($story->user_id) && !empty($story->user_id)) {
                $author = [];
                $author = SiteUser::with('favoriteauthors')->find($story->user_id);

                if (!$author->favoriteauthors) {
                    $favAddedAuthor = 0;
                } else {
                    $favAddedAuthor = $author->favoriteauthors->where(
                        'user_id',
                        '=',
                        \Auth::user()->user_id
                    )->where('author_id', '=', $author->user_id)->count();
                }
            }
        }

        return view('app.story')
            ->with(['pageData' => $this->pageData])
            ->with(compact('story'))
            ->with(compact('favAdded'))
            ->with(compact('nominateAdded'))
            ->with(compact('favAddedAuthor'))
            ->with(compact('comments'))
            ->with(compact('anonymous'))
            ->with(compact('count'))
            ->with(compact('like'));
            
    }

    public function storyRatingDetail(Request $request, $story_id = '')
    {
        $story = '';

        if ($story_id) {
            $story = Story::with('favstories')
                ->with('user')
                ->where('status', '=', 'Active')
                ->find($story_id);

            $Rating = Rating::where('story_id', '=', $story_id)->get()->toArray();
            $Rating = isset($Rating[0]) ? $Rating[0] : 0;

            /* If user is deleted from admin.
               or story id is invalid*/
            // || (!($story->user) && $story->self_story == 0)

            if (!$story) {
                return abort(404);
            }

            $this->pageData['PageTitle'] = decodeStr($story->story_title);

            if ($story->author_name) {
                $this->pageData['PageTitle'] .= ' - Story Rating';
            }
        }

        return view('app.storyrating')
            ->with(['pageData' => $this->pageData])
            ->with(compact('story'))
            ->with(compact('Rating'));
    }

    public function publishStory(Request $request)
    {
        $this->pageData['PageTitle'] = config('app.name') . ".com - Free online publication of short stories. Publish your short story now.";
        $user = \Auth::user();
        $isAuthor = isset($user->is_author) && !empty($user->is_author) ? 1 : 0;
        if (!$isAuthor) {
            $this->publishValidationRules = array_merge($this->publishValidationRules, $this->authorRules);
            $this->publishValidationMessages = array_merge($this->publishValidationMessages, $this->authorMessages);
        }

        // Js form validation
        $validator = JsValidator::make($this->publishValidationRules, $this->publishValidationMessages);

        $story = '';

        if (isset($request->story_id) && !empty($request->story_id)) {
            $this->pageData['PageTitle'] = 'Edit Story';
            $request->story_id = explode("__", base64_decode($request->story_id))[0];
            $story = Story::find($request->story_id);

            if ($story->user_id != $user->user_id) {
                return abort(404);
            }

            if (isset($story->is_rated) && !empty($story->is_rated)) {
                $request->session()->flash('alert-danger', 'The story is already rated you can not update now.');
            }

            if (!$story->story_id) {
                return abort(404);
            }
        }

        return view('app.publish')
            ->with(['pageData' => $this->pageData])
            ->with(compact('validator'))
            ->with(compact('story'))
            ->with(['jsValidation' => $this->jsValidation]);
    }

    public function publishStoryAction(Request $request)
    {
        $updateCheck = false;
        $user = \Auth::user();
        $isAuthor = isset($user->is_author) && !empty($user->is_author) ? 1 : 0;
        if (!$isAuthor) {
            $this->publishValidationRules = array_merge($this->publishValidationRules, $this->authorRules);
            $this->publishValidationMessages = array_merge($this->publishValidationMessages, $this->authorMessages);
        }

        // Validation Code
        $validation = Validator::make($request->all(), $this->publishValidationRules);

        if ($validation->fails()) {
            $request->session()->flash(
                'alert-danger',
                'There is some issue in submitting your story. Please go through your story again.'
            );
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        // Check Before insert for update,identifier and type,
        $storyResult = [];
        $storyResult = Story::firstOrNew([
            'story_id' => isset($request->story_id) && !empty($request->story_id) ? $request->story_id : '',
        ]);

        if (isset($storyResult['is_rated']) && !empty($storyResult['is_rated'])) {
            $request->session()->flash('alert-danger', 'The story is already rated you can not update now.');
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        if (isset($storyResult->user_id) && $storyResult->user_id != $user->user_id) {
            $request->session()->flash('alert-danger', 'You could not update this story.');
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        if (isset($storyResult['story_id']) && !empty($storyResult['story_id'])) {
            $updateCheck = true;
            // Add updated_timestamp on update record case
            $storyResult->updated_timestamp = time();
            $storyResult->views = 0;
        } else {
            $storyResult->created_timestamp = time();
            $storyResult->updated_timestamp = time();
        }

        $storyResult->story_title = strip_tags($request['story_title']);
        $storyResult->short_description = strip_tags($request['short_description']);
        $storyResult->subject_id = $request['subject_id'];
        $storyResult->theme_id = $request['theme_id'];
        $storyResult->written_by = $request['written_by'];
        $storyResult->category_id = $request['category_id'];
        $storyResult->sub_category_id = $request['sub_category_id'];
        $storyResult->the_story = strip_tags($request['the_story']);
        $storyResult->author_name = isset(\Auth::user()->name) ? \Auth::user()->name : $request->name;
        $storyResult->author_country = isset(\Auth::user()->country) ? \Auth::user()->country : $request->country;
        $storyResult->author_gender = isset(\Auth::user()->gender) ? \Auth::user()->gender : $request->gender;
        $storyResult->author_dob = isset(\Auth::user()->dob) ? \Auth::user()->dob : $request->dob;
        $storyResult->author_address = isset(\Auth::user()->address) ? \Auth::user()->address : $request->address;
        $storyResult->self_story = 1;
        $storyResult->user_id = \Auth::user()->user_id;
        $storyResult->status = 'Active';
        $storyResult->poster_ip = $request->ip();
        $storyResult->story_code = '';

        // File upload here
        $fileName = isset($storyResult->story_img) ? $storyResult->story_img : '';
        $file = $request->file('story_img');
        if ($file) {
            //Move Uploaded File
            $fileName = NewGuid() . "_" . time() . "." . $file->guessExtension();
            $destinationPath = 'storage/story/';
            $file->move($destinationPath, $fileName);
            $storyResult->image = $fileName;
        }

        try {
            $data = $storyResult->save();
            // Getting The Categories Added by Admin with story
            // Update story_categories table
            $StoryCategory = new StoryCategory();
            $results = $StoryCategory->updateMultipleCategories($request, $storyResult->story_id, 'ClientSide');

            //@,IYDcLc,N%(

            // Update User Info
            if (isset($request->authorInfo) && !empty($request->authorInfo)) {
                $user_id = \Auth::User()->user_id;
                $obj_user = SiteUser::find($user_id);
                $obj_user->name = $request->name;
                $obj_user->gender = $request->gender;
                $obj_user->dob = $request->dob;
                $obj_user->address = $request->address;
                $obj_user->country = $request->country;
                $obj_user->is_author = 1;
                // $obj_user->is_profile_complete = 0;
                $obj_user->save();
            }

            //   $updateCheck == false means new story is being posted.
            if ($updateCheck == false) {
                $story = Story::find($storyResult->story_id);
                $user_id = \Auth::User()->user_id;

                // Update Story Count in users table
                Story::updateStoryCount($user_id);

                // Send Email to who add logged in user in  Fav Authors List
                $lists = FavoriteAuthor::where('author_id', "=", \Auth::user()->user_id)
                    ->pluck('user_id')->toArray();
                if ($lists) {
                    $job = (new SendFavoriteAuthorPublishStoryEmail($lists, $story));
                    $this->dispatch($job);
                }

                // Send Email to admin
                \Notification::send(Admin::all(), new StoryPublishedNotification($story, $request));
            }

            if ($data) {
                if ($request->story_id) {
                    $request->session()->flash(
                        'alert-success',
                        "Thank you, you have successfully edited your story. 
                        Please note that the 'edit' option will disappear as soon as your story
                        receives its first rating. After that, if there are more changes you 
                        would like to make, please contact Storystar admin at: 
                        <a href='mailto:admin@storystar.com'>admin@storystar.com</a>. Thank you."
                    );
                } else {
                    $novel = false;
                    return view('app.publish_success', compact('novel'));
                }
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    /*=======Publish Novel section starts==========*/
    public function publishNovel(Request $request)
    {
        $this->pageData['PageTitle'] = config('app.name') . ".com - Free online publication of novels. Publish your novel now.";

        $user = \Auth::user();
        $isAuthor = isset($user->is_author) && !empty($user->is_author) ? 1 : 0;
        if (!$isAuthor) {
            $this->publishNovelValidationRules = array_merge($this->publishNovelValidationRules, $this->authorRules);
            $this->publishNovelValidationMessages = array_merge(
                $this->publishNovelValidationMessages,
                $this->authorMessages
            );
        }

        // Js form validation
        $validator = JsValidator::make($this->publishNovelValidationRules, $this->publishNovelValidationMessages);

        $novel = '';
        if (isset($request->story_id) && !empty($request->story_id)) {
            $this->pageData['PageTitle'] = 'Edit Novel';
            $request->story_id = explode("__", base64_decode($request->story_id))[0];
            $novel = Story::find($request->story_id);

            if ($novel->user_id != $user->user_id) {
                return abort(404);
            }

            if (isset($novel->is_rated) && !empty($novel->is_rated)) {
                $request->session()->flash('alert-danger', 'The novel is already rated you can not update now.');
            }

            if (!$novel->story_id) {
                return abort(404);
            }
        }

        return view('app.publishnovel')
            ->with(['pageData' => $this->pageData])
            ->with(compact('validator'))
            ->with(compact('novel'))
            ->with(['jsValidation' => $this->jsValidation]);
    }

    public function publishNovelAction(Request $request)
    {
        $updateCheck = false;
        $user = \Auth::user();
        $isAuthor = isset($user->is_author) && !empty($user->is_author) ? 1 : 0;
        if (!$isAuthor) {
            $this->publishNovelValidationRules = array_merge($this->publishNovelValidationRules, $this->authorRules);
            $this->publishNovelValidationMessages = array_merge(
                $this->publishNovelValidationMessages,
                $this->authorMessages
            );
        }

        // Validation Code
        $validation = Validator::make($request->all(), $this->publishNovelValidationRules);
        if ($validation->fails()) {
            $request->session()->flash(
                'alert-danger',
                'There is some issue in submitting your novel. Please go through your novel again.'
            );
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        // Check Before insert for update,identifier and type,
        $storyResult = [];
        $storyResult = Story::firstOrNew([
            'story_id' => isset($request->story_id) && !empty($request->story_id) ? $request->story_id : '',
        ]);

        if (isset($storyResult['is_rated']) && !empty($storyResult['is_rated'])) {
            $request->session()->flash('alert-danger', 'The novel is already rated you can not update now.');
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        if (isset($storyResult->user_id) && $storyResult->user_id != $user->user_id) {
            $request->session()->flash('alert-danger', 'You could not update this novel.');
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }

        if (isset($storyResult['story_id']) && !empty($storyResult['story_id'])) {
            $updateCheck = true;
            // Add updated_timestamp on update record case
            $storyResult->updated_timestamp = time();
            $storyResult->views = 0;
        } else {
            $storyResult->created_timestamp = time();
            $storyResult->updated_timestamp = time();
        }

        $storyResult->story_title = strip_tags($request['story_title']);
        $storyResult->short_description = strip_tags($request['short_description']);
        $storyResult->subject_id = $request['subject_id'];
        $storyResult->theme_id = $request['theme_id'];
        $storyResult->written_by = $request['written_by'];
        $storyResult->category_id = $request['category_id'];
        $storyResult->sub_category_id = $request['sub_category_id'];
        $storyResult->the_story = strip_tags($request['the_story']);
        $storyResult->author_name = isset(\Auth::user()->name) ? \Auth::user()->name : $request->name;
        $storyResult->author_country = isset(\Auth::user()->country) ? \Auth::user()->country : $request->country;
        $storyResult->author_gender = isset(\Auth::user()->gender) ? \Auth::user()->gender : $request->gender;
        $storyResult->author_dob = isset(\Auth::user()->dob) ? \Auth::user()->dob : $request->dob;
        $storyResult->author_address = isset(\Auth::user()->address) ? \Auth::user()->address : $request->address;
        $storyResult->self_story = 1;
        $storyResult->user_id = \Auth::user()->user_id;
        $storyResult->status = 'Active';
        $storyResult->poster_ip = $request->ip();
        $storyResult->story_code = '';

        // File upload here
        $fileName = isset($storyResult->story_img) ? $storyResult->story_img : '';
        $file = $request->file('story_img');
        if ($file) {
            //Move Uploaded File
            $fileName = NewGuid() . "_" . time() . "." . $file->guessExtension();
            $destinationPath = 'storage/story/';
            $file->move($destinationPath, $fileName);
            $storyResult->image = $fileName;
        }

        try {
            $data = $storyResult->save();

            // Getting The Categories Added by Admin with story
            // Update story_categories table
            $StoryCategory = new StoryCategory();
            $results = $StoryCategory->updateMultipleCategories($request, $storyResult->story_id, 'ClientSide');

            // Update User Info
            if (isset($request->authorInfo) && !empty($request->authorInfo)) {
                $user_id = \Auth::User()->user_id;
                $obj_user = SiteUser::find($user_id);
                $obj_user->name = $request->name;
                $obj_user->gender = $request->gender;
                $obj_user->dob = $request->dob;
                $obj_user->address = $request->address;
                $obj_user->country = $request->country;
                $obj_user->is_author = 1;
                // $obj_user->is_profile_complete = 0;
                $obj_user->save();
            }

            //   $updateCheck == false means new story is being posted.
            if ($updateCheck == false) {
                $story = Story::find($storyResult->story_id);
                $user_id = \Auth::User()->user_id;

                // Update Story Count in users table
                Story::updateStoryCount($user_id);

                // Send Email to who add logged in user in  Fav Authors List
                /* $lists = FavoriteAuthor::where('author_id', "=", \Auth::user()->user_id)
                     ->pluck('user_id')->toArray();
                 if ($lists) {
                     $job = (new SendFavoriteAuthorPublishStoryEmail($lists, $story));
                     $this->dispatch($job);
                 }*/

                // Send Email to admin

                Notification::send(Admin::all(), new NovelPublishedNotification($story, $request));
            }

            if ($data) {
                if ($request->story_id) {
                    $request->session()->flash(
                        'alert-success',
                        "Thank you, you have successfully edited your novel. 
                        Please note that the 'edit' option will disappear as soon as your 
                        novel receives its first rating. After that, if there are more 
                        changes you would like to make, please contact Storystar admin at: 
                        <a href='mailto:admin@storystar.com'>admin@storystar.com</a>. Thank you."
                    );
                } else {
                    $novel = true;
                    return view('app.publish_success', compact('novel'));
                }
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();
    }

    /*=======Publish Novel section ends============*/
    public function nominateStory(Request $request)
    {
        // Validation Code
        $validation = Validator::make(
            $request->all(),
            ['story' => 'required|numeric'],
            [
                'story.required' => 'Please select author and story',
                'story.numeric' => 'Please select author and story'
            ]
        );

        if ($validation->fails()) {
            $request->session()->flash(
                'alert-danger',
                'Please select story.'
            );
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }
        if (\Auth::user()->points < 100) {
            $request->session()->flash(
                'alert-danger',
                'You need to have at least 100 points to nominate.'
            );
            return redirect()->back();
        } else {
            ContestEntries::enter($request);
            $request->session()->flash('alert-success', 'Story nominated successfully!');
            return redirect()->back();
        }
    }

    public function rateStory(Request $request)
    {
        $points = PointsHistory::rateStory($request->all());

        if (request()->ajax()) {
            $validationRules = [
                'rate' => 'required',
                'story' => 'required'
            ];

            $validation = Validator::make($request->all(), $validationRules);

            if ($validation->fails()) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_error',
                    'message' => $validation->errors(),
                    'points' => $points ? 'success' : '',
                ]);
            }

            try {
                $user = Rater::firstOrNew(array('user_id' => \Auth::user()->user_id, 'story_id' => $request->story_id));
                $user->story_id = $request->story;
                $user->user_id = \Auth::user()->user_id;
                $user->rate = $request->rate;

                if ($user->save()) {
                    $storyRating = Rating::firstOrNew(array('story_id' => $request->story));
                    $storyRating->story_id = $request->story;

                    if ($request->rate == 1) {
                        $storyRating->r1 = $storyRating->r1 + 1;
                    }
                    if ($request->rate == 2) {
                        $storyRating->r2 = $storyRating->r2 + 1;
                    }
                    if ($request->rate == 3) {
                        $storyRating->r3 = $storyRating->r3 + 1;
                    }
                    if ($request->rate == 4) {
                        $storyRating->r4 = $storyRating->r4 + 1;
                    }
                    if ($request->rate == 5) {
                        $storyRating->r5 = $storyRating->r5 + 1;
                    }

                    $storyRating->average_rate = $storyRating->average_rate =
                        (
                            (
                                ($storyRating->r1 * 1)
                                + ($storyRating->r2 * 2)
                                + ($storyRating->r3 * 3)
                                + ($storyRating->r4 * 4)
                                + ($storyRating->r5 * 5)
                            ) / ($storyRating->r1
                                + $storyRating->r2
                                + $storyRating->r3
                                + $storyRating->r4
                                + $storyRating->r5)
                        );

                    $storyRating->total_rate =
                        $storyRating->r1
                        + $storyRating->r2
                        + $storyRating->r3
                        + $storyRating->r4
                        + $storyRating->r5;

                    if ($storyRating->save()) {
                        $story = Story::find($request->story);
                        $story->is_rated = 1;
                        $story->save();

                        if ($request->rate == 1) {
                            // Send Email to admin on rating = 1
                            $story = Story::find($request->story);
                            \Notification::send(Admin::all(), new StoryRatingNotification($story, $request));
                        }
                        return response()->json(['code' => 200, 'success' => 'rated_successfully'], 200);
                    }
                } else {
                    return response()->json(['code' => 201, 'error' => '', 'message' => '']);
                }
            } catch (\Exception $e) {
                return response()->json(['code' => 201, 'error' => '', 'message' => $e->getMessage()]);
            }
        }
    }

    public function postCommentReply(Request $request)
    {
        if (request()->ajax()) {
            $validationRules = ['comment' => 'required|string'];
            $validation = Validator::make($request->all(), $validationRules);
            if ($validation->fails()) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_error',
                    'message' => $validation->errors()
                ]);
            }

            try {
                $fetch_same_comment = Comment::where('comment','LIKE',$request['comment'])->where('user_id',\Auth::user()->user_id)->count();
                if($fetch_same_comment <= 2 || \Auth::user()->is_author){
                    $data = Comment::create([
                        'user_id' => \Auth::user()->user_id,
                        'parent_comment_id' => $request->comment_id,
                        'story_id' => $request->story_id,
                        'comment' => $request['comment'],
                    ]);


                    $points = PointsHistory::postCommentReplyOnStory($request->all(), $data->comment_id, $request->story_id, $data->user_id);

                    if ($data->comment_id) {
                        $sub_comment = Comment::find($data->comment_id);

                        if ($request->story_id) {
                            $story = Story::find($request->story_id);

                            // Update Comment Count In Cache Field of Story Table.
                            $count = Comment::where('story_id', "=", "$story->story_id")->count();
                            $story->comment_count = $count;
                            $story->save();

    //                        $notified_commenter = Comment::select(['users.name', 'users.email'])
    //                            ->join("users", "users.user_id", "=", "comments.user_id")
    //                            ->where("comments.story_id", "=", "$request->story_id")
    //                            ->where("comments.user_id", "!=", \Auth::user()->user_id)
    //                            // ->where("comments.parent_comment_id", "=", $request->comment_id)
    //                            ->groupBy('users.email')
    //                            ->get();
    //
    //                        dd($notified_commenter);

                            $required_comments = Comment::where('parent_comment_id', $request->comment_id)->where('user_id','!=',\Auth::user()->user_id)->where('user_id','!=',$sub_comment->user_id)->with('user')->get()->pluck('user')->unique();

    //                        dd($required_comments);

    //                        $requ= Comment::where('parent_comment_id', $request->comment_id)->with('user')->get();



                            $storyRecord = $story->toArray();

                            //dd($notified_commenter->toArray());

                            \Notification::send(
                                $required_comments,
                                new StoryCommenterReplyNotification($sub_comment, $request, $storyRecord)
                            );

                            $main_user = Comment::where('comment_id','=',$request->comment_id)->where('user_id','!=',$sub_comment->user_id)->with('user')->get()->pluck('user');

                            \Notification::send(
                                $main_user,
                                new StoryCommenterReplyNotification($sub_comment, $request, $storyRecord)
                            );

                        }

                        $returnHTML = view('app.components.subcomment')
                            ->with(["sub_comment" => $sub_comment])
                            ->render();

                        return response()->json([
                            'code' => 200,
                            'success' => 'commented_successfully',
                            'html' => $returnHTML
                        ], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => 'commented_successfully', 'message' => '']);
                    }
                }
                else {
                    \Log::error('Suspicious Comments');
                    \Notification::send(
                        Admin::all(),
                        new SuspiciousCommentNotification()
                    );
                    $user = \Auth::user();
                    $user->is_blocked = 1;
                    $user->save();
                    if($user->last_login_ip != NULL){
                        BlockedIpAddress::create(['ip_address' => $user->last_login_ip]);
                    }
                    \Auth::logout();
                    \Notification::send($user, new BlockedUserNotification($user));
                    return response()->json(['code' => 201, 'error' => 'commented_error', 'message' => 'Suspicious activity has been detected !']);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_successfully',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function postComment(Request $request)
    {
        if (request()->ajax()) {
            $validationRules = ['comment' => 'required|string'];
            $validation = Validator::make($request->all(), $validationRules);
            if ($validation->fails()) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_error',
                    'message' => $validation->errors()
                ]);
            }

            if (\Auth::check()) {
                $userLoginId = \Auth::id();
            } else {
                if ($request->anonymous == 'anonymous') {
                    $userLoginId = null;
                } else {
                    return response()->json([
                        'code' => 201,
                        'error' => 'commented_error',
                        'message' => 'Login Error!'
                    ]);
                }
            }

            try {
                $fetch_same_comment = Comment::where('comment','LIKE',$request['comment'])->where('user_id',$userLoginId)->count();
                if($fetch_same_comment <= 2 || \Auth::user()->is_author){
                    $data = Comment::create([
                        'user_id' => $userLoginId,
                        'parent_comment_id' => null,
                        'story_id' => $request->story_id,
                        'comment' => $request['comment'],
                    ]);

                    //Adding in points
                    $points = PointsHistory::postCommentOnStory($request->all(), $data->comment_id, $request->story_id);

                    if ($data->comment_id) {
                        if ($request->story_id) {
                            $story = Story::find($request->story_id);
                        }

                        $commentsCount = Comment::where(
                            "story_id",
                            "=",
                            "$request->story_id"
                        )->whereNull("parent_comment_id")->count();
                        $comment = Comment::find($data->comment_id);

                        // Update Comment Count In Cache Field of Story Table.
                        $count = Comment::where('story_id', "=", "$story->story_id")->count();
                        $story->comment_count = $count;
                        $story->save();

                        /**
                         * Send Notification to Author on new posted a new comment.
                         */
                        $storyRecord = Story::find($request->story_id)->toArray();

                        if (\Auth::check() && $storyRecord && $storyRecord['self_story'] == 1) {
                            $userRecord = SiteUser::find($storyRecord['user_id']);

                            if (Auth::user()->user_id != $storyRecord['user_id']) {
                                $notified_user = (new SiteUser)->forceFill([
                                    'name' => $storyRecord['author_name'],
                                    'email' => $userRecord->email
                                ]);
                                \Notification::send(
                                    $notified_user,
                                    new StoryCommentedNotification($comment, $request, $storyRecord)
                                );
                            }
                        }

                        $returnHTML = view('app.components.comment')
                            ->with(["comment" => $comment])
                            ->with(compact('story'))
                            ->render();

                        return response()->json([
                            'code' => 200,
                            'success' => 'commented_successfully',
                            'html' => $returnHTML,
                            'count' => $commentsCount,
                            'points' => $points ? 'success' : ''
                        ], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => 'commented_error', 'message' => '']);
                    }
                }
                else {
                    \Log::error('Suspicious Comments');
                    \Notification::send(
                        Admin::all(),
                        new SuspiciousCommentNotification()
                    );
                    $user = \Auth::user();
                    $user->is_blocked = 1;
                    $user->save();
                    if($user->last_login_ip != NULL){
                        BlockedIpAddress::create(['ip_address' => $user->last_login_ip]);
                    }
                    \Auth::logout();
                    \Notification::send($user, new BlockedUserNotification($user));
                    return response()->json(['code' => 201, 'error' => 'commented_error', 'message' => 'Suspicious activity has been detected !']);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_successfully',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }


    public function FlagStory(Request $request)
    {
        if (request()->ajax()) {
            $validationRules = ['flag_for' => 'required'];
            $validation = Validator::make($request->all(), $validationRules);
            if ($validation->fails()) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_error',
                    'message' => $validation->errors()
                ]);
            }

            try {
                $user = Flag::firstOrNew(array('user_id' => \Auth::user()->user_id, 'story_id' => $request->story_id));
                $user->story_id = $request->story_id;
                $user->user_id = \Auth::user()->user_id;
                $user->message = $request->flag_for;

                if ($user->save()) {
                    $updateRecord = Story::find($user->story_id);
                    $updateRecord->status = 'Inactive';
                    $updateRecord->updated_timestamp = time();
                    $updateRecord->save();

                    // Send Email to admin on flagged story
                    $story = Story::find($request->story_id);
                    \Notification::send(Admin::all(), new StoryFlaggedNotification($story, $request));

                    $request->session()->flash(
                        'alert-success',
                        'Thank you for reporting. Our administrator will review it.'
                    );

                    return response()->json([
                        'code' => 200,
                        'success' => 'flagged_successfully',
                        'message' => 'Thank you for reporting. Our administrator will review it.'
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['code' => 201, 'error' => '', 'message' => $e->getMessage()]);
            }


            /*try {
                echo $request['flag-for'];
                exit;
                $data = Flag::create([
                    'user_id' => \Auth::user()->user_id,
                    'parent_comment_id' => null,
                    'story_id' => $request->story_id,
                    'comment' => $request['flag-for'],
                ]);
                if ($data->comment_id) {
                    if ($request->story_id) {
                        $story = Story::find($request->story_id);
                    }
                    $commentsCount = Comment::where("story_id", "=", "$request->story_id")
                    ->whereNull("parent_comment_id")->count();
                    $comment = Comment::find($data->comment_id);
                    $returnHTML = view('app.components.comment')
                        ->with(["comment" => $comment])
                        ->with(compact('story'))
                        ->render();
                    return response()->json(['code' => 200, 'success' => 'commented_successfully', 'html' => $returnHTML, 'count' => $commentsCount], 200);
                } else {
                    return response()->json(['code' => 201, 'error' => 'commented_successfully', 'message' => '']);
                }
            } catch (\Exception $e) {
                return response()->json(['code' => 201, 'error' => 'commented_successfully', 'message' => $e->getMessage()]);
            }*/
        }
    }

    public function getMoreComments(Request $request)
    {
        $id = $request->id;
        $story_id = $request->story_id;
        $parent_id = $request->parent_id;

        if ($story_id) {
            $story = Story::find($story_id);
        }

        $replies = Comment::
        where('comment_id', '<', $id)
            ->where('story_id', '=', $story_id)
            ->where('parent_comment_id', '=', $parent_id)
            ->orderBy('comment_id', 'DESC')
            ->limit(4)
            ->get();
            
        $last_comment = $replies->last();
        
        $subCommentsCount = Comment::where('comment_id','<',$last_comment->comment_id)
            ->where('story_id', '=', $story_id)
            ->where('parent_comment_id', '=', $parent_id)
            ->orderBy('comment_id', 'DESC')
            ->count();

        if (!$replies->isEmpty()) {
            $returnHTML = view('app.components.sub-comments')
                ->with(compact('replies'))
                ->with(compact('story'))
                ->with(["subCommentsCount" => $subCommentsCount])
                ->with(["parentComment" => $parent_id])
                ->render();

            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else {
            return response()->json(array('success' => true, 'html' => ''));
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function favoriteStories(Request $request)
    {
        $this->pageData['favoriteStories'] = true;
        $this->pageData['userID'] = \Auth::User()->user_id;
        $this->pageData['perPage'] = $this->perPage;

        $stories = Auth::user()->favorite_stories();

        if ($this->pageData['sortby'] == "rank_asc") {
            $stories->leftJoin('story_ratings', function ($join) {
                $join->on('story_ratings.story_id', '=', 'stories.story_id');
            })->orderBy("story_ratings.average_rate", "asc");
        } elseif ($this->pageData['sortby'] == "rank_desc") {
            $stories->leftJoin('story_ratings', function ($join) {
                $join->on('story_ratings.story_id', '=', 'stories.story_id');
            })->orderBy("story_ratings.average_rate", "desc");
        } elseif ($this->pageData['sortby'] == "views_asc") {
            $stories->orderBy("stories.views", "asc");
        } elseif ($this->pageData['sortby'] == "views_desc") {
            $stories->orderBy("stories.views", "desc");
        } elseif ($this->pageData['sortby'] == "oldest") {
            $stories->orderBy("stories.story_id", "asc");
        } else {
            $stories->orderBy("stories.story_id", "desc");
        }

        $paginator = $stories->paginate(15);

        $this->pageData['PageTitle'] = config('app.name') . ".com - Favorite Stories";
        return view('app.favoritestories')->with(['pageData' => $this->pageData])->with(compact('paginator'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function favoriteAuthors(Request $request)
    {
        $this->pageData['favoriteAuthors'] = true;
        $this->pageData['userID'] = \Auth::User()->user_id;

//        $FavoriteAuthor = new FavoriteAuthor();
//
//        $paginator = $FavoriteAuthor->getFavoriteAuthors($this->pageData);

        $stories = Auth::user()->favorite_authors();

        if ($this->pageData['sortby'] == "alpha") {
            $stories->leftJoin('users', function ($join) {
                $join->on('users.user_id', '=', 'favorite_authors.author_id');
            })->orderBy("users.name", "asc");
        } elseif ($this->pageData['sortby'] == "oldest") {
            $stories->orderBy("author_id", "asc");
        } else {
            $stories->orderBy("author_id", "desc");
        }
        $paginator = $stories->paginate(15);


//        foreach ($paginator as $author){
//        dump($author->author->stories()->count());
////            if (isset($author->author->user_id)){
////                echo $author->author->user_id . "\n";
////            }
//    }
//        die();

        $this->pageData['PageTitle'] = config('app.name') . ".com - Favorite Authors";
        return view('app.favoriteauthors')->with(['pageData' => $this->pageData])->with(compact('paginator'));
    }

    public function AddFavoriteStories(Request $request)
    {
        if (request()->ajax()) {
            try {
                if ($request->action == 'Add') {
                    $already = 0;
                    $already = FavoriteStory::where("user_id", "=", \Auth::user()->user_id)
                        ->where("story_id", "=", $request->story_id)->get()->toArray();
                    if (!isset($already) || empty($already)) {
                        $data = FavoriteStory::create([
                            'user_id' => \Auth::user()->user_id,
                            'story_id' => $request->story_id,
                            'created_timestamp' => time()
                        ]);
                    }

                    if ($data->id) {
                        return response()->json(['code' => 200, 'success' => 'added_successfully'], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => '', 'message' => '']);
                    }
                } else {
                    // Soft Delete Method
                    $res = FavoriteStory::where("story_id", "=", "$request->story_id")
                        ->where("user_id", "=", \Auth::user()->user_id)->delete();

                    if ($res) {
                        return response()->json(['code' => 200, 'success' => 'removed_successfully'], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => '', 'message' => '']);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_successfully',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function AddNominatedStories(Request $request)
    {
        $points = PointsHistory::nominateStory($request);

        if (request()->ajax()) {
            try {
                if ($request->action == 'Add') {
                    $data = NominatedStory::create([
                        'user_id' => \Auth::user()->user_id,
                        'story_id' => $request->story_id,
                        'created_at' => date('Y-m-d G:i:s')
                    ]);

                    if ($data->id) {
                        return response()->json([
                            'code' => 200,
                            'success' => 'added_successfully',
                            'points' => $points ? 'success' : '',
                        ], 200);
                    } else {
                        return response()->json([
                            'code' => 201,
                            'error' => '',
                            'message' => '',
                            'points' => $points ? 'success' : '',
                        ]);
                    }
                } else {
                    // Soft Delete Method
                    $res = NominatedStory::where("story_id", "=", "$request->story_id")
                        ->where("user_id", "=", \Auth::user()->user_id)->delete();

                    if ($res) {
                        return response()->json(['code' => 200, 'success' => 'removed_successfully'], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => '', 'message' => '']);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 201,
                    'error' => 'Some error occured',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
    public function AddFavoriteAuthor(Request $request)
    {
        if (request()->ajax()) {
            try {
                if ($request->action == 'Add') {
                    $already = 0;
                    $already = FavoriteAuthor::where("user_id", "=", \Auth::user()->user_id)
                        ->where("author_id", "=", $request->user_id)->get()->toArray();
                    if (!isset($already) || empty($already)) {
                        $data = FavoriteAuthor::create([
                            'user_id' => \Auth::user()->user_id,
                            'author_id' => $request->user_id,
                            'created_timestamp' => time()
                        ]);
                    }

                    if ($data->id) {
                        return response()->json(['code' => 200, 'success' => 'added_successfully'], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => '', 'message' => '']);
                    }
                } else {
                    // Soft Delete Method
                    $res = FavoriteAuthor::where("author_id", "=", "$request->user_id")
                        ->where("user_id", "=", \Auth::user()->user_id)->delete();
                    if ($res) {
                        return response()->json(['code' => 200, 'success' => 'removed_successfully'], 200);
                    } else {
                        return response()->json(['code' => 201, 'error' => '', 'message' => '']);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => 201,
                    'error' => 'commented_successfully',
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
    public function AddThumbsupStories(Request $request,$id) {
        
        $data = StoryLikeRates::create([
            'story_id' => $id,
            'ip_address' => $request->ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return response()->json(['data' => $data]);
        
    }
} 