<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';
    public $subject = "";
    public $to = "";
    public $name = "";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "It will clear the request cache table.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $conr_set = \DB::table('cron_set_templates')->where('status', '1')->first();

        $done_author = [];

        if (!empty($conr_set)) {

            if (isset($conr_set->email_to) && !empty($conr_set->email_to)) {


                $list_data_sent = \DB::table('cron_status_templates')->select('email_to')
                    ->where('cron_set_template_id', $conr_set->id)
                    ->where('set_date', $conr_set->set_date)->get()->toArray();


                $done_author = array();
                if (!empty($list_data_sent)) {
                    //  $done_author = array_values($list_data_sent);
                    $done_author = array_column($list_data_sent, 'email_to');
                }


                $data = [];
                switch ($conr_set->email_to) {

                    case'Authors':

                        $data = \DB::table('users')
                            ->select(['name', 'email'])
                            ->where('is_author', 1)
                            ->whereNotIn('email', $done_author)
                            ->whereNull('deleted_at')
                            ->get()->toArray();

                        break;
                    case'Raters':

                        $data = \DB::table('users')
                            ->select(['name', 'email'])
                            ->where('is_author', 0)
                            ->whereNotIn('email', $done_author)
                            ->whereNull('deleted_at')
                            ->get()->toArray();

                        break;
                    case'Authors and Raters':

                        $data = \DB::table('users')
                            ->select(['name', 'email'])
                            ->whereNotIn('email', $done_author)
                            ->whereNull('deleted_at')
                            ->get()->toArray();


                        break;
                    case'Subscribers':


                        $data = \DB::table('subscriber_list')
                            ->select(['name', 'email'])
                            ->whereNotIn('email', $done_author)
                            ->whereNull('deleted_at')
                            ->get()->toArray();


                }


                $FinalData = [];
                foreach ($data as $d) {

                    $r = ['name' => $d->name, "email" => $d->email];
                    $FinalData[] = ['Users' => $r];
                }
                $data = $FinalData;

                if (!empty($data)) {

                    foreach ($data as $val) {


                        $user_data = array(
                            "tmp_id" => $conr_set->id,
                            "email_template_id" => $conr_set->email_template_id,
                            "receiver_email" => $val["Users"]["email"],
                            "to" => $val["Users"]["email"],
                            //"to" => "faisal@dynamologic.com",
                            "name" => $val["Users"]["name"]
                        );


                        if ($this->__send_mail($user_data, $conr_set)) {


                            $save_data_in_status = array(
                                "cron_set_template_id" => $conr_set->id,
                                "author_id" => isset($val["Users"]["user_id"]) ? $val["Users"]["user_id"] : 0,
                                "email_to" => isset($val["Users"]["email"]) ? $val["Users"]["email"] : '',
                                "set_date" => $conr_set->set_date,
                            );

                            \DB::table('cron_status_templates')->insert($save_data_in_status);


                        }
                    }
                } else {

                    \DB::table('cron_set_templates')
                        ->where('id', $conr_set->id)
                        ->update(['status' => 0]);

                }


            }


        }


        $this->info("\n" . " Email process completed.");

    }


    public function __send_mail($user_data = array(), $conr_set = array())
    {

       // return true;


        $str = "";

        //  $url = Router::url('/', true) . 'un-subscribe/' . base64_encode($user_data['receiver_email']);
        $url = "https://storystar.com/un-subscribe/" . base64_encode($user_data['receiver_email']);
        $url = str_replace("mailgun/", "", $url);


        if ($conr_set->email_to == 'Subscribers') {
            $str = "<p style='font-size: 14px; color: #ddd; padding-bottom: 10px; text-decoration: none'>
            If you don't want to receive these emails in the future, please <a href='" . $url . "'>click here</a></p>";
        }


        // Getting Emails
        $template_data = \DB::table('email_templates')
            ->where('id', $user_data['email_template_id'])
            ->get()->toArray();

        $template_data = isset($template_data[0]) && !empty($template_data[0]) ? $template_data[0] : '';

        if ($template_data) {

            $message_set = $template_data->content;
            $this->name = $name = $user_data['name'];
            $this->to = $user_data['to'];
            $this->subject = $template_data->subject; //$user_input["subject"];


            // Getting Emails
            $signature = \DB::table('email_settings')
                ->where('id', 1)
                ->get()->toArray();
            $signature = isset($signature[0]) && !empty($signature[0]) ? $signature[0] : '';
            $signature = $signature->set_val;


            $message = '<html><body><table cellspacing="0" cellpadding="0" border="0"  width="100%">
    <tbody>
        <tr>
            <td>
                <div >
                    <table cellspacing="0" cellpadding="0" border="0" style="height:auto !important; margin:0; padding:0; width:100% !important; background-color:#f0f0f0;color:#222222; font-family:arial, helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;">
                                        <table  width="100%" cellspacing="0" cellpadding="0" border="0" align="center"  style="background-color:#ffffff; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #5191bd">
                                            <tbody><tr>
                                                    <td width="100%">
                                                        <table cellspacing="0" cellpadding="20" border="0" bgcolor="#FFF" width="100%">
                                                            <tbody><tr>
                                                                    <td bgcolor="#FFF" width="100%" style="text-align:left;">
                                                                      
                                                                        <p>
                                                                            Hi ' . $name . ',                    
                                                                        </p>
                                                                        <br>
                                                                      ' . $message_set . '
                                                                        <br>

                                                                        ' . $signature . '
                                                                        
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>

                                                        <table cellspacing="0" cellpadding="10" border="0" bgcolor="#F0F0F0" width="100%" style="border-top:2px solid #f0f0f0;margin-top:10px;border-bottom:3px solid #2489b3">
                                                            <tbody><tr>
                                                                    <td bgcolor="#ffffff" width="100%" style="text-align:center;">
                                                                        <p style="color:#222222; font-family:arial, helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
                                                                            

                                                                        </p>
                                                                        
                                                                       ' . $str . '
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table> 




                </div></td></tr></tbody></table></body></html>';


            $data = [
                'content' => $message
            ];



          //  $this->to = filter_var($this->to, FILTER_SANITIZE_EMAIL);
           
       
                
            
                       if (filter_var($this->to, FILTER_VALIDATE_EMAIL)) {
                 
                   
                    
                    
                         try {
                                \Mail::send(['html' => 'mail'], $data, function ($message) {
                                    $message->to($this->to, $this->name)->subject
                                    ($this->subject);
                                });
                            } catch (\Exception $e) {
                    
                         
                        
                               \Log::useFiles(storage_path() . '/logs/invalid-emails-list-cron.log');
                               \Log::info("==============================");
                               \Log::info($this->to);
                               \Log::info($e->getMessage());
                        
                            }
                    
                    
                       } 
            
            
            
 
          

        }


        return TRUE;
    }


}
