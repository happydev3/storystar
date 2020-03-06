<?php
use App\Models\Admin;
use App\Models\Apps;

function assets($path, $secure = null)
{
    return app('url')->asset("/assets/admin/" . $path, $secure) . "?v=0.0.2";
}

function app_assets($path, $secure = null)
{
    return app('url')->asset("/assets/app/" . $path, $secure) . "?v=0.0.2";
}


function avatar_url($path, $secure = null)
{
    return app('url')->asset("/assets/admin/uploads/avatars/" . $path, $secure);
}

function storage_url($path, $folder = "", $secure = null)
{
    return app('url')->asset("/storage/$folder/" . $path, $secure);
}

function icon_url($path, $secure = null)
{
    return app('url')->asset("/assets/admin/uploads/app_icons/" . $path, $secure);
}

function flag_url($path, $secure = null)
{
    return app('url')->asset("/resources/uploads/flags/" . $path, $secure);
}

function timezone_list()
{
    $zones_array = array();
    $timestamp = time();

    $zones_array[''] = 'Please select user timezone';

    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        //$zones_array[$key]['zone'] = $zone;
        //$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        $zones_array[$zone] = '(UTC/GMT ' . date('P', $timestamp) . ") $zone";
    }

    return $zones_array;
}

function getDateFormat()
{
    return 'd-m-Y h:i a';
}

function my_date($dateTime, $format = '', $zone = '')
{

    if (!$dateTime):
        return '';
    endif;

    if ($format == '') {
        $format = getDateFormat();
    }
    if ($zone == '') {

        $sessionZone = 'GMT';
        $loginUserDetails = Admin::Find(auth()->user()->user_id)->toArray();

        if ($loginUserDetails) {
            if ($loginUserDetails['timezone'])
                $sessionZone = $loginUserDetails['timezone'];
        }

        $date = new \DateTime('@' . $dateTime);
        $date->setTimezone(new \DateTimeZone($sessionZone));
        return $DateTimeR = $date->format($format);

    } else {


        $date = new \DateTime('@' . $dateTime);
        $date->setTimezone(new \DateTimeZone($zone));
        return $DateTimeR = $date->format($format);
    }
}

function getCurrentTimeStamp($DateTime = '', $Format = '', $zoneFrom = '')
{
    $oldZone = date_default_timezone_get();
    if ($Format == '') {
        $Format = getDateFormat();
    }
    if ($zoneFrom == '') {
        $zoneFrom = 'UTC';
    }

    if ($DateTime != '') {
        $date = new \DateTime($DateTime, new \DateTimeZone($zoneFrom));
        $date->setTimezone(new \DateTimeZone("UTC"));
        $DateTimeR = $date->format('Y-m-d H:i:s');
        date_default_timezone_set("UTC");
        $date = strtotime($DateTimeR);
    } else {
        date_default_timezone_set("UTC");
        $date = strtotime('now');
    }
    date_default_timezone_set($oldZone);
    return $date;
}

function getIcon($Icon, $Name = '')
{

    if ($Icon):
        return '<img src="' . Image::url(icon_url($Icon), 50, 50, array('crop')) . '" class=""/>';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(50)->toBase64() . '" class=""/>';
    endif;

}


function getStoryImage($Icon, $Name = '')
{

    if ($Icon):
        return '<img src="' . Image::url(storage_url($Icon, "story"), 100, 100, array('crop')) . '" class="" />';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(100)->toBase64() . '" class=""/>';
    endif;

}

function getFlag($Flag)
{

    if ($Flag):
        return '<img src="' . Image::url(flag_url($Flag), 70, 50, array('crop')) . '" class=""/>';
    else:
        return '<img src="' . Image::url(assets("img/default.png"), 70, 50, array('crop')) . '" class=""/>';
    endif;

}

function getSetting($params = '', $LoggedUser = '')
{

    if (!$LoggedUser)
        $LoggedUser = \Auth::user();


    if ($LoggedUser) {
        $SettingStr = $LoggedUser->settings_string;

        if (isset($SettingStr) && !empty($SettingStr)):
            $SettingStr = json_decode($SettingStr, true);

            if ($params):
                return isset($SettingStr[$params]) ? $SettingStr[$params] : '';
            else:
                return $SettingStr;
            endif;
        endif;
    }


}

