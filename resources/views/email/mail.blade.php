<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
                <title>Respmail is a response HTML email designed to work on all major email platforms and smartphones</title>
                <style type="text/css">
                    /* RESET STYLES */
                    html { background-color:#E1E1E1; margin:0; padding:0; }
                    body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
                    table{border-collapse:collapse;}
                    table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
                    img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
                    a {text-decoration:none !important;border-bottom: 1px solid;}
                    h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}


                    .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
                    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} 
                    table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} 
                    #outlook a{padding:0;} 
                    img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} 
                    body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} 
                    .ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} 

                    /* ========== Page Styles ========== */
                    h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
                    h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
                    h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
                    h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
                    .flexibleImage{height:auto;}
                    .linkRemoveBorder{border-bottom:0 !important;}
                    table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}

                    body, #bodyTable{background-color:#E1E1E1;}
                    #emailHeader{background-color:#E1E1E1;}
                    #emailBody{background-color:#FFFFFF;}
                    #emailFooter{background-color:#E1E1E1;}
                    .nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
                    .emailButton{background-color:#205478; border-collapse:separate;}
                    .buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
                    .buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
                    .emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
                    .emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
                    .emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
                    .imageContentText {margin-top: 10px;line-height:0;}
                    .imageContentText a {line-height:0;}
                    #invisibleIntroduction {display:none !important;} 


                    span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} 
                    span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
                    span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}

                    .zmPCnt a[href] {
                        color: #efac29!important;
                        cursor: pointer;
                    }

                    .a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
                    .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}


                    /* MOBILE STYLES */
                    @media only screen and (max-width: 480px){
                        /*////// CLIENT-SPECIFIC STYLES //////*/
                        body{width:100% !important; min-width:100% !important;} 
                        table[id="emailHeader"],
                        table[id="emailBody"],
                        table[id="emailFooter"],
                        table[class="flexibleContainer"],
                        td[class="flexibleContainerCell"] {width:100% !important;}
                        td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}

                        td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
                        img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
                        img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}



                        table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}


                        table[class="emailButton"]{width:100% !important;}
                        td[class="buttonContent"]{padding:0 !important;}
                        td[class="buttonContent"] a{padding:15px !important;}

                    }



                    @media only screen and (-webkit-device-pixel-ratio:.75){
                        /* Put CSS for low density (ldpi) Android layouts in here */
                    }

                    @media only screen and (-webkit-device-pixel-ratio:1){
                        /* Put CSS for medium density (mdpi) Android layouts in here */
                    }

                    @media only screen and (-webkit-device-pixel-ratio:1.5){
                        /* Put CSS for high density (hdpi) Android layouts in here */
                    }

                    /*=====================================================*/
                    @media only screen and (min-device-width : 320px) and (max-device-width:568px) {

                    }
                    /* end IOS targeting */
                </style>

                </head>
                <body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">


                    <center style="background-color:#E1E1E1;">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                            <tr>
                                <td align="center" valign="top" id="bodyCell">

                                    <table  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody" style="background-color: #262c36">

                                        <!-- MODULE ROW // -->

                                        <tr>
                                            <td align="center" valign="top">

                                                <table cellspacing="0" cellpadding="0" width="500"  style="background-color: #1a4262;">
                                                    <tr>
                                                        <td align="center" style="padding: 20px 10px" >
                                                            <img src="{{asset('assets/app/images/logo.png')}}" style=" display:block;width:200px;">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->


                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="500">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"  bgcolor="#FFFFFF">
                                                                <tr>
                                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%" >
                                                                            <tr>
                                                                                <td align="center" valign="top">

                                                                                    <!-- CONTENT TABLE // -->
                                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" >
                                                                                        <tr>
                                                                                            <td  class="textContent" style="color:#000000;line-height: 20px;">
                                                                                                <p>Hi ,</p>
                                                                                                {!!$content!!}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <!-- // CONTENT TABLE -->

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->


                                        <!-- MODULE ROW // -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="500"  bgcolor="#FFFFFF">
                                                    <tr style="padding-top:0;">
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
                                                                <tr>
                                                                    <td style="padding-top:0;" align="center" valign="top" width="500" >
                                                                        @if($link != null)
                                                                        <!-- CONTENT TABLE // -->
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color:#FFFFFF" >
                                                                            <tr>
                                                                                <td align="center" valign="middle" class="buttonContent" style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;">

                                                                                    <a style="background-color:#202833;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:180px;-webkit-text-size-adjust:none;" href="{{$link}}" target="_blank">Click Here</a>

                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        @endif
                                                                        <!-- // CONTENT TABLE -->

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-top:0;color:#363636" align="left" valign="top" width="500" >
                                                                        <br/>
                                                                        Thanks,<br/>
                                                                        <strong>StoryStar Team</strong>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>
                                        <!-- // MODULE ROW -->	

                                    </table>
                                    <!-- // END -->

                                    <!-- EMAIL FOOTER // -->

                                    <table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">

                                        <!-- FOOTER ROW // -->

                                        <tr>
                                            <td align="center" valign="top">
                                                <!-- CENTERING TABLE // -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <!-- FLEXIBLE CONTAINER // -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="flexibleContainer">
                                                                <tr>
                                                                    <td align="center" valign="top" width="100%" class="flexibleContainerCell">
                                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                            <tr>
                                                                                <td valign="top" bgcolor="#363636" style="padding:20px" >
                                                                                    <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:rgb(213, 213, 213);text-align:center;line-height:120%;">

                                                                                        <div>Email : <a href="mailto:info@story-star.com"  style="color:rgb(239, 173, 40)" target="_blank">info@storystar.com</a></div>                                                                                                    
                                                                                        <div style="padding-top:5px">Phone : 1234567890</div>
                                                                                        <div style="padding-top:5px">Copyright © 2020 <span style="color:rgb(239, 173, 40)">storystar</span>. All rights reserved.</div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <!-- // FLEXIBLE CONTAINER -->
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // CENTERING TABLE -->
                                            </td>
                                        </tr>

                                    </table>
                                    <!-- // END -->

                                </td>
                            </tr>
                        </table>
                    </center>
                </body>
                </html>