<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JsValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ContactNotification;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteUser;
use App\Models\BlockedIpAddress;
use DB;

class HomeController extends Controller
{
    public $pageData = [];

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //'contact', 'contactAction'
        $this->middleware('auth')->except(['index', 'about', 'submission', 'comingSoon', 'privacyPolicy', 'posting', 'howtowrite', 'premium-membership', 'contests', 'links', 'contact','contactAction']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->pageData['PageTitle'] = 'Home';
        return view('app.home')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - About us';

        return view('app.about')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function comingSoon()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Coming Soon';

        return view('app.comingsoon')->with(['pageData' => $this->pageData]);
    }


    public function brightest()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Coming Soon';

        return view('app.brightest_star')->with(['pageData' => $this->pageData]);
    }

    public function subscription()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Coming Soon';

        return view('app.subscription')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        $ValidationRules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'captcha_code'=>'required',
            'captcha'=>'required'
        ];
        $ValidationMessages = [
            'name.required' => 'Please write your name.',
            'email.email' => 'Please write your valid email.',
            'email.required' => 'Please write your email.',
            'subject.required' => 'Please write subject.',
            'message.required' => 'Please write message.',
            'captcha_code.required' => 'Please pass recaptcha test.',
            'captcha.required' => 'Please pass recaptcha test.',
        ];

        // Js form validation
        $validator = JsValidator::make($ValidationRules, $ValidationMessages);

        $this->pageData['PageTitle'] = config('app.name').'.com - Contact us';

        return view('app.contact')
            ->with(['pageData' => $this->pageData])
            ->with(['jsValidation' => true])
            ->with(compact('validator'));
    }

    /**
     * Show the application dashboard.tr.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactAction(Request $request)
    {
        $ValidationRules = [
            'name' => 'required|string|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'email' => 'required|email',
            'subject' => 'required|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'message' => 'required|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'captcha_code'=>'required',
            'captcha'=>'required'
        ];
        $ValidationMessages = [
            'name.required' => 'Please write your name exactly.',
            'email.email' => 'Please write your valid email.',
            'email.required' => 'Please write your email exactly.',
            'subject.required' => 'Please write subject exactly.',
            'message.required' => 'Please write message exactly.',
            'captcha_code.required' => 'Please pass recaptcha test.',
            'captcha.required' => 'Please pass recaptcha test.',
        ];

        // Validation Code
        $validation = Validator::make($request->all(), $ValidationRules, $ValidationMessages);

        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $message = $request->message;

        $user = SiteUser::where('email', $email)->first();
        // dd($user);
        // dd($user->email);
        // exit(1);
        
        // dd(strpos($email, '.xyz'));
        // exit(1);
        if(empty($user)) {
            return redirect('/login');
            // dd(strpos($email, '.xyz'));
            // exit(1);
            // if((strpos($name, 'porn') != 'false') || (strpos($email, 'porn') != 'false') || (strpos($subject, 'porn') != 'false') || (strpos($message, 'porn') != 'false') || (strpos($email, '.xyz') != 'false') || (strpos($email, '.zandex') != 'false')) {
                
            //     $request->session()->flash('alert-danger', 'Your email is blocked!');
            //     return redirect()->back()->withInput()->withErrors($validation->errors());
            // } else {
            //     if ($validation->fails()) {
            //         $request->session()->flash('alert-danger', 'There is some issue in submitting your story. Please go through your form again');
            //         return redirect()->back()->withInput()->withErrors($validation->errors());
            //     }
        
            //     //Recaptcha code
            //     $timestamp = $request->get('captcha_code');
            //     if (session('captcha_code_'.$timestamp) != $request->get('captcha'))
            //     {
            //         $request->session()->flash('alert-danger', 'Capcha can\'t verify you. Please go through your form again');
            //         return redirect()->back()->withInput();
            //     }
        
            //     try {
            //         \Notification::send(Admin::all(), new ContactNotification($request));
            //         $request->session()->flash('alert-success', 'Your message is successfully sent. Our administration will contact you shortly');
            //     } catch (\Exception $e) {
            //         $request->session()->flash('alert-danger', $e->getMessage());
            //     }
        
            //     return redirect()->back();
            // }
        } 
        else {
            
            if((strpos($name, 'porn') == 'false') || (strpos($email, 'porn') == 'false') || (strpos($subject, 'porn') == 'false') || (strpos($message, 'porn') == 'false') || (strpos($email, '.xyz') == 'false') || (strpos($email, '.zandex') == 'false') || (strpos($name, 'Porn') == 'false') || (strpos($email, 'Porn') == 'false') || (strpos($subject, 'Porn') == 'false') || (strpos($message, 'Porn') == 'false') || (strpos($name, 'sex') == 'false') || (strpos($email, 'sex') == 'false') || (strpos($subject, 'sex') == 'false') || (strpos($message, 'sex') == 'false')) {
                // $user->is_blocked = 1;
                // $user->update();
                
                
                // BlockedIpAddress::create([
                //     'ip_address' => $user->last_login_ip,
                // ]);
                
                $request->session()->flash('alert-danger', 'Your email is blocked!');
                return redirect()->back()->withInput()->withErrors($validation->errors());
            } else {
                if ($validation->fails()) {
                    $request->session()->flash('alert-danger', 'There is some issue in submitting your story. Please go through your form again');
                    return redirect()->back()->withInput()->withErrors($validation->errors());
                }
        
                //Recaptcha code
                $timestamp = $request->get('captcha_code');
                if (session('captcha_code_'.$timestamp) != $request->get('captcha'))
                {
                    $request->session()->flash('alert-danger', 'Capcha can\'t verify you. Please go through your form again');
                    return redirect()->back()->withInput();
                }
        
                try {
                    \Notification::send(Admin::all(), new ContactNotification($request));
                    $request->session()->flash('alert-success', 'Your message is successfully sent. Our administration will contact you shortly');
                } catch (\Exception $e) {
                    $request->session()->flash('alert-danger', $e->getMessage());
                }
        
                return redirect()->back();
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function submission()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Submission Agreement';

        return view('app.submission')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function posting()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Story Posting Instructions';

        return view('app.posting')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function howtowrite()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - How to write';

        return view('app.howtowrite')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacyPolicy()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Privacy Policy';

        return view('app.privacypolicy')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function help()
    {
        return view('app.help')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contests()
    {
        $this->pageData['PageTitle'] = 'Contests';
        $this->pageData['PageTitle'] = config('app.name').'.com - StoryStar.com - Free short story writing contest - Win $250. Plus front page stardom!';

        return view('app.contests')->with(['pageData' => $this->pageData]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function links()
    {
        $this->pageData['PageTitle'] = config('app.name').'.com - Links';

        return view('app.links')->with(['pageData' => $this->pageData]);
    }
}