function yesNoValue($fieldValue = '')
{
    if ($fieldValue) {
        if ($fieldValue == "Yes")
            return "1";
        else
            return 0;
    } else {
        return 0;
    }
}

function yesNoValueInv($fieldValue = '')
{
    if ($fieldValue == 1)
        return "Yes";
    else
        return "No";
}

function getAvatar($Avatar, $Name = '')
{

    if ($Avatar):
        return '<img src="' . Image::url(avatar_url($Avatar), 50, 50, array('crop')) . '" url="' . avatar_url($Avatar) . '" class="online openImage"/>';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(50)->toBase64() . '" class="online"/>';
    endif;

}

function getUserAvatar($Avatar, $Name = '')
{
    if ($Avatar):
        return '<img src="' . Image::url(storage_url($Avatar, 'users'), 50, 50, array('crop')) . '" url="' . avatar_url($Avatar) . '" class="online openImage"/>';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(50)->toBase64() . '" class="online"/>';
    endif;

}

function getStar($Img, $Name = '')
{

    if ($Img):
        return '<img src="' . Image::url(storage_url($Img, "stars"), 50, 50, array('crop')) . '" url="' . storage_url($Img) . '" class=" openImage"/>';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(50)->toBase64() . '" class="online"/>';
    endif;

}

function getTheme($Img, $Name = '')
{

    if ($Img):
        return '<img src="' . Image::url(storage_url($Img, 'themes'), 50, 50, array('crop')) . '" url="' . storage_url($Img) . '" class="online openImage"/>';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(50)->toBase64() . '" class="online"/>';
    endif;

}


function getStoryImg($Img, $Name = '')
{

    if ($Img):
        return '<img src="' . Image::url(storage_url($Img, 'story'), 50, 50, array('crop')) . '" url="' . storage_url($Img, 'story') . '" class="online openImage"/>';
    else:
        return '<img src="' . Avatar::create($Name)->setDimension(50)->toBase64() . '" class=""/>';
    endif;

}

function NewGuid()
{
    $s = strtoupper(md5(uniqid(rand(), true)));
    $guidText =
        substr($s, 0, 8) . '-' .
        substr($s, 8, 4) . '-' .
        substr($s, 12, 4) . '-' .
        substr($s, 16, 4) . '-' .
        substr($s, 20);
    return $guidText;
}

function breakWord($words, $key = 1)
{
    if ($words) {
        return str_slug(explode(" ", $words)[$key]);
    }

}

function getYears()
{
    $years = [];
    $Startyear = date('Y');
    $endYear = $Startyear - 217;
    $yearArray = range($Startyear, $endYear);
    sort($yearArray);
    foreach ($yearArray as $y) {
        $years[$y] = $y;
    }
    return $years;
}

function getGender()
{
    return ['Male' => "Male", "Female" => "Female"];
}

function getAdsPages()
{
    return ['stories' => "Stories", "publish story" => "Publish Story"];
}

