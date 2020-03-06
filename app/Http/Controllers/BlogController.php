<?php

namespace App\Http\Controllers;

use App\Models\PointsHistory;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blogs;
use App\Models\BlogComment;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BlogCommenterNotification;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function blog($type = null)
    {
        if ($type == 'comments') {
            $comments = Comment::with('user', 'story')
                ->orderby('created_at', 'desc')
                ->paginate(10);

//dd($comments);

            return view('app.blog-comments')->with('comments', $comments);
        } elseif ($type == 'tip') {
//            $blogsSorts = DB::select('
//                SELECT
//                    DISTINCT(blogs.id),
//                    blogs.is_pin,
//                    blogs.section_id,
//                    blog_comments.id as comments_id,
//                    (CASE WHEN blog_comments.id is null THEN blogs.created_at ELSE blog_comments.created_at END) AS date
//                FROM `blogs`
//                LEFT JOIN blog_comments ON (blog_comments.blog_id = blogs.id )
//                WHERE section_id = 1
//                ORDER BY is_pin DESC,date DESC
//            ');
//
//            $blogIds = [];
//            foreach ($blogsSorts as $blogsSort) {
//                $blogIds[] = $blogsSort->id;
//            }
//            $blogs = Blogs::with('blogcomment')->whereIn('blogs.id', $blogIds)
//                ->orderBy(DB::raw('FIELD(blogs.id,' . implode(',', $blogIds) . ')'))
//                ->paginate(10);
//            return view('app.blog')->with('blogs', $blogs);

            $blogs = Blogs::whereSectionId(1)->with('blogcomment')->orderBy('created_at', 'desc')->paginate(10);

        } elseif ($type == 'inspiration') {
//            $blogsSorts = DB::select('
//                SELECT
//                    DISTINCT(blogs.id),
//                    blogs.is_pin,
//                    blogs.section_id,
//                    blog_comments.id as comments_id,
//                    (
//                        CASE
//                            WHEN blog_comments.id is null THEN blogs.created_at
//                            ELSE blog_comments.created_at
//                        END
//                    ) AS date
//                FROM `blogs`
//                LEFT JOIN blog_comments ON (blog_comments.blog_id = blogs.id )
//                WHERE section_id = 2
//                ORDER BY is_pin DESC,date DESC
//            ');
//
//            $blogIds = [];
//            foreach ($blogsSorts as $blogsSort) {
//                $blogIds[] = $blogsSort->id;
//            }
//            $blogs = Blogs::with('blogcomment')->whereIn('blogs.id', $blogIds)
//                ->orderBy(DB::raw('FIELD(blogs.id,' . implode(',', $blogIds) . ')'))
//                ->paginate(10);
//            return view('app.blog')->with('blogs', $blogs);
            $blogs = Blogs::whereSectionId(2)->with('blogcomment')->orderBy('created_at', 'desc')->paginate(10);

        } elseif ($type == 'articles') {
//            $blogsSorts = DB::select('
////                SELECT
////                    DISTINCT(blogs.id),
////                    blogs.is_pin,
////                    blogs.section_id,
////                    blog_comments.id as comments_id,
////                    (
////                        CASE
////                            WHEN blog_comments.id is null THEN blogs.created_at
////                            ELSE blog_comments.created_at
////                        END
////                    ) AS date
////                FROM `blogs`
////                LEFT JOIN blog_comments ON (blog_comments.blog_id = blogs.id )
////                WHERE section_id = 3
////                ORDER BY is_pin DESC,date DESC
////            ');
////
////            $blogIds = [];
////            foreach ($blogsSorts as $blogsSort) {
////                $blogIds[] = $blogsSort->id;
////            }
////            $blogs = Blogs::with('blogcomment')->whereIn('blogs.id', $blogIds)
////                ->orderBy(DB::raw('FIELD(blogs.id,' . implode(',', $blogIds) . ')'))
////                ->paginate(10);
////            return view('app.blog')->with('blogs', $blogs);
            $blogs = Blogs::whereSectionId(3)->with('blogcomment')->orderBy('created_at', 'desc')->paginate(10);

        } else {
//            $blogsSorts = DB::select('
//                SELECT
//                    DISTINCT(blogs.id),
//                    blogs.is_pin,
//                    blogs.section_id,
//                    blog_comments.id as comments_id,
//                    (
//                        CASE
//                            WHEN blog_comments.id is null THEN blogs.created_at
//                            ELSE blog_comments.created_at
//                        END
//                    ) AS date
//                FROM `blogs`
//                LEFT JOIN blog_comments ON (blog_comments.blog_id = blogs.id )
//                WHERE section_id = 4
//                OR section_id = 0
//                ORDER BY is_pin DESC,date DESC
//            ');



            $blogs = Blogs::whereSectionId(4)->with('blogcomment')->orderBy('created_at', 'desc')->paginate(10);

//            $blogIds = [];
//            foreach ($blogsSorts as $blogsSort) {
//                $blogIds[] = $blogsSort->id;
//            }
//            $blogs = Blogs::with('blogcomment')->whereIn('blogs.id', $blogIds)
//                ->orderBy(DB::raw('FIELD(blogs.id,' . implode(',', $blogIds) . ')'))
//                ->paginate(10);
//

        }


        return view('app.blog')->with('blogs', $blogs);
    }

    public function comments($id, Request $request)
    {
        $this->validate($request, ['comment' => 'required']);
        $comment = BlogComment::create([
            'user_id' => Auth::id(),
            'blog_id' => $id,
            'comment' => $request->comment
        ]);

        //Adding in points
        $points = PointsHistory::postReplyOnBlog($request->all(), $comment->id, $id);

        $blog = Blogs::find($id);
        $to = \App\Models\Admin::select('name', 'email')->get();
        /*Blog comment Mail notification */
        \Notification::send($to, new BlogCommenterNotification($comment, $request, $blog));
        $div = view('app.components.blog-comment', compact('comment'))->render();
        return response()->json(
            [
                'div' => $div,
                'points' => $points ? 'success' : '',
            ]
        );
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
