<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;

class BlogCommentController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }
    public function edit($id){
        $this->pageData['PageTitle'] = "Edit Comment";
        $this->pageData['MainNav'] = "Blog";
        $this->pageData['SubNav'] = "Edit Comment";
        $edit_comment= BlogComment::find($id);
        return view('admin.pages.blog.editcomment')->with(['pageData' => $this->pageData])->with('edit_comment',$edit_comment);
    }
    
    public function update(Request $request, $id) {
        
        $update = BlogComment::find($id);       
        
        $update->update([
           'comment' =>$request->comment,

       ]);
        return redirect(route('admin-blog-list'))->with('success', 'Comment has been updated');
    }
    public function destroy($id){
        BlogComment::where('id', $id)->delete();
        
        return redirect(route('admin-blog-list'));
    }
}