function getCountries()
{
    return array
    (
        'United States' => 'United States',
        'Afghanistan' => 'Afghanistan',
        'Aland Islands' => 'Aland Islands',
        'Albania' => 'Albania',
        'Algeria' => 'Algeria',
        'American Samoa' => 'American Samoa',
        'Andorra' => 'Andorra',
        'Angola' => 'Angola',
        'Anguilla' => 'Anguilla',
        'Antarctica' => 'Antarctica',
        'Antigua And Barbuda' => 'Antigua And Barbuda',
        'Argentina' => 'Argentina',
        'Armenia' => 'Armenia',
        'Aruba' => 'Aruba',
        'Australia' => 'Australia',
        'Austria' => 'Austria',
        'Azerbaijan' => 'Azerbaijan',
        'Bahamas' => 'Bahamas',
        'Bahrain' => 'Bahrain',
        'Bangladesh' => 'Bangladesh',
        'Barbados' => 'Barbados',
        'Belarus' => 'Belarus',
        'Belgium' => 'Belgium',
        'Belize' => 'Belize',
        'Benin' => 'Benin',
        'Bermuda' => 'Bermuda',
        'Bhutan' => 'Bhutan',
        'Bolivia' => 'Bolivia',
        'Bosnia And Herzegovina' => 'Bosnia And Herzegovina',
        'Botswana' => 'Botswana',
        'Bouvet Island' => 'Bouvet Island',
        'Brazil' => 'Brazil',
        'British Indian Ocean Territory' => 'British Indian Ocean Territory',
        'Brunei Darussalam' => 'Brunei Darussalam',
        'Bulgaria' => 'Bulgaria',
        'Burkina Faso' => 'Burkina Faso',
        'Burundi' => 'Burundi',
        'Cambodia' => 'Cambodia',
        'Cameroon' => 'Cameroon',
        'Canada' => 'Canada',
        'Cape Verde' => 'Cape Verde',
        'Cayman Islands' => 'Cayman Islands',
        'Central African Republic' => 'Central African Republic',
        'Chad' => 'Chad',
        'Chile' => 'Chile',
        'China' => 'China',
        'Christmas Island' => 'Christmas Island',
        'Cocos (Keeling) Islands' => 'Cocos (Keeling) Islands',
        'Colombia' => 'Colombia',
        'Comoros' => 'Comoros',
        'Congo' => 'Congo',
        'Congo Democratic Republic' => 'Congo, Democratic Republic',
        'Cook Islands' => 'Cook Islands',
        'Costa Rica' => 'Costa Rica',
        'Cote D\'Ivoire' => 'Cote D\'Ivoire',
        'Croatia' => 'Croatia',
        'Cuba' => 'Cuba',
        'Cyprus' => 'Cyprus',
        'Czech Republic' => 'Czech Republic',
        'Denmark' => 'Denmark',
        'Djibouti' => 'Djibouti',
        'Dominica' => 'Dominica',
        'Dominican Republic' => 'Dominican Republic',
        'Ecuador' => 'Ecuador',
        'Egypt' => 'Egypt',
        'El Salvador' => 'El Salvador',
        'Equatorial Guinea' => 'Equatorial Guinea',
        'Eritrea' => 'Eritrea',
        'Estonia' => 'Estonia',
        'Ethiopia' => 'Ethiopia',
        'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)',
        'Faroe Islands' => 'Faroe Islands',
        'Fiji' => 'Fiji',
        'Finland' => 'Finland',
        'France' => 'France',
        'French Guiana' => 'French Guiana',
        'French Polynesia' => 'French Polynesia',
        'French Southern Territories' => 'French Southern Territories',
        'Gabon' => 'Gabon',
        'Gambia' => 'Gambia',
        'Georgia' => 'Georgia',
        'Germany' => 'Germany',
        'Ghana' => 'Ghana',
        'Gibraltar' => 'Gibraltar',
        'Greece' => 'Greece',
        'Greenland' => 'Greenland',
        'Grenada' => 'Grenada',
        'Guadeloupe' => 'Guadeloupe',
        'Guam' => 'Guam',
        'Guatemala' => 'Guatemala',
        'Guernsey' => 'Guernsey',
        'Guinea' => 'Guinea',
        'Guinea-Bissau' => 'Guinea-Bissau',
        'Guyana' => 'Guyana',
        'Haiti' => 'Haiti',
        'Heard Island & Mcdonald Islands' => 'Heard Island & Mcdonald Islands',
        'Holy See (Vatican City State)' => 'Holy See (Vatican City State)',
        'Honduras' => 'Honduras',
        'Hong Kong' => 'Hong Kong',
        'Hungary' => 'Hungary',
        'Iceland' => 'Iceland',
        'India' => 'India',
        'Indonesia' => 'Indonesia',
        'Iran Islamic Republic Of' => 'Iran, Islamic Republic Of',
        'Iraq' => 'Iraq',
        'Ireland' => 'Ireland',
        'Isle Of Man' => 'Isle Of Man',
        'Israel' => 'Israel',
        'Italy' => 'Italy',
        'Jamaica' => 'Jamaica',
        'Japan' => 'Japan',
        'Jersey' => 'Jersey',
        'Jordan' => 'Jordan',
        'Kazakhstan' => 'Kazakhstan',
        'Kenya' => 'Kenya',
        'Kiribati' => 'Kiribati',
        'Korea' => 'Korea',
        'Kuwait' => 'Kuwait',
        'Kyrgyzstan' => 'Kyrgyzstan',
        'Lao People\'s Democratic Republic' => 'Lao People\'s Democratic Republic',
        'Latvia' => 'Latvia',
        'Lebanon' => 'Lebanon',
        'Lesotho' => 'Lesotho',
        'Liberia' => 'Liberia',
        'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya',
        'Liechtenstein' => 'Liechtenstein',
        'Lithuania' => 'Lithuania',
        'Luxembourg' => 'Luxembourg',
        'Macao' => 'Macao',
        'Macedonia' => 'Macedonia',
        'Madagascar' => 'Madagascar',
        'Malawi' => 'Malawi',
        'Malaysia' => 'Malaysia',
        'Maldives' => 'Maldives',
        'Mali' => 'Mali',
        'Malta' => 'Malta',
        'Marshall Islands' => 'Marshall Islands',
        'Martinique' => 'Martinique',
        'Mauritania' => 'Mauritania',
        'Mauritius' => 'Mauritius',
        'Mayotte' => 'Mayotte',
        'Mexico' => 'Mexico',
        'Micronesia Federated States Of' => 'Micronesia, Federated States Of',
        'Moldova' => 'Moldova',
        'Monaco' => 'Monaco',
        'Mongolia' => 'Mongolia',
        'Montenegro' => 'Montenegro',
        'Montserrat' => 'Montserrat',
        'Morocco' => 'Morocco',
        'Mozambique' => 'Mozambique',
        'Myanmar' => 'Myanmar',
        'Namibia' => 'Namibia',
        'Nauru' => 'Nauru',
        'Nepal' => 'Nepal',
        'Netherlands' => 'Netherlands',
        'Netherlands Antilles' => 'Netherlands Antilles',
        'New Caledonia' => 'New Caledonia',
        'New Zealand' => 'New Zealand',
        'Nicaragua' => 'Nicaragua',
        'Niger' => 'Niger',
        'Nigeria' => 'Nigeria',
        'Niue' => 'Niue',
        'Norfolk Island' => 'Norfolk Island',
        'Northern Mariana Islands' => 'Northern Mariana Islands',
        'Norway' => 'Norway',
        'Oman' => 'Oman',
        'Pakistan' => 'Pakistan',
        'Palau' => 'Palau',
        'Palestinian Territory Occupied' => 'Palestinian Territory, Occupied',
        'Panama' => 'Panama',
        'Papua New Guinea' => 'Papua New Guinea',
        'Paraguay' => 'Paraguay',
        'Peru' => 'Peru',
        'Philippines' => 'Philippines',
        'Pitcairn' => 'Pitcairn',
        'Poland' => 'Poland',
        'Portugal' => 'Portugal',
        'Puerto Rico' => 'Puerto Rico',
        'Qatar' => 'Qatar',
        'Reunion' => 'Reunion',
        'Romania' => 'Romania',
        'Russian Federation' => 'Russian Federation',
        'Rwanda' => 'Rwanda',
        'Saint Barthelemy' => 'Saint Barthelemy',
        'Saint Helena' => 'Saint Helena',
        'Saint Kitts And Nevis' => 'Saint Kitts And Nevis',
        'Saint Lucia' => 'Saint Lucia',
        'Saint Martin' => 'Saint Martin',
        'Saint Pierre And Miquelon' => 'Saint Pierre And Miquelon',
        'Saint Vincent And Grenadines' => 'Saint Vincent And Grenadines',
        'Samoa' => 'Samoa',
        'San Marino' => 'San Marino',
        'Sao Tome And Principe' => 'Sao Tome And Principe',
        'Saudi Arabia' => 'Saudi Arabia',
        'Senegal' => 'Senegal',
        'Serbia' => 'Serbia',
        'Seychelles' => 'Seychelles',
        'Sierra Leone' => 'Sierra Leone',
        'Singapore' => 'Singapore',
        'Slovakia' => 'Slovakia',
        'Slovenia' => 'Slovenia',
        'Solomon Islands' => 'Solomon Islands',
        'Somalia' => 'Somalia',
        'South Africa' => 'South Africa',
        'South Georgia And Sandwich Isl.' => 'South Georgia And Sandwich Isl.',
        'Spain' => 'Spain',
        'Sri Lanka' => 'Sri Lanka',
        'Sudan' => 'Sudan',
        'Suriname' => 'Suriname',
        'Svalbard And Jan Mayen' => 'Svalbard And Jan Mayen',
        'Swaziland' => 'Swaziland',
        'Sweden' => 'Sweden',
        'Switzerland' => 'Switzerland',
        'Syrian Arab Republic' => 'Syrian Arab Republic',
        'Taiwan' => 'Taiwan',
        'Tajikistan' => 'Tajikistan',
        'Tanzania' => 'Tanzania',
        'Thailand' => 'Thailand',
        'Timor-Leste' => 'Timor-Leste',
        'Togo' => 'Togo',
        'Tokelau' => 'Tokelau',
        'Tonga' => 'Tonga',
        'Trinidad And Tobago' => 'Trinidad And Tobago',
        'Tunisia' => 'Tunisia',
        'Turkey' => 'Turkey',
        'Turkmenistan' => 'Turkmenistan',
        'Turks And Caicos Islands' => 'Turks And Caicos Islands',
        'Tuvalu' => 'Tuvalu',
        'Uganda' => 'Uganda',
        'Ukraine' => 'Ukraine',
        'United Arab Emirates' => 'United Arab Emirates',
        'United Kingdom' => 'United Kingdom',
        'United States Outlying Islands' => 'United States Outlying Islands',
        'Uruguay' => 'Uruguay',
        'Uzbekistan' => 'Uzbekistan',
        'Vanuatu' => 'Vanuatu',
        'Venezuela' => 'Venezuela',
        'Viet Nam' => 'Viet Nam',
        'Virgin Islands British' => 'Virgin Islands, British',
        'Virgin Islands U.S.' => 'Virgin Islands, U.S.',
        'Wallis And Futuna' => 'Wallis And Futuna',
        'Western Sahara' => 'Western Sahara',
        'Yemen' => 'Yemen',
        'Zambia' => 'Zambia',
        'Zimbabwe' => 'Zimbabwe',
    );
}

