<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\AdminResetPasswordNotification;
use App\Notifications\StoryPublishedNotification;

class Admin extends Authenticatable
{
    use Notifiable;


    protected $table = 'backend_user';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'created_timestamp', 'updated_timestamp', 'avatar', 'settings_string'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }


    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * Update Setting String
     *
     * @param  string $token
     * @return void
     */
    public function updateSettingsString($id, $data)
    {


        /*Getting User Data From ID to update setting_string*/
        $updateRecord = Admin::find($id);


        $settingData = [];


        if (isset($updateRecord->settings_string) && !empty($updateRecord->settings_string)) {
            $settingData = $updateRecord->settings_string;
            $settingData = (\GuzzleHttp\json_decode($settingData, true));
        }


        /* Update List View*/
        if (isset($data['ListView'])):

            if (!isset($settingData['ListView']) || empty($settingData['ListView'])) {
                $settingData['ListView'] = $data['ListView'];
            } else {
                $settingData['ListView'][key($data['ListView'])] = $data['ListView'][key($data['ListView'])];
            }
        endif;


        /* Update Custom List Column View*/
        if (isset($data['CustomList'])):


            if (!isset($settingData['CustomList'][$data['CustomList']['route']]) || empty($settingData['CustomList'][$data['CustomList']['route']])) {
                $settingData['CustomList'][$data['CustomList']['route']] = [];
            }

            //echo $data['CustomList']['colNo'];

            $settingData['CustomList'][$data['CustomList']['route']][$data['CustomList']['colNo']] = $data['CustomList']['visible'];


            // dd($settingData);

        endif;


        //unset($settingData['CustomList'][$data['CustomList']]);


        $settingData = (\GuzzleHttp\json_encode($settingData));
        $updateRecord->settings_string = $settingData;
        $updateRecord->updated_timestamp = time();

        return $updateRecord->save();


    }
    public function blogcomment()
    {
        return $this->hasMany('App\Models\BlogComment', 'user_id', 'user_id');
    }

}
