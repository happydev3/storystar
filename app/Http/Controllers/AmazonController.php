<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmails;
use App\Models\Comment;
use App\Models\SiteUser;
use App\User;
use App\Wrongemail;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class AmazonController extends Controller
{
    public function handlerIndex(Request $request)
    {
        return $request->all();
    }

    public function deleteBounceEmail() {
        
        $bounce_emails = Wrongemail::where('problem_type', 'Bounce')->get();
        $user_emails = SiteUser::all();
        foreach($bounce_emails as $bounce_email) {
            foreach($user_emails as $user_email) {
              if(($bounce_email->email == $user_email->email) && ($user_email->is_author == 0)) {
                  $user_email->delete();
              }  
            }
        }
        return redirect('story-admin/emails/send');
    }
    
    public function handleBounceOrComplaint(Request $request)
    {
        Log::info('_____________');
        Log::info($request->json()->all());
        Log::info('_____________');
        $data = $request->json()->all();
        $user_emails = SiteUser::all();
        if ($request->json('Type') == 'SubscriptionConfirmation')
            Log::info("SubscriptionConfirmation came at: " . $data['Timestamp']);
        if ($request->json('Type') == 'Notification') {
            $message = json_decode($request->json('Message'), true);

            switch ($message['notificationType']) {
                case 'Bounce':
                    $bounce = $message['bounce'];
                    foreach ($bounce['bouncedRecipients'] as $bouncedRecipient) {
                        $emailAddress = $bouncedRecipient['emailAddress'];

                        
                        // foreach($user_emails as $user_email) {
                        //   if(($user_email->email == $emailAddress) && ($user_email->is_author == 0)) {
                        //       $user_email->delete();
                        //   } 
                        // }
                        foreach($user_emails as $user_email){
                            if(($user_email->email == $emailAddress) && ($user_email->is_author == 0)) {
                                $user_email->active = 0;
                                $user_email->update();
                            }
                        }
                            
                        Log::info($message['bounce']['bounceType']);

                        $emailRecord = Wrongemail::firstOrCreate(['email' => $emailAddress, 'problem_type' => 'Bounce', 'sub_type' => $bounce['bounceType']]);
                        if ($emailRecord) {
                            $emailRecord->increment('repeated_attempts', 1);
                         
                        }
                    }
                    break;
                case 'Complaint':
                    $complaint = $message['complaint'];
                    foreach ($complaint['complainedRecipients'] as $complainedRecipient) {
                        $emailAddress = $complainedRecipient['emailAddress'];
                        $emailRecord = Wrongemail::firstOrCreate(['email' => $emailAddress, 'problem_type' => 'Complaint', 'sub_type' => $complaint['complaintFeedbackType']]);
                        if ($emailRecord) {
                            $emailRecord->increment('repeated_attempts', 1);
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        return Response::json(['status' => 200, "message" => 'success']);
    }


    public function index()
    {
        $pageData = [];
        $pageData['PageTitle'] = "StoryStar";

        $pageData['MainNav'] = "Email";
        $pageData['SubNav'] = "Templates";


        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ],
        ]);


        try {
            $result = $SesClient->listTemplates([
                'MaxItems' => 20,
            ]);
            $templates = $result['TemplatesMetadata'];

        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }

        return view('admin.emails.templates.index', compact('pageData','templates'));
    }

    public function delete($template)
    {
        $pageData = [];
        $pageData['PageTitle'] = "StoryStar";

        $pageData['MainNav'] = "Email";
        $pageData['SubNav'] = "Templates";


        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ],
        ]);


        try {
            $result = $SesClient->deleteTemplate([
                'TemplateName' => $template,
            ]);
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }

        return redirect()->route('admin.email.index');
    }

    public function bounces(){
        $pageData = [];
        $pageData['PageTitle'] = "StoryStar";

        $pageData['MainNav'] = "Email";
        $pageData['SubNav'] = "Templates";


        $wrongEmails = Wrongemail::all();

        return view('admin.emails.bounces',compact('pageData','wrongEmails'));
    }

    public function create(){
        $pageData = [];
        $pageData['PageTitle'] = "StoryStar";

        $pageData['MainNav'] = "Email";
        $pageData['SubNav'] = "Templates";

        $markdown = new \Illuminate\Mail\Markdown(view(), config("mail")['markdown']);
        $testing = [
            "level" => "info",
            "subject" => null,
            "greeting" => null,
            "introLines" => [0 => "First line",1 => 'Second line'],
            "actionText" => "Open website", "actionUrl" => "https://www.storystar.com/",
            "outroLines" => [0=>''],
            "salutation" => "Sincerely,\n\rStoryStar Admin"
        ];

        $HTML = $markdown->render('vendor.notifications.email',$testing);
//        $SesClient = new SesClient([
//            'version' => 'latest',
//            'region' => env('SES_REGION'),
//            'credentials' => [
//                'key' => env('SES_KEY'),
//                'secret' => env('SES_SECRET')
//            ],
//        ]);
//
//
//        try {
//            $result = $SesClient->createTemplate([
//                'Template' => [
//                    'HtmlPart' => $HTML,
//                    'SubjectPart' => 'Testing',
//                    'TemplateName' => 'Original_template',
//                    'TextPart' => $testing['introLines'][0].$testing['actionUrl'].$testing['outroLines'][0],
//                ],
//            ]);
//        } catch (AwsException $e) {
//            echo $e->getMessage();
//            echo "\n";
//        }
        return view('admin.emails.templates.create',compact('pageData','HTML'));
    }

    public function store (Request $request){
        $markdown = new \Illuminate\Mail\Markdown(view(), config("mail")['markdown']);
        $salutation = $request['salutation']."\n"."<p style='font-size:12px !important'>If you don't want to receive these emails from StoryStar in the future, please <a style='text-decoration: none;' href='https://www.storystar.com/email/unsubscribe'>unsubscribe.</a></p>";
        $testing = [
            "level" => "info",
            "subject" => null,
            "greeting" =>$request['greeting'],
            "introLines" => [0 => str_replace("\n","\n\r",$request['introLines'])],
            "outroLines" => [0 => ''],
            "salutation" => str_replace("\n","\n\r",$salutation)
        ];


        if ($request['button']==1){
            $testing['actionText'] = $request['actionText'];
            $testing['actionUrl'] = $request['actionUrl'];
        }

        $HTML = $markdown->render('vendor.notifications.email',$testing);


        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ],
        ]);

        $textpart = $request['introLines']. "\r\n";
        $textpart.=$testing['salutation'];



        try {
            $result = $SesClient->createTemplate([
                'Template' => [
                    'HtmlPart' => $HTML,
                    'SubjectPart' => $request['subject'],
                    'TemplateName' => str_slug($request['templateName'], '-'),
                    'TextPart' => $textpart,
                ],
            ]);
            return redirect()->route('admin.email.index');
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }
    }

    public function create_ajax(Request $request){
        $markdown = new \Illuminate\Mail\Markdown(view(), config("mail")['markdown']);
        $testing = [
            "level" => "info",
            "subject" => null,
            "greeting" =>$request['greeting'],
            "introLines" => [0 => str_replace("\n","\n\r",$request['introLines'])],
            "outroLines" => [0 => ''],
            "salutation" => str_replace("\n","\n\r",$request['salutation'])
        ];

        if (strlen($request['actionText'])>0){
            $testing['actionText'] = $request['actionText'];
            $testing['actionUrl'] = $request['actionUrl'];
        }

        $HTML = $markdown->render('vendor.notifications.email',$testing);

        return $HTML;
    }

    public function send(){
//        $users = User::whereIsAuthor(1)->get();
//        $writers = User::where('is_author','=',1)->pluck('name')->all();
//        $readers = User::where('is_author','=',0)->count();

//        $users = User::count();

//        $users = SiteUser::where('is_author','=',0)->count();




//        $users = SiteUser::where('is_author','=','0')->orWhereNull('is_author')->pluck('email')->chunk(10)->toArray();
//        dd($users);

        $pageData = [];
        $pageData['PageTitle'] = "StoryStar";

        $pageData['MainNav'] = "Email";
        $pageData['SubNav'] = "Templates";

        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ],
        ]);


        try {
            $result = $SesClient->listTemplates([
                'MaxItems' => 20,
            ]);
            $templates = $result['TemplatesMetadata'];

        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }

        $all_count = SiteUser::where('active', '=', '1')->where('is_blocked', '=', '0')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->count();
        $writers_count = SiteUser::where('is_blocked', '=', '0')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->where('active', '=', '1')->where(function ($query) {
                $query->where('is_author', '!=', '1')->orWhereNull('is_author');
            })->count();
        $readers_count = SiteUser::where('is_blocked', '=', '0')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->where('active', '=', '1')->where('is_author', 1)->count();
        $premium_members_count = SiteUser::where('is_blocked', '=', '0')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->where('active', '=', '1')->where('is_premium', 1)->count();

        return view('admin.emails.send', compact('pageData', 'templates', 'all_count', 'writers_count', 'readers_count', 'premium_members_count'));
    }


    public function sending(Request $request)
    {
        if ($request['group'] == 1) {
            $users = SiteUser::where('active', '=', '1')->where('is_blocked', '=', '0')->where('email','godknight930@gmail.com')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->pluck('email')->chunk(10)->toArray();
          
            
        } elseif ($request['group'] == 2) {
            $users = SiteUser::where('is_blocked', '=', '0')->where('active', '=', '1')->where('email','godknight930@gmail.com')->where('is_author', '=', '1')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->pluck('email')->chunk(10)->toArray();
           
        } elseif ($request['group'] == 3) {
            $users = \App\Models\SiteUser::where('is_blocked', '=', '0')->where('email','godknight930@gmail.com')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->where('active', '=', '1')->where(function ($query) {
                $query->where('is_author', '!=', '1')->orWhereNull('is_author');
            })->pluck('email')->chunk(10)->toArray();
        } else {
            $users = SiteUser::where('is_blocked', '=', '0')->where('email','godknight930@gmail.com')->where(function ($query) {
                $query->where('unsubscribed', '=', '0')->orWhereNull('unsubscribed');
            })->where('active', '=', '1')->where('is_premium', 1)->pluck('email')->chunk(10)->toArray();
        }

        $counter = 1;
        foreach ($users as $user) {
            SendEmails::dispatch($user, $request['template'])->delay(\Carbon\Carbon::now()->addSeconds($counter * 2));
            $counter++;
        }

        return redirect()->route('admin.email.bounces');
    }


    public function show($name)
    {
        $pageData = [];
        $pageData['PageTitle'] = "StoryStar";

        $pageData['MainNav'] = "Email";
        $pageData['SubNav'] = "Templates";


        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ],
        ]);


        try {
            $HTML = $SesClient->getTemplate([
                'TemplateName' => $name,
            ])['Template']['HtmlPart'];
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }
        return view('admin.emails.templates.show', compact('pageData','HTML'));
    }
}