function getClassicLink()
{
    $classicsTheme = [];
    $classicsTheme = App\Models\Theme::where("theme_id", "=", "41")->get()->toArray();
    return isset($classicsTheme[0]) ? $classicsTheme[0] : '';
}

function getNovelsLink()
{
    $novelSubject = [];
    //$novelSubject = App\Models\Subject::where("subject_id", "=", "164")->get()->toArray();
    $novelSubject = App\Models\Subject::where("subject_id", "=", "177")->get()->toArray();
    return isset($novelSubject[0]) ? $novelSubject[0] : '';

}

function getCategories()
{
    $categories = $list = [];
    $categories = App\Models\Category::get()->toArray();
    $list = array_combine(array_column($categories, 'category_id'), array_column($categories, 'category_title'));
    return $list;
}

function getSubCategories($title = "sub_category_title")
{
    $categories = $list = [];
    $categories = App\Models\SubCategory::get()->toArray();
    $list = array_combine(array_column($categories, 'sub_category_id'), array_column($categories, $title));
    return $list;
}

function getStoryStarType()
{
    return ['Day' => 'Day', "Week" => "Week"];
}

function removeBR($description)
{

    //$description = str_replace("&nbsp; ", " ", $description);
    $description = trim($description);
    return str_replace("<br />", " ", $description);
}

