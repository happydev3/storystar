<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BackupManager\Filesystems\Destination;
use App\Models\Blogs;
use Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    public function dashboard()
    {


        $this->pageData['PageTitle'] = "Dashboard";
        $this->pageData['MainNav'] = "Dashboard";
        $this->pageData['SubNav'] = "";

        return view("admin.dashboard")->with(['pageData' => $this->pageData]);

    }
    

}
