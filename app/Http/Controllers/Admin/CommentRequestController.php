<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class CommentRequestController extends Controller
{
    //
    public function requestComment(Request $request,$story_id)
    {
        $stroy = \App\Models\Story::findOrFail($story_id);
        $emails = [];
        $requestEmails = array_filter(explode(',', $request->emails));
        if(count($requestEmails) > 0) {
            foreach ($requestEmails as $email) {
                foreach (array_filter(explode(',', $request->emails)) as $email) {
                    $email = trim($email);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return response()->json(['code' => 500, 'success' => 'rated_successfully'], 500);
                    } 
                    $emails[] = $email;
                }
            }
        }else{
            return response()->json(['code' => 500, 'success' => 'rated_successfully'], 500);
        }
        foreach ($emails as $email) {
            $email = trim($email);
            $content = 'Request comments on story';
            $subject = 'StoryStar : Request Story Comments';
            $link = route("app-storynew",
                            [   'story_id'  => $stroy->story_id,
                                'user_name' => str_slug($stroy->author_name),
                                'category'  => str_slug($stroy->category->category_title),
                                'theme'     => $stroy->getSlugTheme(),
                                'anonymous' => 'anonymous'
                            ]);
            Mail::send('email.mail',[
                'content' => $content,'link' => $link], 
                    function ($mail) use($email,$subject)  {           
                $mail->to($email, $email)
                     ->subject($subject);
            });
            
            
        }
        return response()->json(['code' => 200, 'success' => 'rated_successfully'], 200);
    }
    
}