function decodeStr($data)
{
    if (is_array($data)) {

        $newData = [];
        foreach ($data As $k => $d) {
            $newData[$k] = htmlspecialchars_decode(html_entity_decode($d));
        }
        return $newData;
    } else
        return htmlspecialchars_decode(html_entity_decode($data));
}

function replaceSlashWithAnd($description)
{
    return str_replace("/", "and", $description);
}


function convertLinks($content)
{

    $str = "";
    $content = str_replace("<BR>", "", $content);


    $content = explode("\n", $content);
    $content = array_filter($content, 'trim'); // remove any extra \r characters left behind

    foreach ($content as $line) {

        if (strpos($line, ";")) {
            $array = explode(";", $line, 2);
            $text = isset($array[0]) && !empty($array[0]) ? $array[0] : '';
            $link = isset($array[1]) && !empty($array[1]) ? $array[1] : '';

            $str .= "<a target='_blank' href='" . $link . "'>$text</a><br/>";


        } else {
            $str .= "<br/>" . $line . "<br/>";
        }


    }


    return $str;


}


//Update users Set story_count  = (SELECT Count(0) FROM stories WHERE stories.user_id = users.user_id) WHERE users.user_id = users.user_id


//  \DB::connection($slug)->enableQueryLog();
//dd(Input::except('_method', '_token'));
//print_r(
//    \DB::connection($slug)->getQueryLog()
//);

