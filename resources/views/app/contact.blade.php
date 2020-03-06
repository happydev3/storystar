@extends('app.layout.page')
@section('bodyContent')
    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg">
                        <a name="profile"></a>
                        <h1 class="text-xs-center author-heading">Contact Us</h1>
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">
                                <h1 class="story-info-title">Contact / Suggestion Box</h1>
                                <p class="author-top-content">We are happy to hear your Storystar related questions, comments, and suggestions.</p>
                                <div class="clearfix"></div>
                                <form class="login" id="contactfrm" role="form" method="POST" enctype="multipart/form-data"
                                      action="{{ route("app-contact-action")}}">
                                    <!-- NEW WIDGET START -->
                                    <article class="">
                                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                            @if(Session::has('alert-' . $msg))
                                                <div class="alert alert-{{ $msg }} fade in">
                                                    <button class="close" data-dismiss="alert">
                                                        ×
                                                    </button>
                                                    @if($msg=='warning')
                                                        <i class="fa-fw fa fa-warning"></i>
                                                        <strong>Warning</strong>
                                                    @elseif($msg=='success')
                                                        <strong>THANK YOU! </strong>
                                                    @elseif($msg=='info')
                                                        <i class="fa-fw fa fa-info"></i>
                                                        <strong>Info!</strong>
                                                    @elseif($msg=='danger')
                                                        <i class="fa-fw fa fa-times"></i>
                                                        <strong>Error!</strong>
                                                    @endif
                                                    {{ Session::get('alert-' . $msg) }}.
                                                </div>
                                            @endif
                                        @endforeach
                                    </article>
                                    <!-- WIDGET END -->
                                    {{ csrf_field() }}
                                    <div class="form-select-boxes margin-bottom-remove">
                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">
                                                Name
                                            </label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <span class="select-wrapper">
                                                <input id="name" type="text" class="custom-select custom-input" spellcheck="true" name="name" value="@if(!auth()->guest()){{auth()->user()->name}}@endif">
                                                    <span class="holder"></span>
                                                </span>
                                                @if ($errors->has('name'))
                                                    <em id="theme_id-error"
                                                        class="invalid">{{ $errors->first('name') }}</em>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-select-left clearfix ">
                                            <label class="title-padding">Email</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <span class="select-wrapper">
                                                    <input id="email" type="email" class="custom-select custom-input" spellcheck="true" name="email" value="@if(!auth()->guest()){{auth()->user()->email}}@endif">
                                                    <span class="holder"></span>
                                                    @if ($errors->has('email'))
                                                        <em id="email-error"
                                                            class="invalid">{{ $errors->first('email') }}</em>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-select-left clearfix  ">
                                            <label class="title-padding">Subject</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <span class="select-wrapper">
                                                    <input id="subject" type="text" class="custom-select custom-input" spellcheck="true" name="subject"><span class="holder"></span></span>
                                                @if ($errors->has('subject'))
                                                    <em id="subject-error"
                                                        class="invalid">{{ $errors->first('subject') }}</em>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-select-left clearfix  ">
                                            <label class="title-padding">Message</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <span class=""><textarea name="message" id="message" spellcheck="true" style="width:100%;height:250px;padding: 15px"></textarea>
                                                 </span>
                                                @if ($errors->has('message'))
                                                    <em id="message-error"
                                                        class="invalid">{{ $errors->first('message') }}</em>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-select-left clearfix  ">

                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <label class="title-padding">Enter the text showing in image</label><br/>
                                                <img src="{{ url('captcha-image') }}/{{ $timestamp = time() }}" height="41px" width="100px" />
                                                <span class="select-wrapper" style="width: calc(100% - 100px)">
                                                    <input placeholder="Enter Capcha Text" id="captcha" type="text" class="custom-select custom-input" name="captcha">
                                                    <input type="hidden" value="{{ $timestamp }}" name="captcha_code" />
                                                    <span class="holder"></span>
                                                </span>
                                                @if ($errors->has('captcha'))
                                                    <em id="captcha-error"
                                                        class="invalid">{{ $errors->first('captcha') }}</em>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- {!! app('captcha')->display() !!} --}}
                                        <div class="form-select-left btn-style clearfix">
                                            <div class="text-xs-center btn btn-readstory publish-btn">
                                                <button type="submit">SEND</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @if($jsValidation == true)
                                    {!! $validator !!}
                                @endif
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            @include("app.components.footer")
        </div>
    </div>
<!--    <script type='text/javascript'>-->
<!--$Spelling.SpellCheckAsYouType('all')-->
<!--function validateFormSpelling(){-->
<!--if($Spelling.BinSpellCheckFields('all')){-->
<!--	alert("Spell Check OK - Submit The Form.")-->
<!--	return true-->
<!--}else{-->
<!--	alert("Spell Check Errors - Spelling Will Be Checked Before Submitting The Form.")-->
<!--	$Spelling.SubmitFormById  = 'contactfrm';-->
<!--	$Spelling.SpellCheckInWindow('all') 	;-->
<!--	return false;-->
<!--	}-->
<!--}-->
<!--</script>-->
@endsection

@push('meta-data')
<meta name="description" content="Contact us. We are happy to hear your Storystar related questions, comments, and suggestions."/>
<meta name="keywords" content="contact us"/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/>
@endpush