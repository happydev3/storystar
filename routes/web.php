<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::any('/cron-rate', function () {
//    Artisan::call('update:rating');
//    dd(Artisan::output());
//});

use Illuminate\Http\Request;
use App\Models\Story;


Route::get('php/read_story.php{story_id?}', function (\Illuminate\Http\Request $request) {
    return redirect(config('app.url') . 'story/' . $request->story_id, 301);
});
Route::get('email/unsubscribe', 'UserController@unsubscribeBulk');
Route::get('email/unsubscribe/success', function () {
  return view('app.unsubscribed');
})->name('unsubscribed');


Route::get('php/list.php{sub_category_id?}', function (\Illuminate\Http\Request $request) {
    if (isset($request->theme_id) && !empty($request->theme_id)) {
        return redirect(route("app-stories", ['theme' => $request->theme_id]), 301);
    } elseif (isset($request->sub_category_id) && !empty($request->sub_category_id)) {
        return redirect(route("app-stories", ['subcategory' => $request->sub_category_id]), 301);
    } else {
        return redirect(route("app-stories"), 301);
    }
});

Route::get('php/search.php', function () {
    return redirect(route("app-stories"), 301);
});

Route::get('php/post.php', function () {
    return redirect(route("app-publish-story"), 301);
});

Route::get('php/aboutus.php', function () {
    return redirect(route("app-about"), 301);
});

Route::get('php/links.php', function () {
    return redirect(route("app-links"), 301);
});

Route::get('php/writing_contents.php', function () {
    return redirect(route("app-contests"), 301);
});

Route::get('php/howtowrite.php', function () {
    return redirect(route("app-howtowrite"), 301);
});

Route::get('php/posting_instructions.php', function () {
    return redirect(route("app-posting"), 301);
});

Route::get('php/guidelines.php', function () {
    return redirect(route("app-submission"), 301);
});

Route::get('php/contribute_new.php', function () {
    return redirect(route("app-help"), 301);
});

Route::post('upload-profile-photo', ['as' => 'ajaxImageUpload', 'uses' => 'UploadController@uploadProfilePhoto']);

Route::group(['prefix' => 'story-admin', 'namespace' => 'Admin', 'as' => 'admin-'], function () {
    Route::get('/', ['uses' => 'LoginController@showLoginForm', 'as' => 'login']);
    Route::get('login', ['uses' => 'LoginController@showLoginForm', 'as' => 'login']);
    Route::post('login', 'LoginController@login');
    Route::get('logout', ['uses' => 'LoginController@logout', 'as' => 'logout']);
    Route::get('dashboard', ['uses' => 'AdminController@dashboard', 'as' => 'dashboard']);

    /*Admin Manage Blog start*/
    Route::get('blog-list/{type?}', ['uses' => 'BlogController@show', 'as' => 'blog-list']);
    Route::get('blog', ['uses' => 'BlogController@blog', 'as' => 'blog']);
    Route::get('edit_blog/{id}', ['uses' => 'BlogController@edit', 'as' => 'edit_blog']);
    Route::get('delete_blog/{id}', ['uses' => 'BlogController@destroy', 'as' => 'delete_blog']);
    Route::patch('update_blog/{id}', ['uses' => 'BlogController@update', 'as' => 'update_blog']);
    Route::post('blog', ['uses' => 'BlogController@store', 'as' => 'blog']);
    Route::get('edit_comments/{id}', ['uses' => 'BlogCommentController@edit', 'as' => 'edit_comments']);
    Route::get('delete_comment/{id}', ['uses' => 'BlogCommentController@destroy', 'as' => 'delete_comment']);
    Route::patch('update_comment/{id}', ['uses' => 'BlogCommentController@update', 'as' => 'update_comment']);
    Route::get('pin-blog/{id}', ['uses' => 'BlogController@pin', 'as' => 'pin-blog']);
    /*Admin Manage Blog Ends*/

    Route::get('password/reset', ['uses' => 'ForgotPasswordController@showLinkRequestForm', 'as' => 'password-request']);
    Route::post('password/email', ['uses' => 'ForgotPasswordController@sendResetLinkEmail', 'as' => 'password-email']);
    Route::get('password/reset/{token}', ['uses' => 'ResetPasswordController@showResetForm', 'as' => 'password-rest']);
    Route::post('password/reset', ['uses' => 'ResetPasswordController@reset', 'as' => 'password-request']);
    Route::get('settings', ['uses' => 'SettingsController@index', 'as' => 'settings']);
    Route::patch('settings', ['uses' => 'SettingsController@update', 'as' => 'settings-update']);
    Route::get('update-custom-columns', ['uses' => 'SettingsController@updateCustomViewColumns', 'as' => 'custom-view-update']);

    // Admin User CRUD Routes
    Route::group(['as' => 'site-member-', 'prefix' => 'site-member'], function () {
        Route::get('list', ['uses' => 'SiteUserController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'SiteUserController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'SiteUserController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'SiteUserController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'SiteUserController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'SiteUserController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'SiteUserController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'SiteUserController@destroy', 'as' => 'delete']);
        Route::get('trash-user/{id}',['uses' => 'SiteUserController@trashUser', 'as'=>'trash-user']);
        Route::get('delete-multiple', ['uses' => 'SiteUserController@destroyMany', 'as' => 'delete-multiple']);
        Route::get('update-block/{id}', ['uses' => 'SiteUserController@updateBlock', 'as' => 'block']);
        Route::get('send-email/{id}', ['uses' => 'SiteUserController@sendEmail', 'as' => 'send-email']);
        Route::patch('send-email/{id}', ['uses' => 'SiteUserController@sendEmailAction', 'as' => 'send-email']);
        Route::get('premium/{id}', ['uses' => 'SiteUserController@premium', 'as' => 'premium']);
    });

    // Admin Backend User CRUD Routes
    Route::group(['as' => 'member-', 'prefix' => 'member'], function () {
        Route::get('list', ['uses' => 'UserController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'UserController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'UserController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'UserController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'UserController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'UserController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'UserController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'UserController@destroy', 'as' => 'delete']);
    });

    // Admin User CRUD Routes
    Route::group(['as' => 'star-', 'prefix' => 'star-portraits'], function () {
        Route::get('list', ['uses' => 'StarPortraitsController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'StarPortraitsController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'StarPortraitsController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'StarPortraitsController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'StarPortraitsController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'StarPortraitsController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'StarPortraitsController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'StarPortraitsController@destroy', 'as' => 'delete']);
        Route::get('thumb/{id}', ['uses' => 'StarPortraitsController@editThumb', 'as' => 'thumb']);
        //  Route::post('thumb-creation/{id}', ['uses' => 'StarPortraitsController@editThumbAction', 'as' => 'thumb-creation']);
        Route::patch('thumb-creation/{id}', ['uses' => 'StarPortraitsController@editThumbAction', 'as' => 'thumb-creation']);
    });

    // Themes CRUD Routes
    Route::group(['as' => 'theme-', 'prefix' => 'theme'], function () {
        Route::get('list', ['uses' => 'ThemeController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'ThemeController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'ThemeController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'ThemeController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'ThemeController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'ThemeController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'ThemeController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'ThemeController@destroy', 'as' => 'delete']);
    });

    // Subjects CRUD Routes
    Route::group(['as' => 'subject-', 'prefix' => 'subject'], function () {
        Route::get('list', ['uses' => 'SubjectController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'SubjectController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'SubjectController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'SubjectController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'SubjectController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'SubjectController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'SubjectController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'SubjectController@destroy', 'as' => 'delete']);
    });

    // Categories CRUD Routes
    Route::group(['as' => 'category-', 'prefix' => 'category'], function () {
        Route::get('list', ['uses' => 'CategoryController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'CategoryController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'CategoryController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'CategoryController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'CategoryController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'CategoryController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'CategoryController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'CategoryController@destroy', 'as' => 'delete']);
    });

    // SubCategories CRUD Routes
    Route::group(['as' => 'subcategory-', 'prefix' => 'subcategory'], function () {
        Route::get('list', ['uses' => 'SubCategoryController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'SubCategoryController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'SubCategoryController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'SubCategoryController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'SubCategoryController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'SubCategoryController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'SubCategoryController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'SubCategoryController@destroy', 'as' => 'delete']);
    });

    // Stories CRUD Routes
    Route::group(['as' => 'stories-', 'prefix' => 'stories'], function () {
        Route::get('list/clear', ['uses' => 'StoriesController@clear', 'as' => 'clear']);
        Route::get('list/{r?}', ['uses' => 'StoriesController@index', 'as' => 'list']);
        Route::get('list1/{r?}', ['uses' => 'StoriesController@index1', 'as' => 'list1']);
        Route::post('multidelete', ['uses' => 'StoriesController@multidelete', 'as' => 'multidelete']);
        Route::get('data', ['uses' => 'StoriesController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'StoriesController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'StoriesController@store', 'as' => 'add']);
        Route::get('edit/{id}/{callFrom?}', ['uses' => 'StoriesController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'StoriesController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'StoriesController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'StoriesController@destroy', 'as' => 'delete']);
        Route::get('delete-multiple', ['uses' => 'StoriesController@destroyMany', 'as' => 'delete-multiple']);
        Route::get('form-options', ['uses' => 'StoriesController@formOptions', 'as' => 'form-options']);
        Route::post('rate-story/', ['uses' => 'StoriesController@rateStory', 'as' => 'rate-story']);
        Route::get('make-novel-to-story/{id}', ['uses'=> 'StoriesController@makeNovelToStory', 'as'=>'make-novel-to-story']);
        Route::post('update-story-subject/{id}', ['uses' => 'StoriesController@updateStorySubject', 'as' => 'update-story-subject']);
    });

	//Novels CRUD Routes
    Route::group(['as' => 'novels-', 'prefix' => 'novels'], function () {
        //Route::get('list/{r?}', ['uses' => 'StoriesController@index', 'as' => 'list']);
       // Route::get('data', ['uses' => 'StoriesController@data', 'as' => 'data']);
		Route::get('add', ['uses' => 'StoriesController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'StoriesController@store', 'as' => 'add']);
       // Route::patch('update/{id}', ['uses' => 'StoriesController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'StoriesController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'StoriesController@destroy', 'as' => 'delete']);
        Route::get('delete-multiple', ['uses' => 'StoriesController@destroyMany', 'as' => 'delete-multiple']);
       // Route::get('form-options', ['uses' => 'StoriesController@formOptions', 'as' => 'form-options']);
       // Route::post('rate-story/', ['uses' => 'StoriesController@rateStory', 'as' => 'rate-story']);
    });

    // Stories CRUD Routes
    Route::group(['as' => 'filtered-stories-', 'prefix' => 'filtered-stories'], function () {
        Route::get('list/{category_id?}/{sub_category_id?}/{old_id?}/{star_type?}/{r?}', ['uses' => 'FilteredStoriesController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'FilteredStoriesController@data', 'as' => 'data']);
    });

    // Stories CRUD Routes
    Route::group(['as' => 'month-author-', 'prefix' => 'author-of-month'], function () {
        Route::get('list', ['uses' => 'MonthAuthorController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'MonthAuthorController@data', 'as' => 'data']);

        /*Route::get('add', ['uses' => 'MonthAuthorController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'MonthAuthorController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'MonthAuthorController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'MonthAuthorController@update', 'as' => 'update']);*/

        Route::get('detail/{id}', ['uses' => 'MonthAuthorController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'MonthAuthorController@destroy', 'as' => 'delete']);
        Route::get('update-author/{user_id}', ['uses' => 'MonthAuthorController@updateAuthorFromMemberList', 'as' => 'set']);
    });

    // Admin User CRUD Routes
    Route::group(['as' => 'story-star-', 'prefix' => 'story-star'], function () {
        Route::get('list', ['uses' => 'StoryStarController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'StoryStarController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'StoryStarController@create', 'as' => 'add']);
        Route::get('add/{story_id}/{type}/{old_id?}', ['uses' => 'StoryStarController@addStoryStarFromStoriesList', 'as' => 'addfromstories']);
        Route::get('highRated/{category_id?}/{sub_category_id?}/{old_id?}/{star_type?}/{r?}', ['uses' => 'StoryStarController@getHighRatedStories', 'as' => 'high-rated']);
        Route::post('add', ['uses' => 'StoryStarController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'StoryStarController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'StoryStarController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'StoryStarController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'StoryStarController@destroy', 'as' => 'delete']);
    });

    Route::group(['as' => 'blocked-ip-', 'prefix' => 'blocked-ip'], function(){
        Route::get('list', ['uses' => 'BlockedIpAddressController@index', 'as' => 'list']);
        Route::get('delete/{id}', ['uses' => 'BlockedIpAddressController@destroy', 'as' => 'delete']);
    });

    // Admin Ads CRUD Routes
    Route::group(['as' => 'ads-', 'prefix' => 'ads'], function () {
        Route::get('list', ['uses' => 'AdsController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'AdsController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'AdsController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'AdsController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'AdsController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'AdsController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'AdsController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'AdsController@destroy', 'as' => 'delete']);
        Route::get('update-block/{id}', ['uses' => 'AdsController@updateBlock', 'as' => 'block']);
    });

    // Admin Points Bad Words CRUD Routes
    Route::group(['as' => 'points-bad-words-', 'prefix' => 'points-bad-words'], function () {
        Route::get('list', ['uses' => 'PointsBadWordsController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'PointsBadWordsController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'PointsBadWordsController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'PointsBadWordsController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'PointsBadWordsController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'PointsBadWordsController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'PointsBadWordsController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'PointsBadWordsController@destroy', 'as' => 'delete']);
    });

    // Admin Points Category CRUD Routes
    Route::group(['as' => 'points-category-', 'prefix' => 'points-category'], function () {
        Route::get('list', ['uses' => 'PointsCategoryController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'PointsCategoryController@data', 'as' => 'data']);
        Route::get('edit/{id}', ['uses' => 'PointsCategoryController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'PointsCategoryController@update', 'as' => 'update']);
    });

    // Admin Points On Hold CRUD Routes
    Route::group(['as' => 'points-on-hold-', 'prefix' => 'points-on-hold'], function () {
        Route::get('list', ['uses' => 'PointsOnHoldController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'PointsOnHoldController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'PointsOnHoldController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'PointsOnHoldController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'PointsOnHoldController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'PointsOnHoldController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'PointsOnHoldController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'PointsOnHoldController@destroy', 'as' => 'delete']);
        Route::get('approve/{id}', ['uses' => 'PointsOnHoldController@approve', 'as' => 'approve']);
    });

    // Admin Points History CRUD Routes
    Route::group(['as' => 'points-history-', 'prefix' => 'points-history'], function () {
        Route::get('list', ['uses' => 'PointsHistoryController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'PointsHistoryController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'PointsHistoryController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'PointsHistoryController@store', 'as' => 'add']);
        Route::get('delete/{id}', ['uses' => 'PointsHistoryController@destroy', 'as' => 'delete']);
    });

    // Admin Backend User CRUD Routes
    Route::group(['as' => 'flag-', 'prefix' => 'flag'], function () {
        Route::get('list', ['uses' => 'FlagController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'FlagController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'FlagController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'FlagController@store', 'as' => 'add']);
        Route::get('edit/{id}', ['uses' => 'FlagController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'FlagController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'FlagController@show', 'as' => 'detail']);
        Route::get('delete/{id}', ['uses' => 'FlagController@destroy', 'as' => 'delete']);
    });

    // Admin Links CRUD Routes
    Route::group(['as' => 'links-', 'prefix' => 'links'], function () {
        Route::get('edit/{id}', ['uses' => 'LinksController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'LinksController@update', 'as' => 'update']);
    });

    // Admin Links CRUD Routes
    Route::group(['as' => 'contest-', 'prefix' => 'contest'], function () {
        Route::get('entries', ['uses' => 'ContestController@index', 'as' => 'entries']);
        Route::get('approve-entry/{id}', ['uses' => 'ContestController@approve', 'as' => 'approve-entry']);
        Route::get('edit/{id}', ['uses' => 'ContestController@edit', 'as' => 'edit']);
        Route::patch('update/{id}', ['uses' => 'ContestController@update', 'as' => 'update']);
    });

    // Admin Backend User CRUD Routes
    Route::group(['as' => 'subscriber-', 'prefix' => 'subscriber'], function () {
        Route::get('list', ['uses' => 'SubscriberController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'SubscriberController@data', 'as' => 'data']);
        Route::get('delete/{id}', ['uses' => 'SubscriberController@destroy', 'as' => 'delete']);
    });

    // Manage Comments
    Route::group(['as' => 'comments-', 'prefix' => 'comments'], function () {
        Route::get('list/{story_id}', ['uses' => 'CommentsController@index', 'as' => 'list']);
        Route::get('data', ['uses' => 'CommentsController@data', 'as' => 'data']);
        Route::get('add', ['uses' => 'CommentsController@create', 'as' => 'add']);
        Route::post('add', ['uses' => 'CommentsController@store', 'as' => 'add']);
        Route::get('edit/{id}/{story_id}', ['uses' => 'CommentsController@edit', 'as' => 'edit']);
        Route::patch('update/{id}/{story_id}', ['uses' => 'CommentsController@update', 'as' => 'update']);
        Route::get('detail/{id}', ['uses' => 'CommentsController@show', 'as' => 'detail']);
        Route::get('delete/{id}/{story_id}', ['uses' => 'CommentsController@destroy', 'as' => 'delete']);
    });

    /**
     * Request story comment
     */
    Route::post('request-comment/{story_id}', ['uses' => 'CommentRequestController@requestComment', 'as' => 'request-story-comment']);

});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('sign-up', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('sign-up', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('resend-verification/{email}', 'Auth\RegisterController@resendVerifyEmail')->name('resend.email');
Route::get('resend-verification-account-settings/{email}', 'UserController@resendVerifyEmail')->name('resend.email.account');

Route::group(['prefix' => '', 'as' => 'app-'], function () {
	Route::get('/story/{story_id}/{user_name}/{category}/{theme}/{anonymous?}', ['uses' => 'StoriesController@story', 'as' => 'storynew']);
	Route::get('/story/{story_id}', function($id){
		$result = Story::find($id);
		if($result){
		    $category = str_slug($result->category->category_title);
    		$theme_slug = str_slug($result->theme->theme_slug);
    		$author_name = str_slug($result->author_name);
    		return redirect('/story/'.$id.'/'.$author_name.'/'.$category.'/'.$theme_slug.'', 301);
		}
		else{
		    abort(404);
		}

	})->name('story');

    Route::get('/brightest-stars', ['uses' => 'HomeController@brightest', 'as' => 'brightest']);
    Route::get('/subscription-service', ['uses' => 'HomeController@subscription', 'as' => 'subscription']);


    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'main']);
    Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'main']);
    Route::get('/about-us', ['uses' => 'HomeController@about', 'as' => 'about']);
    Route::get('/contact-us', ['uses' => 'HomeController@contact', 'as' => 'contact']);
    Route::post('/contact-us', ['uses' => 'HomeController@contactAction', 'as' => 'contact-action']);
    Route::get('/short-story-contests', ['uses' => 'HomeController@contests', 'as' => 'contests']);
    Route::get('/links', ['uses' => 'HomeController@links', 'as' => 'links']);

    Route::get('/submission-agreement', ['uses' => 'HomeController@submission', 'as' => 'submission']);
    Route::get('/posting-instructions', ['uses' => 'HomeController@posting', 'as' => 'posting']);
    Route::get('/privacy-policy', ['uses' => 'HomeController@privacyPolicy', 'as' => 'privacypolicy']);
    Route::get('/how-to-write', ['uses' => 'HomeController@howtowrite', 'as' => 'howtowrite']);
    Route::get('/premium-membership', ['uses' => 'HomeController@help', 'as' => 'help']);

    Route::get('/story-theme/{theme?}/{theme_slug?}', ['uses' => 'StoriesController@stories', 'as' => 'story-theme']);
    Route::get('/story-subject/{subject?}/{subject_slug?}', ['uses' => 'StoriesController@stories', 'as' => 'story-subject']);
    //Route::get('/stories', ['uses' => 'StoriesController@stories', 'as' => 'stories']);
    Route::get('/read-short-stories', ['uses' => 'StoriesController@stories', 'as' => 'stories']);
    Route::get('/favorite-stories', ['uses' => 'StoriesController@favoriteStories', 'as' => 'fav-stories']);
    Route::get('/favorite-authors', ['uses' => 'StoriesController@favoriteAuthors', 'as' => 'fav-authors']);
    Route::get('/stories-category/{category}/{slug}', ['uses' => 'StoriesController@stories', 'as' => 'story-category']);
    Route::get('/stories-subcategory/{subcategory}/{slug?}', ['uses' => 'StoriesController@stories', 'as' => 'story-subcategory']);
    //Route::get('/story/{story_id}', ['uses' => 'StoriesController@story', 'as' => 'story']);
    //Route::get('/story/{story_id}/{user_name}/{category}/{theme}', ['uses' => 'StoriesController@story', 'as' => 'story']);

    Route::get('/blog/{type?}', ['uses' => 'BlogController@blog', 'as' => 'blog']);
    Route::get('/blog-tip/{type?}', ['uses' => 'BlogController@blog', 'as' => 'blog-tip']);
    Route::get('/blog-inspiration/{type?}', ['uses' => 'BlogController@blog', 'as' => 'blog-inspiration']);
    Route::get('/blog-articles/{type?}', ['uses' => 'BlogController@blog', 'as' => 'blog-articles']);
    Route::post('/blog-coments/{id?}', ['uses' => 'BlogController@comments', 'as' => 'blog-comments']);
    Route::get('/edit-story/{story_id}', ['uses' => 'StoriesController@publishStory', 'as' => 'edit-story']);
    Route::get('/publish-story/{story_id?}', ['uses' => 'StoriesController@publishStory', 'as' => 'publish-story']);
    Route::post('/publish-story/{story_id?}', ['uses' => 'StoriesController@publishStoryAction', 'as' => 'publish-story-action']);

    Route::get('/no-story-ratted/{story_id}', ['uses' => 'StoriesController@storyRatingDetail', 'as' => 'story-rating-no']);
    Route::get('/story-rating/{story_id}', ['uses' => 'StoriesController@storyRatingDetail', 'as' => 'story-rating']);
	Route::get('/edit-novel/{story_id}', ['uses' => 'StoriesController@publishNovel', 'as' => 'edit-novel']);
	Route::get('/publish-novel/{story_id?}', ['uses' => 'StoriesController@publishNovel', 'as' => 'publish-novel']);
	Route::post('/publish-novel/{story_id?}', ['uses' => 'StoriesController@publishNovelAction', 'as' => 'publish-novel-action']);

    Route::get('/logout/', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
    Route::get('/verifyEmailFirst', ['uses' => 'Auth\RegisterController@verifyEmail', 'as' => 'verify-email-first']);
    Route::get('/verifyEmailFirst/{token}', ['uses' => 'Auth\RegisterController@verifyEmailToken', 'as' => 'verify-email-token']);
    Route::get('/profile/{user_id}/{user_name}', ['uses' => 'UserController@profile', 'as' => 'profile']);

    Route::post('/rate-story/', ['uses' => 'StoriesController@rateStory', 'as' => 'rate-story']);
    Route::post('/nominate-story/', ['uses' => 'StoriesController@nominateStory', 'as' => 'nominate-story']);
    Route::post('/getMoreComments', ['uses' => 'StoriesController@getMoreComments', 'as' => 'get-comments']);
    Route::post('/postComment/{story_id}/', ['uses' => 'StoriesController@postComment', 'as' => 'post-comment']);
    Route::post('/postCommentReply/{story_id}/{comment_id}', ['uses' => 'StoriesController@postCommentReply', 'as' => 'post-comment-reply']);
    Route::post('/flag-story/{story_id}/', ['uses' => 'StoriesController@FlagStory', 'as' => 'flag-story']);

    Route::get('/history', ['uses' => 'UserController@history', 'as' => 'history-item']);
    Route::get('/my-account', ['uses' => 'UserController@account', 'as' => 'account']);
    Route::post('/my-account', ['uses' => 'UserController@updateSettings', 'as' => 'update-account']);

    Route::get('/my-account/profile-setup', ['uses' => 'UserController@account', 'as' => 'profile-setup']);

    Route::get('/my-account/points', ['uses' => 'UserController@account', 'as' => 'points-detail']);
    Route::get('/author/stories/{id}', ['uses' => 'UserController@authorStories', 'as' => 'author-stories']);
    Route::get('/my-account/points-usage', ['uses' => 'UserController@account', 'as' => 'points-usage']);
    Route::get('/my-account/points/history', ['uses' => 'UserController@account', 'as' => 'points-history']);
    Route::get('/my-account/change-password', ['uses' => 'UserController@account', 'as' => 'update-password-form']);
    Route::post('/update-password/', ['uses' => 'UserController@updatePassword', 'as' => 'update-password']);
    Route::post('/gift-points/', ['uses' => 'UserController@giftPoints', 'as' => 'gift-points']);
    Route::post('/enter-contest/', ['uses' => 'UserController@enterContest', 'as' => 'enter-contest']);
    
    Route::post('/premium-with-point/', ['uses' => 'UserController@premiumWithPoint', 'as' => 'premium-with-point']);
    
    Route::get('/update-favorite-stories/{story_id?}/{action?}', ['uses' => 'StoriesController@AddFavoriteStories', 'as' => 'add-fav-stories']);
    Route::get('/update-nominated-stories/{story_id?}/{action?}', ['uses' => 'StoriesController@AddNominatedStories', 'as' => 'add-nominated-stories']);
    
    Route::get('/update-thumbsup-stories/{story_id?}', ['uses' => 'StoriesController@AddThumbsupStories', 'as' => 'add-thumbsup-stories']);

    Route::get('/update-favorite-author/{user_id?}/{action?}', ['uses' => 'StoriesController@AddFavoriteAuthor', 'as' => 'add-fav-author']);


    Route::post('/subscribe/', ['uses' => 'UserController@addSubscriber', 'as' => 'subscribe']);
    Route::get('/un-subscribe/{email}', ['uses' => 'UserController@unSubscribe', 'as' => 'unsubscribe']);

	Route::get('/contests', function(){
		return redirect('/short-story-contests', 301);
	});
	Route::get('/stories', function(){
		return redirect('/read-short-stories', 301);
	});

});

Route::group(['prefix' => ''], function () {
    define('facebook_url', 'https://web.facebook.com/StoryStar/');
    define('twitter_url', 'https://twitter.com/storystar1');
    define('google_url', 'https://plus.google.com/111189402159270154684');
    define('instagram_url', 'https://instagram.com/storystar1');
    define('linkend_url', 'https://www.linkedin.com/company/9506813/');
});

Route::get('/captcha-image/{code}',function($code){
    $captcha_num = rand(1000, 9999);
    session()->put('captcha_code_'.$code,$captcha_num);
    $image = imagecreate(100, 50); // create background image with dimensions
    imagecolorallocate($image, 255, 255, 255); // set background color
    $text_color = imagecolorallocate($image, 0, 0, 0); // set captcha text color
    imagettftext($image, 20, -15, 20, 30, $text_color, base_path('assets/app/fonts/TheSalvadorCondensed-Regular.ttf'), $captcha_num);

    //header();
    return response()->stream(function() use($image) {
        imagejpeg($image);
    }, 200, ['Content-type'=>'image/jpg']);
});

/*Route::get('/story-linking',function(){
    $sotries = Story::where('user_id','=',0)->get();
    foreach ($sotries as $story){
        $Author = App\Models\SiteUser::firstOrCreate([
            'name' => $story->author_name,
            'country' => $story->author_country,
            'address' => $story->author_address,
        ],[
            'gender' => $story->author_gender,
            'dob' => $story->author_dob,
            'password' => bcrypt(str_random(8)),
            'email' => time().'@storystar.com',
            'created_timestamp' => time(),
            'updated_timestamp' => time(),
            'verify_token' => str_random(40),
            'active' => 1,
            'is_author' => 1,
        ]);

        $story->user_id = $Author->user_id;
        $story->save();
    }
    dd("All sotries linked together");
});*/

Route::get('/clear-cache', function() { $exitCode = Artisan::call('cache:clear'); var_dump($exitCode); return "Cache is cleared"; });

Route::post('/amazon-sns/notifications', 'AmazonController@handleBounceOrComplaint');


Route::group(['prefix' => 'story-admin', 'as'=>'admin.',  'middleware' => 'auth:admin'], function()
{
    Route::get('emails/index', 'AmazonController@index' )->name('email.index');
    Route::delete('emails/delete/{template}','AmazonController@delete')->name('email.delete');
    Route::get('emails/show/{name}', 'AmazonController@show' )->name('email.show');

    Route::get('emails/bounces', 'AmazonController@bounces' )->name('email.bounces');
    Route::get('emails/create', 'AmazonController@create' )->name('email.create');
    Route::post('emails/store','AmazonController@store')->name('email.store');
    Route::post('emails/ajax', 'AmazonController@create_ajax' )->name('email.ajax');

    Route::get('emails/send', 'AmazonController@send' )->name('email.send');
    Route::post('emails/sending','AmazonController@sending')->name('email.sending');
    
});

Route::post('deleteBounceEmail', 'AmazonController@deleteBounceEmail');
Route::get('deleteBounceEmail', 'AmazonController@deleteBounceEmail');

Route::get('/testQ',function (){
    $users = [['lazic.stefan93@gmail.com'],['lazic.stefan933@gmail.com']];

    $counter = 1;
    foreach ($users as $user){
        \App\Jobs\SendEmails::dispatch($user,'newsletter')->delay(\Carbon\Carbon::now()->addSeconds($counter*2));
        $counter++;
    }
});

Route::get('/testM',function (){
    $SesClient = new \Aws\Ses\SesClient([
        'version' => 'latest',
        'region' => env('SES_REGION'),
        'credentials' => [
            'key' => env('SES_KEY'),
            'secret' => env('SES_SECRET')
        ],
    ]);


    $emails = ['lazic.stefan93@gmail.com'];
    $destinations = [];

    foreach ($emails as $email){
        $destinations[]=['Destination' => ['ToAddresses' => [$email],],'ReplacementTemplateData' => '{ }',];
    }
    try {
        $result = $SesClient->sendBulkTemplatedEmail([
            'Destinations' => $destinations,
            'ReplyToAddresses' => ['"StoryStar" <admin@storystar.com>'],
            'Source' => '"StoryStar" <admin@storystar.com>',
            'Template' => 'newsletter',
            'DefaultTemplateData' => '{ }',
        ]);

        dd($result);
    } catch (\Aws\Exception\AwsException $e) {
        // output error message if fails
        echo $e->getMessage();
        echo "\n";
    }
});


Route::get('background',function (){

    return view('background');
});

Route::get('pagetest',function (){
    $user = \App\Models\SiteUser::find(708);
    if ($user){
        dd($user);
    }
});


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('user/{email}',function ($email){
    $user = \App\Models\SiteUser::where('email',$email)->first();
   \Illuminate\Support\Facades\Auth::login($user,false);
});


Route::get('/story-admin/{email}',function ($email){
    $user = \App\Models\Admin::where('email',$email)->first();
    \Illuminate\Support\Facades\Auth::login($user,false);
});



Route::get('/comments-issue',function (){
   $state =\App\Models\Comment::with('user')->groupBy('user_id')->get()->pluck('user');
   dd($state);
});


