<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Auth;
use App\Models\Admin;

class BlogController extends Controller
{
    /*
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }

    public function show($type = null) 
    {
        $this->pageData['PageTitle'] = "Blog";
        $this->pageData['MainNav'] = "Blog";
        $this->pageData['SubNav'] = "";
        if ($type != null) {
            $blog = Blogs::where('section_id', $type)->orderBy('blogs.created_at', 'desc')->get();
        } else {
            $blog = Blogs::orderBy('blogs.created_at', 'desc')->get();
        }

//        $admin=Admin::with('blogcomment')->where('user_id',Auth::id())->get();
        return view ('admin.pages.blog.index')
//                ->with('admin',$admin)
                        ->with('blog', $blog)
			->with('type', $type)
                        ->with(['pageData' => $this->pageData]);
    }
    
    public function blog()
    {
        $this->pageData['PageTitle'] = "Blog";
        $this->pageData['MainNav'] = " Blog";
        $this->pageData['SubNav'] = "Add Blog";
        $tip= Blogs::WRITE_TIP_OF_THE_DAY;
        $inspiration=Blogs::WRITING_INSPPIRATION;
        $articles=Blogs::INTERESTING_ARTICLES_FOR_WRITERS;
        $news= Blogs::NEWS_AND_INFORMATION;
        return view('admin.pages.blog.create')
                ->with(['pageData' => $this->pageData])
                ->with('tip',$tip)
                ->with('inspiration',$inspiration)
                ->with('articles',$articles)
                ->with('news',$news);
    }
    
    public function store(Request $request) 
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'section_id' => 'required',
        ]);


        $identSize = strlen($request['content'])-strlen(ltrim($request['content']));
        
        $first = '';
        for ($i=0;$i<$identSize;$i++) {
           $first =  '&nbsp;';
        }
        $content = ltrim($request['content']);
        $content = str_replace('<br/>', '#br#', $content);
        $content = str_replace('</p><p>', '</p><p>#br#', $content);
        $content = strip_tags($content);
        $content = str_replace('#br#', '<br/>', $content);
        $content = rtrim($content,'<br/>');
        
        $content = $first.$content;
        
        Blogs::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $content,
            'section_id' => $request->section_id
        ]);
        return redirect(route('admin-blog-list'))->with('success', 'Contact has been added');
    }

    public function pin($id) 
    {
        $pinset = Blogs::find($id);
        if ($pinset->is_pin == 0) {
            $pinset->is_pin = '1';
            $pinset->save();        
        }
        else{
           $pinset->is_pin = '0';
           $pinset->save();
        }
        return redirect(route('admin-blog-list'));
    }
    
    public function edit($id){
        $this->pageData['PageTitle'] = "Edit Blog";
        $this->pageData['MainNav'] = "Blog";
        $this->pageData['SubNav'] = "Edit Blog";
        $edit_blog= Blogs::find($id);
        $tip= Blogs::WRITE_TIP_OF_THE_DAY;
        $inspiration=Blogs::WRITING_INSPPIRATION;
        $articles=Blogs::INTERESTING_ARTICLES_FOR_WRITERS;
        $news= Blogs::NEWS_AND_INFORMATION;
        return view('admin.pages.blog.edit')
                ->with('edit_blog',$edit_blog)
                ->with(['pageData' => $this->pageData])
                ->with('tip',$tip)
                ->with('inspiration',$inspiration)
                ->with('articles',$articles)
                ->with('news',$news);
    }

    public function update(Request $request, $id) 
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'section_id' => 'required',
        ]);

        
        

        $identSize = strlen($request['content'])-strlen(ltrim($request['content']));
        
        $first = '';
        for ($i=0;$i<$identSize;$i++) {
           $first =  '&nbsp;';
        }
        $content = ltrim($request['content']);
        $content = str_replace('<br/>', '#br#', $content);
        $content = str_replace('</p><p>', '</p><p>#br#', $content);
        $content = strip_tags($content);
        $content = str_replace('#br#', '<br/>', $content);
        $content = rtrim($content,'<br/>');
        
        $content = $first.$content;
        
        $update = Blogs::find($id);
        $update->title = $request->title;
        $update->content = $content;
        $update->section_id = $request->section_id;
        $update->save();
        
        return redirect(route('admin-blog-list'))->with('success', 'Product has been updated');
    }
    public function destroy($id){
        Blogs::find($id)->delete();
        return redirect(route('admin-blog-list'));
    }
}