// update story_ratings sr set sr.average_rate =(((sr.r1 * 1)+(sr.r2 * 2)+(sr.r3 * 3)+(sr.r4 * 4)+ (sr.r5 * 5)) /(sr.r1+sr.r2+sr.r3+sr.r4+sr.r5)) WHERE sr.story_id = sr.story_id;

// update story_ratings sr set sr.total_rate =sr.r1+sr.r2+sr.r3+sr.r4+sr.r5 WHERE sr.story_id = sr.story_id;


//update stories sr
//set sr.updated_timestamp =UNIX_TIMESTAMP(sr.post_date)
//WHERE sr.story_id = sr.story_id;


//Update stories SET story_code = "" WHERE story_id in (
//    SELECT story_id FROM (
//    SELECT count(*), story_title,story_id,story_code
//FROM stories
//GROUP BY story_title
//HAVING COUNT(*) > 1) as TABL)

//
//SELECT story_id,status,story_title,theme_id FROM stories WHERE
//FIND_IN_SET(story_id, '111,116,2657,104,3214,2893,2871,1165,1589,2851,2877,2980,2955,3079,2649,3016,2745,1563,3082,1954,1572,3681,3314,3038,2845,2741,1718,9423,7783,3287,3148,6078,4472,3044,6145,3061,12449,10986,5842,5649,4455,3842,3523,3864,14083,9402,8939,5410,4382,3755,3502,3275,13463,12230,7277,7260,7012,6855,6415,5889,5382,4250,4202,3759,14667,14584,13412,13409,13108,12826,12784,12747,12660,11727,11007,10987,10348,10225,8938,8625,7518,7452,7409,7305,7108,6677,6541,6391,6235,6156,5378,4684,4601,3952,3940,3891,3517,14298,14095,13328,13314,13291,12652,11969,11653,11467,11022,10983,10662,10372,9522,9506,8468,8049,7728,7641,7174,6971,6741,6720,6199,5652,5644,5582,5442,4927,4827,4752,4660,4617,4436,4320,4056,3973,3928,3706,2490,2491,14812,14787,14759,14752,14689,14466,14351,14331,14315,14204,14112,14094,14100,13976,13811,13778,13761,13744,13728,13680,13638,13598,13393,13081,13047,12908,12797,12526,12486,12478,10984,10912,10764,10641,10624,10378,10315,10074,9594,9597,9539,9516,9261,9186,9155,9035,8983,8509,8459,8412,8067,7952,7918,7635,7163,7053,6708,6540,6418,6419,6399,6395,6359,6340,6278,6256,6238,6214,6170,5928,5801,5659,5515,5353,5327,4992,4906,4860,4675,4344,4179,4066,4071,3701,14808,14792,14751,14687,14676,14588,14563,14549,14524,14462,14418,14403,14385,14286,14269,14266,14218,14120,14048,14040,14013,13926,13922,13887,13884,13859,13846,13836,13837,13801,13702,13695,13113,12884,12053,11451,11415,11276,11211,10275,10083,10062,10046,9557,9351,9138,8636,8525,8209,8011,7689,7419,7236,6786,6416,6408,6279,6268,6148,5631,5488,5328,3471,2,2832,2842,2844,2383,105,118,1832,10829,2822,109,71,54,1783,77,3048,2883,2350,85,35,1156,3085,2819,1281,1745,12620,9887,3114,2983,2495,1858,3493,3437,3192,2235,2161,2067,10478,6152,3150,2598,2542,1748,1747,1562,3635,3337,2237,3599,3482,3377,3339,2974,8208,6154,3802,3544,3291,2458,2433,10830,9598,3899,3613,3400,3389,3293,2225,12569,12509,10828,10455,10067,8058,6518,6052,4558,4025,4015,3975,3968,3811,3660,13713,13513,13103,12630,12610,12052,11724,11403,10512,9888,8315,8040,8035,7148,6850,6846,6062,5821,5786,5705,5203,5000,4505,4471,4047,3991,3969,3651,3632,3601,3568,3550,3414,3399,3332,2291,2293,14607,14493,14352,14184,13939,13842,12574,12539,12505,12497,12476,12355,12311,11035,10579,10561,10387,10086,9629,9631,9610,9555,9559,9511,9455,9318,9238,8904,8885,8849,8553,8516,8268,8223,8153,8036,8023,7915,7883,7503,7262,7249,7151,7120,6985,6948,6400,6331,6313,5955,5944,5905,5754,5685,5354,5243,5057,5019,4935,4912,4835,4652,4587,4570,4549,4550,4528,4217,4067,3710,3583,3375,14694,14519,14301,14288,14157,14028,13942,13930,13841,13788,13766,13647,13597,13528,13531,13395,13322,13121,12749,12726,12599,12571,12308,12149,12033,12032,11974,11921,11872,11808,11593,11520,11471,11128,11089,10963,10840,10614,10452,10377,10172,10154,10106,10099,9967,9781,9776,9711,9609,9595,9584,9523,9505,9474,9459,9413,9352,9125,9122,9104,8999,8775,8749,8729,8702,8634,8322,8061,8000,7966,7642,7433,6980,6937,6930,6847,6774,6747,6749,6586,6513,6489,6371,6204,6117,5991,5946,5856,5753,5737,5699,5639,5641,5392,5250,5192,5177,5079,10403,4958,4871,4836,4822,4761,4697,4578,4556,4414,4364,4360,4233,4154,4070,4061,4013,3538,14844,14839,14828,14750,14746,14638,14630,14620,14419,14347,14180,14140,14122,14090,14091,14092,14093,14033,13966,13915,13903,13857,13790,13777,13524,13358,13349,13265,13155,13104,13105,13100,13065,13052,13028,13029,13031,13020,13007,12989,12966,12968,12973,12944,12927,12882,12869,12830,12786,12776,12736,12713,12699,12683,12655,12629,12617,12596,12483,12475,12458,12394,12347,12256,12240,12062,12068,12054,12028,11951,11827,11824,11792,11735,11723,11722,11726,11681,11677,11670,11663,11659,11652,11637,11603,11563,11551,11552,11554,11526,11519,11436,11439,11422,11398,11328,11266,11241,11242,11203,11157,11151,11092,11102,11012,10650,10408,10324,10264,10170,10166,10155,10149,10129,10130,9528,9515,9490,9452,9272,9004,8940,8899,8878,8844,8759,8755,8629,8527,8285,8134,8066,8055,7885,7755,7668,7422,7286,7246,6768,6579,6537,6354,6089,5949,5904,5806,5729,5732,5718,5684,5640,5618,5607,5588,5562,5542,5418,5323,5316,5289,5212,5204,5163,5113,5096,4867,4799,4760,4719,4657,4167,4168,4169,4080,4012,3812,100,70,40,2935,92,78,30,2780,1335,2003,2196,1493,2760,1565,12582,10826,2579,2168,2165,5365,12626,12480,8295,5894,3958,3563,3398,3391,3378,3368,3347,3328,3326,2300,12608,10818,10721,9329,8890,8332,7500,7353,6491,5342,4780,3990,3621,3455,3303,14668,14657,13609,13474,13405,13352,13209,13189,13141,13051,12773,12762,12601,12556,12456,12415,12357,12331,12251,11918,11861,11853,11843,11707,11686,11493,10572,10521,10177,10084,9879,9427,9426,9420,8893,8677,8593,8367,8240,8234,8162,8136,8122,7510,6794,6784,6607,6446,6294,6246,6230,6231,6127,6118,5669,5572,5555,5433,4682,4654,4542,4381,4274,3949,3906,3889,3880,3771,3686,3579,3376,3302,14153,14109,13992,13981,13743,13431,13261,13159,13140,12831,12793,12540,12359,12207,12090,12034,11690,11604,11402,11141,10949,10899,10675,10599,10409,10284,10253,10122,10078,9905,9884,9874,9861,9801,9770,9733,9663,9651,9644,9606,9262,8821,7869,7832,7516,7512,7354,7085,6642,6564,6348,6335,6292,6242,6205,6142,6091,6092,6025,5970,5865,5635,5583,5277,5214,5161,4897,4888,4862,4843,4838,4828,4740,4741,4702,4462,4422,4161,4027,4022,4018,3989,3879,3850,3709,3612,3608,3590,3421,3422,3423,3424,3425,3426,14848,14845,14818,14810,14672,14632,14590,14426,14415,14417,14378,14374,14349,14340,14299,14277,14257,14235,14194,14187,14178,14155,14156,14079,13997,13998,13999,13990,13924,13829,13768,13758,13749,13696,13635,13468,13453,13438,13308,13212,13109,13091,13085,13045,13034,13038,13021,13014,12975,12937,12925,12931,12888,12856,12827,12798,12738,12716,12640,12635,12631,12607,12575,12471,12422,12337,12313,12253,12239,12140,12099,12093,12038,12011,12016,11985,11893,11831,11769,11705,11650,11530,11514,11423,11305,11247,11246,11186,11144,11116,11099,11090,11095,10940,10919,10922,10880,10794,10780,10696,10672,10611,10604,10558,10474,10381,10310,10312,10303,10173,10098,10080,10076,10081,10068,9992,9989,9946,9917,9856,9831,9807,9696,9698,9683,9674,9638,9637,9622,9625,9615,9586,9587,9588,9590,9600,9499,9501,9403,9405,9388,9297,9290,9250,9115,9110,9080,9069,9072,9073,8984,8975,8954,8874,8864,8780,8711,8667,8546,8537,8473,8465,8174,8143,8113,8102,8085,7836,7818,7821,7802,7771,7753,7737,7681,7663,7497,7242,7211,7202,7192,7082,7071,6979,6983,6927,6849,6844,6731,6689,6655,6615,6554,6542,6519,6305,6207,6210,6181,6157,6129,6048,6011,6007,5953,5900,5873,5877,5746,5727,5724,5721,5717,5720,5599,5592,5386,5251,5258,5217,5166,5045,4943,4926,4895,4826,4823,4809,4792,4788,4774,4735,4731,4720,4705,4701,4653,4648,4645,4636,4595,4530,4413,4163,4009,3984,3697,3604,3420,3416,2102,3392,3371,3304,13935,3396,3386,2324,13210,11995,11956,10827,9778,9376,7866,6317,6032,5419,5027,4894,4435,3501,3409,14103,13772,13543,13456,13451,13295,13218,13213,12035,11575,11477,11173,11187,10402,10132,10047,7790,7221,6664,6447,5201,5144,4961,4175,3609,3494,3417,3390,14779,14622,14369,14279,14202,14114,14104,14102,14089,14049,14018,13673,13656,13641,13639,13633,13472,13325,13165,13035,13036,13024,12943,12785,12721,12533,12390,12267,12170,11958,11892,11809,11800,11269,10937,10845,10843,10755,10410,10262,10038,10013,9969,9665,9366,9354,9191,8621,8274,8256,8016,7991,7766,7483,7440,6873,6811,6812,6608,6595,6261,6249,6219,6216,6184,4368,4308,4262,3751,3610,3573,3546,3536,3453,4400,11870,14113,13323,9327,8902,7343,7212,14819,14813,14797,14765,14731,14701,14641,14619,14427,14061,13952,13858,13853,13592,13560,13496,13452,13305,13226,13224,12479,12375,12354,12315,12210,11971,11919,11896,11802,11464,11238,10143,10079,10054,10042,9970,9860,9849,9681,9541,9381,9096,9008,9000,8990,8891,8824,8643,8595,8417,8291,8276,8206,8170,8020,7977,7979,7982,7967,7957,7960,7938,7931,7932,7890,7849,7856,7819,7820,7796,7475,7413,7297,7227,7229,7172,7111,6938,6912,6907,6876,6797,6783,6703,6195,6177,6180,5887,5846,5805,5694,5688,5664,5646,5627,5593,5596,5482,5363,5322,5191,5179,5139,5101,5021,4994,4949,4896,4890,3890')
//AND
//story_id NOT IN (
//    select `stories`.story_id from `stories`
//left join `users` on `users`.`user_id` = `stories`.`user_id` and `users`.`deleted_at` is null and `active` = 'Active'
//left join `story_ratings` on `story_ratings`.`story_id` = `stories`.`story_id`
//inner join `story_themes` on `story_themes`.`story_id` = `stories`.`story_id`
//where `status` = 'Active' and (`story_themes`.`theme_id` = 2)
//and `stories`.`deleted_at` is null group by `stories`.`story_title`, `stories`.`author_name`
//order by `stories`.`story_id` desc )


//
//update users SET is_profile_complete = 0 WHERE user_id>0;
//
//update users SET avatar = '' WHERE avatar is null;
//
//update users SET profile = '' WHERE profile is null;
//
//update users SET is_profile_complete = 1 WHERE avatar !='';
//
//update users SET is_profile_complete = 1 WHERE profile !='';
?>