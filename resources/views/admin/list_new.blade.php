@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-table fa-fw "></i>
                    {!! $pageData['MainHeading'] or '' !!}
                    <span>
                         List
                    </span>
                </h1>

            </div>

            @if(\Request::route()->getName() =="admin-story-star-list")
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <a href="<?=route("admin-stories-list")?>"
                       class="btn bg-color-darken btn-xl pull-right header-btn hidden-mobile" style="color: #FFF;">
                        <i class="fa fa-circle-arrow-up fa-lg"></i> Search Story
                    </a>
                </div>
            @endif

            @if(\Request::route()->getName() =="admin-comments-list")
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <a href="<?=route('admin-stories-edit', \Request::route()->story_id);?>"
                       class="btn bg-color-darken btn-xl pull-right header-btn hidden-mobile" style="color: #FFF;">
                        <i class="fa fa-circle-arrow-up fa-lg"></i> Back to Edit Story
                    </a>
                </div>
            @endif

        </div>

        @if(\Request::route()->getName() =="admin-story-star-list")
            @include('admin.storystar-list')
        @endif

        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    @include('admin.components.notification-messages')

                    <div class="jarviswidget jarviswidget-color-blueDark"
                         id="wid-id-1"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-editbutton="false"
                         data-widget-grid="false"
                         data-widget-colorbutton="false"
                         data-widget-sortable="false"
                    >
                        <header>
                            <div class="jarviswidget-ctrls" role="menu"></div>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>List </h2>

                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">

                                <form method="GET" class="smart-form" action="">
                                    <fieldset>
                                        <legend>Story Advanced Filter</legend>

                                        <div id="filters">
                                            <div class="row">

                                                <input type="hidden" class="form-control" name="advance-stories-filter"
                                                       value="1">

                                                <section class="col col-4">
                                                    <label class="input">
                                                        <input class="form-control" name="author" id="author"
                                                               placeholder="Author"
                                                               value="{{\Illuminate\Support\Facades\Input::get('author')}}">
                                                        <b class="tooltip tooltip-top-right">
                                                            <i class="fa fa-terminal txt-color-teal"></i>
                                                            Search with author name.
                                                        </b>
                                                        <i class="icon-append fa fa-terminal"></i>
                                                    </label>
                                                </section>

                                                <section class="col col-4">
                                                    <label class="input">
                                                        <input class="form-control" name="s" id="s"
                                                               placeholder="Keyword"
                                                               value="{{\Illuminate\Support\Facades\Input::get('s')}}">

                                                        <b class="tooltip tooltip-top-right">
                                                            <i class="fa fa-terminal txt-color-teal"></i>
                                                            Search with keyword in title.
                                                        </b>

                                                        <i class="icon-append fa fa-terminal"></i>

                                                    </label>
                                                </section>

                                                <section class="col col-4">
                                                    <label class="input">
                                                        <input class="form-control" name="state" id="state"
                                                               placeholder="City/Address"
                                                               value="{{\Illuminate\Support\Facades\Input::get('state')}}">

                                                        <b class="tooltip tooltip-top-right">
                                                            <i class="fa fa-terminal txt-color-teal"></i>
                                                            Search with author's city/address.
                                                        </b>
                                                        <i class="icon-append fa fa-terminal"></i>

                                                    </label>
                                                </section>
                                            </div>
                                            <div class="row">
                                                <section class="col col-2">
                                                    <label class="input">
                                                        <select class="form-control" name="theme" id="theme">
                                                            <option value="">All Themes</option>
                                                            @foreach(\App\Models\Subject::orderBy('subject_title')->get() as $theme)
                                                                <option
                                                                    value="{{$theme->theme_id}}" {{\Illuminate\Support\Facades\Input::get('theme')==$theme->theme_id?'selected':''}}>{{$theme->theme_title}}</option>
                                                            @endforeach
                                                        </select>

                                                    </label>
                                                </section>

                                                <section class="col col-2">
                                                    <label class="input">
                                                        <select class="form-control" name="subject" id="subject">
                                                            <option value="">All Subjects</option>
                                                            @foreach(\App\Models\Subject::all() as $theme)
                                                                <option
                                                                    value="{{$theme->subject_id}}" {{\Illuminate\Support\Facades\Input::get('subject')==$theme->subject_id?'selected':''}}>{{$theme->subject_title}}</option>
                                                            @endforeach
                                                        </select>

                                                    </label>
                                                </section>

                                                <section class="col col-2">
                                                    <label class="input">

                                                        <select class="form-control" name="category" id="category">
                                                            <option value="">All Categories</option>
                                                            @foreach(\App\Models\Category::all() as $theme)
                                                                <option
                                                                    value="{{$theme->category_id}}" {{\Illuminate\Support\Facades\Input::get('category')==$theme->category_id?'selected':''}}>{{$theme->category_title}}</option>
                                                            @endforeach
                                                        </select>
                                                        <i></i>

                                                    </label>
                                                </section>

                                                <section class="col col-2">
                                                    <label class="input">

                                                        <select class="form-control" name="subcategory"
                                                                id="subcategory">
                                                            <option value="">All Subcategories</option>

                                                            <option
                                                                value="1" {{\Illuminate\Support\Facades\Input::get('subcategory')==1?'selected':''}}>
                                                                Kids
                                                            </option>

                                                            <option
                                                                value="2" {{\Illuminate\Support\Facades\Input::get('subcategory')==2?'selected':''}}>
                                                                Teens
                                                            </option>

                                                            <option
                                                                value="3" {{\Illuminate\Support\Facades\Input::get('subcategory')==3?'selected':''}}>
                                                                Adults
                                                            </option>

                                                        </select>
                                                        <i></i>

                                                    </label>
                                                </section>

                                                <section class="col col-2">
                                                    <label class="input">
                                                        <select class="form-control" value="test" name="country"
                                                                id="country">
                                                            @if (\Illuminate\Support\Facades\Input::get('country')!==null)
                                                                <option
                                                                    value="{{\Illuminate\Support\Facades\Input::get('country')}}"
                                                                    disabled
                                                                    selected>{{\Illuminate\Support\Facades\Input::get('country')}}</option>
                                                            @endif
                                                            <option value="">All Countries</option>
                                                            <option value="United States">
                                                                United States
                                                            </option>
                                                            <option value="Afghanistan">
                                                                Afghanistan
                                                            </option>
                                                            <option value="Aland Islands">
                                                                Aland Islands
                                                            </option>
                                                            <option value="Albania">
                                                                Albania
                                                            </option>
                                                            <option value="Algeria">
                                                                Algeria
                                                            </option>
                                                            <option value="American Samoa">
                                                                American Samoa
                                                            </option>
                                                            <option value="Andorra">
                                                                Andorra
                                                            </option>
                                                            <option value="Angola">
                                                                Angola
                                                            </option>
                                                            <option value="Anguilla">
                                                                Anguilla
                                                            </option>
                                                            <option value="Antarctica">
                                                                Antarctica
                                                            </option>
                                                            <option value="Antigua And Barbuda">
                                                                Antigua And Barbuda
                                                            </option>
                                                            <option value="Argentina">
                                                                Argentina
                                                            </option>
                                                            <option value="Armenia">
                                                                Armenia
                                                            </option>
                                                            <option value="Aruba">
                                                                Aruba
                                                            </option>
                                                            <option value="Australia">
                                                                Australia
                                                            </option>
                                                            <option value="Austria">
                                                                Austria
                                                            </option>
                                                            <option value="Azerbaijan">
                                                                Azerbaijan
                                                            </option>
                                                            <option value="Bahamas">
                                                                Bahamas
                                                            </option>
                                                            <option value="Bahrain">
                                                                Bahrain
                                                            </option>
                                                            <option value="Bangladesh">
                                                                Bangladesh
                                                            </option>
                                                            <option value="Barbados">
                                                                Barbados
                                                            </option>
                                                            <option value="Belarus">
                                                                Belarus
                                                            </option>
                                                            <option value="Belgium">
                                                                Belgium
                                                            </option>
                                                            <option value="Belize">
                                                                Belize
                                                            </option>
                                                            <option value="Benin">
                                                                Benin
                                                            </option>
                                                            <option value="Bermuda">
                                                                Bermuda
                                                            </option>
                                                            <option value="Bhutan">
                                                                Bhutan
                                                            </option>
                                                            <option value="Bolivia">
                                                                Bolivia
                                                            </option>
                                                            <option value="Bosnia And Herzegovina">
                                                                Bosnia And Herzegovina
                                                            </option>
                                                            <option value="Botswana">
                                                                Botswana
                                                            </option>
                                                            <option value="Bouvet Island">
                                                                Bouvet Island
                                                            </option>
                                                            <option value="Brazil">
                                                                Brazil
                                                            </option>
                                                            <option value="British Indian Ocean Territory">
                                                                British Indian Ocean Territory
                                                            </option>
                                                            <option value="Brunei Darussalam">
                                                                Brunei Darussalam
                                                            </option>
                                                            <option value="Bulgaria">
                                                                Bulgaria
                                                            </option>
                                                            <option value="Burkina Faso">
                                                                Burkina Faso
                                                            </option>
                                                            <option value="Burundi">
                                                                Burundi
                                                            </option>
                                                            <option value="Cambodia">
                                                                Cambodia
                                                            </option>
                                                            <option value="Cameroon">
                                                                Cameroon
                                                            </option>
                                                            <option value="Canada">
                                                                Canada
                                                            </option>
                                                            <option value="Cape Verde">
                                                                Cape Verde
                                                            </option>
                                                            <option value="Cayman Islands">
                                                                Cayman Islands
                                                            </option>
                                                            <option value="Central African Republic">
                                                                Central African Republic
                                                            </option>
                                                            <option value="Chad">
                                                                Chad
                                                            </option>
                                                            <option value="Chile">
                                                                Chile
                                                            </option>
                                                            <option value="China">
                                                                China
                                                            </option>
                                                            <option value="Christmas Island">
                                                                Christmas Island
                                                            </option>
                                                            <option value="Cocos (Keeling) Islands">
                                                                Cocos (Keeling) Islands
                                                            </option>
                                                            <option value="Colombia">
                                                                Colombia
                                                            </option>
                                                            <option value="Comoros">
                                                                Comoros
                                                            </option>
                                                            <option value="Congo">
                                                                Congo
                                                            </option>
                                                            <option value="Congo Democratic Republic">
                                                                Congo Democratic Republic
                                                            </option>
                                                            <option value="Cook Islands">
                                                                Cook Islands
                                                            </option>
                                                            <option value="Costa Rica">
                                                                Costa Rica
                                                            </option>
                                                            <option value="Cote D'Ivoire">
                                                                Cote D'Ivoire
                                                            </option>
                                                            <option value="Croatia">
                                                                Croatia
                                                            </option>
                                                            <option value="Cuba">
                                                                Cuba
                                                            </option>
                                                            <option value="Cyprus">
                                                                Cyprus
                                                            </option>
                                                            <option value="Czech Republic">
                                                                Czech Republic
                                                            </option>
                                                            <option value="Denmark">
                                                                Denmark
                                                            </option>
                                                            <option value="Djibouti">
                                                                Djibouti
                                                            </option>
                                                            <option value="Dominica">
                                                                Dominica
                                                            </option>
                                                            <option value="Dominican Republic">
                                                                Dominican Republic
                                                            </option>
                                                            <option value="Ecuador">
                                                                Ecuador
                                                            </option>
                                                            <option value="Egypt">
                                                                Egypt
                                                            </option>
                                                            <option value="El Salvador">
                                                                El Salvador
                                                            </option>
                                                            <option value="Equatorial Guinea">
                                                                Equatorial Guinea
                                                            </option>
                                                            <option value="Eritrea">
                                                                Eritrea
                                                            </option>
                                                            <option value="Estonia">
                                                                Estonia
                                                            </option>
                                                            <option value="Ethiopia">
                                                                Ethiopia
                                                            </option>
                                                            <option value="Falkland Islands (Malvinas)">
                                                                Falkland Islands (Malvinas)
                                                            </option>
                                                            <option value="Faroe Islands">
                                                                Faroe Islands
                                                            </option>
                                                            <option value="Fiji">
                                                                Fiji
                                                            </option>
                                                            <option value="Finland">
                                                                Finland
                                                            </option>
                                                            <option value="France">
                                                                France
                                                            </option>
                                                            <option value="French Guiana">
                                                                French Guiana
                                                            </option>
                                                            <option value="French Polynesia">
                                                                French Polynesia
                                                            </option>
                                                            <option value="French Southern Territories">
                                                                French Southern Territories
                                                            </option>
                                                            <option value="Gabon">
                                                                Gabon
                                                            </option>
                                                            <option value="Gambia">
                                                                Gambia
                                                            </option>
                                                            <option value="Georgia">
                                                                Georgia
                                                            </option>
                                                            <option value="Germany">
                                                                Germany
                                                            </option>
                                                            <option value="Ghana">
                                                                Ghana
                                                            </option>
                                                            <option value="Gibraltar">
                                                                Gibraltar
                                                            </option>
                                                            <option value="Greece">
                                                                Greece
                                                            </option>
                                                            <option value="Greenland">
                                                                Greenland
                                                            </option>
                                                            <option value="Grenada">
                                                                Grenada
                                                            </option>
                                                            <option value="Guadeloupe">
                                                                Guadeloupe
                                                            </option>
                                                            <option value="Guam">
                                                                Guam
                                                            </option>
                                                            <option value="Guatemala">
                                                                Guatemala
                                                            </option>
                                                            <option value="Guernsey">
                                                                Guernsey
                                                            </option>
                                                            <option value="Guinea">
                                                                Guinea
                                                            </option>
                                                            <option value="Guinea-Bissau">
                                                                Guinea-Bissau
                                                            </option>
                                                            <option value="Guyana">
                                                                Guyana
                                                            </option>
                                                            <option value="Haiti">
                                                                Haiti
                                                            </option>
                                                            <option value="Heard Island &amp; Mcdonald Islands">
                                                                Heard Island &amp; Mcdonald Islands
                                                            </option>
                                                            <option value="Holy See (Vatican City State)">
                                                                Holy See (Vatican City State)
                                                            </option>
                                                            <option value="Honduras">
                                                                Honduras
                                                            </option>
                                                            <option value="Hong Kong">
                                                                Hong Kong
                                                            </option>
                                                            <option value="Hungary">
                                                                Hungary
                                                            </option>
                                                            <option value="Iceland">
                                                                Iceland
                                                            </option>
                                                            <option value="India">
                                                                India
                                                            </option>
                                                            <option value="Indonesia">
                                                                Indonesia
                                                            </option>
                                                            <option value="Iran Islamic Republic Of">
                                                                Iran Islamic Republic Of
                                                            </option>
                                                            <option value="Iraq">
                                                                Iraq
                                                            </option>
                                                            <option value="Ireland">
                                                                Ireland
                                                            </option>
                                                            <option value="Isle Of Man">
                                                                Isle Of Man
                                                            </option>
                                                            <option value="Israel">
                                                                Israel
                                                            </option>
                                                            <option value="Italy">
                                                                Italy
                                                            </option>
                                                            <option value="Jamaica">
                                                                Jamaica
                                                            </option>
                                                            <option value="Japan">
                                                                Japan
                                                            </option>
                                                            <option value="Jersey">
                                                                Jersey
                                                            </option>
                                                            <option value="Jordan">
                                                                Jordan
                                                            </option>
                                                            <option value="Kazakhstan">
                                                                Kazakhstan
                                                            </option>
                                                            <option value="Kenya">
                                                                Kenya
                                                            </option>
                                                            <option value="Kiribati">
                                                                Kiribati
                                                            </option>
                                                            <option value="Korea">
                                                                Korea
                                                            </option>
                                                            <option value="Kuwait">
                                                                Kuwait
                                                            </option>
                                                            <option value="Kyrgyzstan">
                                                                Kyrgyzstan
                                                            </option>
                                                            <option value="Lao People's Democratic Republic">
                                                                Lao People's Democratic Republic
                                                            </option>
                                                            <option value="Latvia">
                                                                Latvia
                                                            </option>
                                                            <option value="Lebanon">
                                                                Lebanon
                                                            </option>
                                                            <option value="Lesotho">
                                                                Lesotho
                                                            </option>
                                                            <option value="Liberia">
                                                                Liberia
                                                            </option>
                                                            <option value="Libyan Arab Jamahiriya">
                                                                Libyan Arab Jamahiriya
                                                            </option>
                                                            <option value="Liechtenstein">
                                                                Liechtenstein
                                                            </option>
                                                            <option value="Lithuania">
                                                                Lithuania
                                                            </option>
                                                            <option value="Luxembourg">
                                                                Luxembourg
                                                            </option>
                                                            <option value="Macao">
                                                                Macao
                                                            </option>
                                                            <option value="Macedonia">
                                                                Macedonia
                                                            </option>
                                                            <option value="Madagascar">
                                                                Madagascar
                                                            </option>
                                                            <option value="Malawi">
                                                                Malawi
                                                            </option>
                                                            <option value="Malaysia">
                                                                Malaysia
                                                            </option>
                                                            <option value="Maldives">
                                                                Maldives
                                                            </option>
                                                            <option value="Mali">
                                                                Mali
                                                            </option>
                                                            <option value="Malta">
                                                                Malta
                                                            </option>
                                                            <option value="Marshall Islands">
                                                                Marshall Islands
                                                            </option>
                                                            <option value="Martinique">
                                                                Martinique
                                                            </option>
                                                            <option value="Mauritania">
                                                                Mauritania
                                                            </option>
                                                            <option value="Mauritius">
                                                                Mauritius
                                                            </option>
                                                            <option value="Mayotte">
                                                                Mayotte
                                                            </option>
                                                            <option value="Mexico">
                                                                Mexico
                                                            </option>
                                                            <option value="Micronesia Federated States Of">
                                                                Micronesia Federated States Of
                                                            </option>
                                                            <option value="Moldova">
                                                                Moldova
                                                            </option>
                                                            <option value="Monaco">
                                                                Monaco
                                                            </option>
                                                            <option value="Mongolia">
                                                                Mongolia
                                                            </option>
                                                            <option value="Montenegro">
                                                                Montenegro
                                                            </option>
                                                            <option value="Montserrat">
                                                                Montserrat
                                                            </option>
                                                            <option value="Morocco">
                                                                Morocco
                                                            </option>
                                                            <option value="Mozambique">
                                                                Mozambique
                                                            </option>
                                                            <option value="Myanmar">
                                                                Myanmar
                                                            </option>
                                                            <option value="Namibia">
                                                                Namibia
                                                            </option>
                                                            <option value="Nauru">
                                                                Nauru
                                                            </option>
                                                            <option value="Nepal">
                                                                Nepal
                                                            </option>
                                                            <option value="Netherlands">
                                                                Netherlands
                                                            </option>
                                                            <option value="Netherlands Antilles">
                                                                Netherlands Antilles
                                                            </option>
                                                            <option value="New Caledonia">
                                                                New Caledonia
                                                            </option>
                                                            <option value="New Zealand">
                                                                New Zealand
                                                            </option>
                                                            <option value="Nicaragua">
                                                                Nicaragua
                                                            </option>
                                                            <option value="Niger">
                                                                Niger
                                                            </option>
                                                            <option value="Nigeria">
                                                                Nigeria
                                                            </option>
                                                            <option value="Niue">
                                                                Niue
                                                            </option>
                                                            <option value="Norfolk Island">
                                                                Norfolk Island
                                                            </option>
                                                            <option value="Northern Mariana Islands">
                                                                Northern Mariana Islands
                                                            </option>
                                                            <option value="Norway">
                                                                Norway
                                                            </option>
                                                            <option value="Oman">
                                                                Oman
                                                            </option>
                                                            <option value="Pakistan">
                                                                Pakistan
                                                            </option>
                                                            <option value="Palau">
                                                                Palau
                                                            </option>
                                                            <option value="Palestinian Territory Occupied">
                                                                Palestinian Territory Occupied
                                                            </option>
                                                            <option value="Panama">
                                                                Panama
                                                            </option>
                                                            <option value="Papua New Guinea">
                                                                Papua New Guinea
                                                            </option>
                                                            <option value="Paraguay">
                                                                Paraguay
                                                            </option>
                                                            <option value="Peru">
                                                                Peru
                                                            </option>
                                                            <option value="Philippines">
                                                                Philippines
                                                            </option>
                                                            <option value="Pitcairn">
                                                                Pitcairn
                                                            </option>
                                                            <option value="Poland">
                                                                Poland
                                                            </option>
                                                            <option value="Portugal">
                                                                Portugal
                                                            </option>
                                                            <option value="Puerto Rico">
                                                                Puerto Rico
                                                            </option>
                                                            <option value="Qatar">
                                                                Qatar
                                                            </option>
                                                            <option value="Reunion">
                                                                Reunion
                                                            </option>
                                                            <option value="Romania">
                                                                Romania
                                                            </option>
                                                            <option value="Russian Federation">
                                                                Russian Federation
                                                            </option>
                                                            <option value="Rwanda">
                                                                Rwanda
                                                            </option>
                                                            <option value="Saint Barthelemy">
                                                                Saint Barthelemy
                                                            </option>
                                                            <option value="Saint Helena">
                                                                Saint Helena
                                                            </option>
                                                            <option value="Saint Kitts And Nevis">
                                                                Saint Kitts And Nevis
                                                            </option>
                                                            <option value="Saint Lucia">
                                                                Saint Lucia
                                                            </option>
                                                            <option value="Saint Martin">
                                                                Saint Martin
                                                            </option>
                                                            <option value="Saint Pierre And Miquelon">
                                                                Saint Pierre And Miquelon
                                                            </option>
                                                            <option value="Saint Vincent And Grenadines">
                                                                Saint Vincent And Grenadines
                                                            </option>
                                                            <option value="Samoa">
                                                                Samoa
                                                            </option>
                                                            <option value="San Marino">
                                                                San Marino
                                                            </option>
                                                            <option value="Sao Tome And Principe">
                                                                Sao Tome And Principe
                                                            </option>
                                                            <option value="Saudi Arabia">
                                                                Saudi Arabia
                                                            </option>
                                                            <option value="Senegal">
                                                                Senegal
                                                            </option>
                                                            <option value="Serbia">
                                                                Serbia
                                                            </option>
                                                            <option value="Seychelles">
                                                                Seychelles
                                                            </option>
                                                            <option value="Sierra Leone">
                                                                Sierra Leone
                                                            </option>
                                                            <option value="Singapore">
                                                                Singapore
                                                            </option>
                                                            <option value="Slovakia">
                                                                Slovakia
                                                            </option>
                                                            <option value="Slovenia">
                                                                Slovenia
                                                            </option>
                                                            <option value="Solomon Islands">
                                                                Solomon Islands
                                                            </option>
                                                            <option value="Somalia">
                                                                Somalia
                                                            </option>
                                                            <option value="South Africa">
                                                                South Africa
                                                            </option>
                                                            <option value="South Georgia And Sandwich Isl.">
                                                                South Georgia And Sandwich Isl.
                                                            </option>
                                                            <option value="Spain">
                                                                Spain
                                                            </option>
                                                            <option value="Sri Lanka">
                                                                Sri Lanka
                                                            </option>
                                                            <option value="Sudan">
                                                                Sudan
                                                            </option>
                                                            <option value="Suriname">
                                                                Suriname
                                                            </option>
                                                            <option value="Svalbard And Jan Mayen">
                                                                Svalbard And Jan Mayen
                                                            </option>
                                                            <option value="Swaziland">
                                                                Swaziland
                                                            </option>
                                                            <option value="Sweden">
                                                                Sweden
                                                            </option>
                                                            <option value="Switzerland">
                                                                Switzerland
                                                            </option>
                                                            <option value="Syrian Arab Republic">
                                                                Syrian Arab Republic
                                                            </option>
                                                            <option value="Taiwan">
                                                                Taiwan
                                                            </option>
                                                            <option value="Tajikistan">
                                                                Tajikistan
                                                            </option>
                                                            <option value="Tanzania">
                                                                Tanzania
                                                            </option>
                                                            <option value="Thailand">
                                                                Thailand
                                                            </option>
                                                            <option value="Timor-Leste">
                                                                Timor-Leste
                                                            </option>
                                                            <option value="Togo">
                                                                Togo
                                                            </option>
                                                            <option value="Tokelau">
                                                                Tokelau
                                                            </option>
                                                            <option value="Tonga">
                                                                Tonga
                                                            </option>
                                                            <option value="Trinidad And Tobago">
                                                                Trinidad And Tobago
                                                            </option>
                                                            <option value="Tunisia">
                                                                Tunisia
                                                            </option>
                                                            <option value="Turkey">
                                                                Turkey
                                                            </option>
                                                            <option value="Turkmenistan">
                                                                Turkmenistan
                                                            </option>
                                                            <option value="Turks And Caicos Islands">
                                                                Turks And Caicos Islands
                                                            </option>
                                                            <option value="Tuvalu">
                                                                Tuvalu
                                                            </option>
                                                            <option value="Uganda">
                                                                Uganda
                                                            </option>
                                                            <option value="Ukraine">
                                                                Ukraine
                                                            </option>
                                                            <option value="United Arab Emirates">
                                                                United Arab Emirates
                                                            </option>
                                                            <option value="United Kingdom">
                                                                United Kingdom
                                                            </option>
                                                            <option value="United States Outlying Islands">
                                                                United States Outlying Islands
                                                            </option>
                                                            <option value="Uruguay">
                                                                Uruguay
                                                            </option>
                                                            <option value="Uzbekistan">
                                                                Uzbekistan
                                                            </option>
                                                            <option value="Vanuatu">
                                                                Vanuatu
                                                            </option>
                                                            <option value="Venezuela">
                                                                Venezuela
                                                            </option>
                                                            <option value="Viet Nam">
                                                                Viet Nam
                                                            </option>
                                                            <option value="Virgin Islands British">
                                                                Virgin Islands British
                                                            </option>
                                                            <option value="Virgin Islands U.S.">
                                                                Virgin Islands U.S.
                                                            </option>
                                                            <option value="Wallis And Futuna">
                                                                Wallis And Futuna
                                                            </option>
                                                            <option value="Western Sahara">
                                                                Western Sahara
                                                            </option>
                                                            <option value="Yemen">
                                                                Yemen
                                                            </option>
                                                            <option value="Zambia">
                                                                Zambia
                                                            </option>
                                                            <option value="Zimbabwe">
                                                                Zimbabwe
                                                            </option>
                                                        </select>
                                                        <i></i>

                                                    </label>
                                                </section>

                                                <section class="col col-2">
                                                    <label class="input">
                                                        <select name="gender" class="form-control" id="gender">
                                                            <option value="">Author's Gender</option>
                                                            <option
                                                                value="Male" {{\Illuminate\Support\Facades\Input::get('gender')=='Male'?'selected':''}}>
                                                                Male
                                                            </option>
                                                            <option
                                                                value="Female" {{\Illuminate\Support\Facades\Input::get('gender')=='Female'?'selected':''}}>
                                                                Female
                                                            </option>
                                                            <option
                                                                value="Unspecified" {{\Illuminate\Support\Facades\Input::get('gender')=='Unspecified'?'selected':''}}>
                                                                Unspecified
                                                            </option>

                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>


                                            </div>

                                            <div class="row hide">

                                                <section class="col col-1">
                                                    <label class="input">
                                                        <input name="month[filter]" class="form-control" value="Month"
                                                               readonly="" style="background: none">
                                                        <i></i>

                                                    </label>
                                                </section>
                                                <section class="col col-2">
                                                    <label class="input">
                                                        <select name="month[operator]" class="form-control">
                                                            <option value="">All</option>
                                                            <option value="c">Current Month</option>
                                                            <option value="e">Equal To (Month No)</option>
                                                            <option value="om">Older Than (Months)</option>
                                                            <option value="od">Older Than (Days)</option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>
                                                <section class="col col-4">
                                                    <label class="input">
                                                        <input class="form-control" name="month[value]"
                                                               placeholder="Enter search value">
                                                        <i class="icon-append fa fa-terminal"></i>

                                                    </label>
                                                </section>


                                            </div>
                                            <div class="row hide" id="StoryFilters">

                                                <section class="col col-1">
                                                    <label class="input">

                                                        <input name="search[filter][]" class="form-control" value="Rank"
                                                               readonly="" style="background: none">


                                                        <i></i>

                                                    </label>
                                                </section>
                                                <section class="col col-2">
                                                    <label class="select">
                                                        <select name="search[operator][]" class="form-control">
                                                            <option value="=">Equal to</option>
                                                            <option value="<">Less than</option>
                                                            <option value=">">Greater than</option>
                                                            <option value="<=">Less than equal to</option>
                                                            <option value=">=">Greater than equal to</option>
                                                            <option value="=!">Not equal to</option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>
                                                <section class="col col-4">
                                                    <label class="input">
                                                        <input class="form-control" name="search[value][]"
                                                               placeholder="Enter search value">
                                                        <i class="icon-append fa fa-terminal"></i>

                                                    </label>
                                                </section>

                                            </div>
                                            <div class="row hide" id="">

                                                <section class="col col-1">
                                                    <label class="input">

                                                        <input name="search[filter][]" class="form-control"
                                                               value="Views" readonly="" style="background: none">

                                                    </label>
                                                </section>
                                                <section class="col col-2">
                                                    <label class="select">
                                                        <select name="search[operator][]" class="form-control">
                                                            <option value="=">Equal to</option>
                                                            <option value="<">Less than</option>
                                                            <option value=">">Greater than</option>
                                                            <option value="<=">Less than equal to</option>
                                                            <option value=">=">Greater than equal to</option>
                                                            <option value="=!">Not equal to</option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>
                                                <section class="col col-4">
                                                    <label class="input">
                                                        <input class="form-control" name="search[value][]"
                                                               placeholder="Enter search value">
                                                        <i class="icon-append fa fa-terminal"></i>

                                                    </label>
                                                </section>
                                            </div>

                                            <div class="row" id="">
                                                <section class="col col-4">
                                                    <legend>Order By</legend>
                                                    <br>
                                                    <label class="input">
                                                        <select name="order_by" id="order_by" class="form-control">
                                                            <option
                                                                value="desc_id" {{\Illuminate\Support\Facades\Input::get('order_by')=='desc_id'?'selected':''}}>
                                                                Newest first
                                                            </option>
                                                            <option
                                                                value="asc_id" {{\Illuminate\Support\Facades\Input::get('order_by')=='asc_id'?'selected':''}}>
                                                                Oldest first
                                                            </option>
                                                            <option value="" disabled>--------</option>
                                                            <option
                                                                value="desc_votes" {{\Illuminate\Support\Facades\Input::get('order_by')=='desc_votes'?'selected':''}}>
                                                                Most votes
                                                            </option>
                                                            <option
                                                                value="asc_votes" {{\Illuminate\Support\Facades\Input::get('order_by')=='asc_votes'?'selected':''}}>
                                                                Least votes
                                                            </option>
                                                            <option value="" disabled>--------</option>
                                                            <option
                                                                value="desc_views" {{\Illuminate\Support\Facades\Input::get('order_by')=='desc_views'?'selected':''}}>
                                                                Most views
                                                            </option>
                                                            <option
                                                                value="asc_views" {{\Illuminate\Support\Facades\Input::get('order_by')=='asc_views'?'selected':''}}>
                                                                Least views
                                                            </option>

                                                            <option value="" disabled>--------</option>
                                                            <option
                                                                value="desc_nomi" {{\Illuminate\Support\Facades\Input::get('order_by')=='desc_nomi'?'selected':''}}>
                                                                Most nominations
                                                            </option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>

                                                <section class="col col-4">
                                                    <legend>Date range</legend>
                                                    <br>
                                                    <label class="input">
                                                        <select name="data_range" id="data_range" class="form-control">
                                                            <option value="">All time</option>
                                                            <option
                                                                value="7" {{\Illuminate\Support\Facades\Input::get('data_range')=='7'?'selected':''}}>
                                                                Last 7 days
                                                            </option>
                                                            <option
                                                                value="30" {{\Illuminate\Support\Facades\Input::get('data_range')=='30'?'selected':''}}>
                                                                Last 30 days
                                                            </option>
                                                            <option
                                                                value="90" {{\Illuminate\Support\Facades\Input::get('data_range')=='90'?'selected':''}}>
                                                                Last 90 days
                                                            </option>
                                                            <option
                                                                value="366" {{\Illuminate\Support\Facades\Input::get('data_range')=='366'?'selected':''}}>
                                                                Last 1 year
                                                            </option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>

                                                <section class="col col-4">
                                                    <legend>By rating</legend>
                                                    <br>
                                                    <label class="input">
                                                        <select name="rating" id="rating" class="form-control">
                                                            <option value="">Any rating</option>
                                                            <option
                                                                value="45" {{\Illuminate\Support\Facades\Input::get('rating')=='45'?'selected':''}}>
                                                                4.5-5.0 stars
                                                            </option>
                                                            <option
                                                                value="4" {{\Illuminate\Support\Facades\Input::get('rating')=='4'?'selected':''}}>
                                                                4.0-4.5 stars
                                                            </option>
                                                            <option
                                                                value="34" {{\Illuminate\Support\Facades\Input::get('rating')=='34'?'selected':''}}>
                                                                3.0-4.0 stars
                                                            </option>
                                                            <option
                                                                value="3" {{\Illuminate\Support\Facades\Input::get('rating')=='3'?'selected':''}}>
                                                                3.0 as bellow
                                                            </option>
                                                            <option
                                                                value="0" {{\Illuminate\Support\Facades\Input::get('rating')=='0'?'selected':''}}>
                                                                No votes
                                                            </option>
                                                        </select>
                                                        <i></i>
                                                    </label>
                                                </section>
                                            </div>


                                            <div class="row">

                                                <section class="col col-6">
                                                    <legend>Show Story Copies</legend>
                                                    <br>

                                                    <label class="input">
                                                        <select class="form-control" name="showCopies" id="showCopies">
                                                            <option value="Yes">
                                                                Yes
                                                            </option>
                                                            <option
                                                                value="No" {{\Illuminate\Support\Facades\Input::get('showCopies')=='No'?'selected':''}}>
                                                                No
                                                            </option>
                                                        </select>

                                                    </label>
                                                </section>

                                                <section class="col col-6">

                                                    <legend>Stories having comments</legend>
                                                    <br>
                                                    <label class="input">
                                                        <select class="form-control" name="havingComments"
                                                                id="havingComments">
                                                            <option value="">
                                                                All
                                                            </option>
                                                            <option
                                                                value="Yes" {{\Illuminate\Support\Facades\Input::get('havingComments')=='Yes'?'selected':''}}>
                                                                Yes
                                                            </option>
                                                            <option
                                                                value="No" {{\Illuminate\Support\Facades\Input::get('havingComments')=='No'?'selected':''}}>
                                                                No
                                                            </option>
                                                        </select>

                                                    </label>
                                                </section>


                                            </div>

                                            <div class="row">
                                                <section class="col col-6">
                                                    <legend>Stories per page</legend>
                                                    <br>
                                                    <select
                                                        name="paginator_length" aria-controls="Story_TBL"
                                                        class="form-control input-sm" id="paginator_select">
                                                        <option
                                                            value="15" {{\Illuminate\Support\Facades\Input::get('paginator_length')==15?'selected':''}}>
                                                            15
                                                        </option>
                                                        <option
                                                            value="30" {{\Illuminate\Support\Facades\Input::get('paginator_length')==30?'selected':''}}>
                                                            30
                                                        </option>
                                                        <option
                                                            value="60" {{\Illuminate\Support\Facades\Input::get('paginator_length')==60?'selected':''}}>
                                                            60
                                                        </option>
                                                        <option
                                                            value="120" {{\Illuminate\Support\Facades\Input::get('paginator_length')==120?'selected':''}}>
                                                            120
                                                        </option>
                                                        <option
                                                            value="150" {{\Illuminate\Support\Facades\Input::get('paginator_length')==150?'selected':''}}>
                                                            150
                                                        </option>
                                                        <option
                                                            value="300" {{\Illuminate\Support\Facades\Input::get('paginator_length')==300?'selected':''}}>
                                                            300
                                                        </option>
                                                    </select>
                                                </section>

                                                <section class="col col-6">
                                                    <legend>Search by Story ID</legend>
                                                    <br>
                                                    <label class="input">
                                                        <input class="form-control" name="story_id" id="story_id"
                                                               placeholder="Story ID"
                                                               value="{{\Illuminate\Support\Facades\Input::get('story_id')}}">

                                                        <b class="tooltip tooltip-top-right">
                                                            <i class="fa fa-terminal txt-color-teal"></i>
                                                            Search for Story ID
                                                        </b>
                                                        <i class="icon-append fa fa-terminal"></i>
                                                    </label>
                                                </section>
                                            </div>

                                            <div class="row">
                                                <section class="col col-md-4">
                                                    <legend>Author maximum age</legend>
                                                    <br>
                                                    <label class="input">
                                                        <input class="form-control" name="author_age" id="author_age"
                                                               placeholder="Maximum age"
                                                               value="{{\Illuminate\Support\Facades\Input::get('author_age')}}">
                                                        <b class="tooltip tooltip-top-right">
                                                            <i class="fa fa-terminal txt-color-teal"></i>
                                                            Author age
                                                        </b>
                                                        <i class="icon-append fa fa-terminal"></i>
                                                    </label>
                                                </section>

                                                <section class="col col-md-4">
                                                    <legend>Show classic shorts and novels</legend>
                                                    <br>
                                                    <select
                                                        name="classic_novels" aria-controls="Story_TBL"
                                                        class="form-control input-sm" id="classic_novels">
                                                        <option
                                                            value="0" {{\Illuminate\Support\Facades\Input::get('classic_novels')==0?'selected':''}}>
                                                            Yes
                                                        </option>
                                                        <option
                                                            value="1" {{\Illuminate\Support\Facades\Input::get('classic_novels')==1?'selected':''}}>
                                                            No
                                                        </option>
                                                    </select>
                                                </section>
                                            </div>


                                            <div class="row">
                                                <div id="filters-div"></div>
                                            </div>

                                        </div>


                                        <button id="searchBtn"
                                                class="btn bg-color-green txt-color-white btn-padding pull-right"
                                                type="submit">
                                            <i class="glyphicon glyphicon-filter"></i>
                                            Search
                                        </button>
                                        <a class="btn bg-color-red txt-color-white btn-padding pull-right"
                                           style="margin-bottom: 0px" href="{{route('admin-stories-clear')}}">
                                            <i class="glyphicon glyphicon-refresh"></i>
                                            Clear</a>
                                        {{--<button class="btn bg-color-red txt-color-white btn-padding" type="reset"--}}
                                        {{--id="clearFilters">--}}
                                        {{--<i class="glyphicon glyphicon-refresh"></i>--}}
                                        {{--Clear--}}
                                        {{--</button>--}}

                                    </fieldset>
                                    <br>
                                    <hr>
                                </form>
                                <div class="dt-toolbar">
                                    <table class="table table-striped table-bordered dataTable" id="Story_TBL"
                                           role="grid" aria-describedby="Story_TBL_info">
                                        <form method="POST" action="{{route('admin-stories-multidelete')}}" id="myForm">
                                            {{csrf_field()}}

                                            <thead>
                                            <tr role="row">
                                                <th class="text-center no-filter dt-checkboxes-select-all sorting_disabled"
                                                    width="50" tabindex="0" aria-controls="Story_TBL" rowspan="1"
                                                    colspan="1" data-col="0" style="width: 50px;" aria-label=""><input
                                                        type="checkbox" class="selectall"></th>
                                                <th class="text-center sorting" width="50" tabindex="0"
                                                    aria-controls="Story_TBL" rowspan="1" colspan="1"
                                                    style="width: 50px;"
                                                    aria-label="Story ID: activate to sort column ascending">Story ID
                                                </th>
                                                <th class="text-center sorting" width="60" tabindex="0"
                                                    aria-controls="Story_TBL" rowspan="1" colspan="1"
                                                    style="width: 60px;"
                                                    aria-label="Nominations: activate to sort column ascending">
                                                    Nominations
                                                </th>
                                                <th data-class="expand" class="no-filter sorting" width="700"
                                                    tabindex="0"
                                                    aria-controls="Story_TBL" rowspan="1" colspan="1"
                                                    style="width: 700px;"
                                                    aria-label="Story: activate to sort column ascending">Story
                                                </th>
                                                <th class="text-center sorting_disabled" width="140" rowspan="1"
                                                    colspan="1"
                                                    style="width: 140px;" aria-label="Action">Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tfoot></tfoot>
                                            <tbody>

                                            @foreach($stories as $story)
                                                <tr role="row" class="{{($loop->index+1)%2?'even':'odd'}}">
                                                    <td class=" text-center no-filter dt-checkboxes-cell">
                                                        <input type="checkbox" class="dt-checkboxes mdelete"
                                                               value="{{$story->story_id}}" name="delete[]">
                                                    </td>
                                                    {{--<td class="text-center sorting_1">{{$story->created_timestamp}}</td>--}}
                                                    <td class=" text-center">{{$story->story_id}}</td>
                                                    <td class=" text-center">{{$story->nominatedstories_count}}</td>
                                                    <td class=" no-filter"><span class="responsiveExpander"></span><b>
                                                            <a
                                                                href="{{route('admin-stories-detail',['id'=>$story->story_id])}}">{{$story->story_title}}</a></b>
                                                        by <span
                                                            style="color: #47588F">{{$story->author_name}}
                                                            (year:{{$story->author_dob}})</span><br>
                                                        <div class="product-deatil" style="padding: 5px 0 5px 0;">
                                                        <span class="fa fa-2x"><h5>
                                                                @if (isset($story->story_rating))
                                                                    @for($i=0;$i<round($story->story_rating->average_rate);$i++)
                                                                        <i class="fa fa-star fa-2x text-primary"
                                                                           style="color: #47588F"></i>
                                                                    @endfor
                                                                @endif
                                                                 ({{isset($story->story_rating)?number_format((float)$story->story_rating->average_rate, 1, '.', ''):''}})</h5></span>
                                                        </div>
                                                        Post date: {{my_date($story->created_timestamp, "Y-m-d")}} /
                                                        Views: {{$story->views}} {{isset($story->story_rating)?' / Votes: '.$story->story_rating->total_rate:' / Votes: 0 '}}
                                                        /
                                                        Country: {{$story->author_country}}{{isset($story->comment_count)?' / Comments: '.$story->comment_count:''}}
                                                        <br><br>This
                                                        story is listed
                                                        as: {{$story->category_id == 1? 'True Life':'Fiction'}}
                                                        for {{$story->subcategory->sub_category_title}} / <span
                                                            style="color: #47588F">Theme:</span>
                                                        {{$story->theme->theme_title}} / <span style="color: #47588F">Subject:</span> {{$story->subject->subject_title}}
                                                        <br><br>{{$story->short_description}}
                                                    </td>
                                                    <td class=" text-center"><a
                                                            href="{{route('admin-stories-edit',$story->story_id)}}"
                                                            class="btn btn-xs btn-primary" rel="tooltip"
                                                            data-placement="top"
                                                            data-original-title=""><i
                                                                class="glyphicon glyphicon-edit"></i>
                                                            Edit</a>
                                                        <a href="{{route('admin-stories-detail',$story->story_id)}}"
                                                           class="btn btn-xs bg-color-pink txt-color-white"
                                                           rel="tooltip"
                                                           data-placement="top" data-original-title=""><i
                                                                class="glyphicon glyphicon-th-list"></i> Detail</a>
                                                        <a href="{{route('admin-stories-delete',$story->story_id)}}"
                                                           class="btn btn-xs btn-danger txt-color-white"
                                                           onclick="return confirm('Are you sure?')"
                                                           rel="tooltip" data-placement="top" data-original-title=""><i
                                                                class="glyphicon glyphicon-remove"></i> Delete</a>
                                                        <a href="{{route('admin-story-star-addfromstories', ['story_id' => $story->story_id, 'type' => 'day'])}}"
                                                           class="btn btn-xs bg-color-orange txt-color-white"
                                                           rel="tooltip"
                                                           data-placement="top" data-original-title=""><i
                                                                class="glyphicon glyphicon-star"></i> Add stories Of Day
                                                        </a> <a
                                                            href="{{route('admin-story-star-addfromstories', ['story_id' => $story->story_id, 'type' => 'week'])}}"
                                                            class="btn btn-xs  bg-color-green txt-color-white"
                                                            rel="tooltip" data-placement="top" data-original-title=""><i
                                                                class="glyphicon glyphicon-star"></i> Add stories of
                                                            Week</a> <a
                                                            href="{{route('admin-story-star-addfromstories', ['story_id' => $story->story_id, 'type' => $story->category_id == 1 ? 'non' : 'fic'])}}"
                                                            class="btn btn-xs  bg-color-blueDark txt-color-white"
                                                            rel="tooltip" data-placement="top" data-original-title=""><i
                                                                class="glyphicon glyphicon-star"></i> {{$story->category_id == 1? 'True Life':'Fiction'}}
                                                            story of the week</a>
                                                            @if($story->subject_id == 177)
                                                            <a
                                                            href="{{route('admin-stories-make-novel-to-story',$story->story_id)}}"
                                                            class="btn btn-xs btn-primary"
                                                            rel="tooltip" data-placement="top" data-original-title=""><i
                                                                class="glyphicon glyphicon-check"></i> Change Novel to Story </a>
                                                            @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <button id="submitDelete" disabled style="padding: 5px !important;" type="submit" class="btn btn-xs btn-danger txt-color-white"><i class="glyphicon glyphicon-remove"></i> Delete selected</button>
                                        </form>
                                    </table>

                                    <script>
                                        $(document).ready(function () {
                                            console.log("ready!");

                                            $('.selectall').on('click', function () {
                                                if ($(this).prop("checked")) {
                                                    $(".mdelete").each(function (index) {
                                                        $(this).prop( "checked", true );
                                                        $("#submitDelete").prop( "disabled", false );
                                                    });
                                                } else{
                                                    $(".mdelete").each(function (index) {
                                                        $(this).prop( "checked", false );
                                                        $("#submitDelete").prop( "disabled", true );
                                                    });
                                                }

                                                $('.mdelete').on('click', function () {
                                                    if ($('.mdelete').filter(':checked').length>0){
                                                        $("#submitDelete").prop( "disabled", false );
                                                    } else {
                                                        $("#submitDelete").prop( "disabled", true );
                                                    }
                                                });
                                            });
                                            $('.mdelete').on('click', function () {
                                                if ($('.mdelete').filter(':checked').length>0){
                                                    $("#submitDelete").prop( "disabled", false );
                                                } else {
                                                    $("#submitDelete").prop( "disabled", true );
                                                }
                                            });

                                            $('#myForm').submit(function() {
                                                var c = confirm("Do you want to delete all selected stories?");
                                                return c; //you can just return c because it will be true or false
                                            });
                                        });
                                    </script>

                                    <div class="dt-toolbar-footer">
                                        <div class="col-sm-6 col-xs-12 hidden-xs">
                                            <div class="dataTables_info" id="Story_TBL_info" role="status"
                                                 aria-live="polite">
                                                Showing {{(($stories->currentPage()-1)*$stories->perPage())+1}}
                                                to {{$stories->currentPage()*$stories->perPage()}}
                                                of {{$stories->total()}} stories
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                 id="Story_TBL_paginate">
                                                {{--<ul class="pagination">--}}
                                                {{--<li class="paginate_button previous disabled"--}}
                                                {{--id="Story_TBL_previous"><a href="#" aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="0"--}}
                                                {{--tabindex="0">Previous</a></li>--}}
                                                {{--<li class="paginate_button active"><a href="#"--}}
                                                {{--aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="1"--}}
                                                {{--tabindex="0">1</a></li>--}}
                                                {{--<li class="paginate_button "><a href="#" aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="2" tabindex="0">2</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="paginate_button "><a href="#" aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="3" tabindex="0">3</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="paginate_button "><a href="#" aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="4" tabindex="0">4</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="paginate_button "><a href="#" aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="5" tabindex="0">5</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="paginate_button disabled" id="Story_TBL_ellipsis"><a--}}
                                                {{--href="#" aria-controls="Story_TBL" data-dt-idx="6"--}}
                                                {{--tabindex="0">…</a></li>--}}
                                                {{--<li class="paginate_button "><a href="#" aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="7" tabindex="0">746</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="paginate_button next" id="Story_TBL_next"><a href="#"--}}
                                                {{--aria-controls="Story_TBL"--}}
                                                {{--data-dt-idx="8"--}}
                                                {{--tabindex="0">Next</a>--}}
                                                {{--</li>--}}
                                                {{--</ul>--}}
                                                {{$stories->appends(request()->except(['page','_token']))->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
    <!-- END MAIN CONTENT -->



    <style>
        #Story_TBL_filter {
            display: none;
        }

        @if(\Request::route()->getName() =="admin-stories-list")
        th:nth-of-type(2) {
            display: none;
        }

        td:nth-of-type(2) {
            display: none;
        }

        @endif
        @if(\Request::route()->getName() =="admin-site-member-list")
        th:nth-of-type(3) {
            display: none;
        }

        td:nth-of-type(3) {
            display: none;
        }

        .input-group-addon {
            display: none;
        }

        #User_TBL_filter label input {
            display: none;
        }
        @endif
    </style>
@stop
