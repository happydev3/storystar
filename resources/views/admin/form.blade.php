{{Form::open(array_merge(array('url' => $from['action'],'files' => $from['multipart'],'id'=>$from['name'],'name'=>$from['name'],'method'=>$from['method']),$from['attr']))}}
{{--<header>--}}
{{--{{$from['title'] or 'No Title'}}--}}
{{--</header>--}}


<fieldset class="html-form">
    <div class="row">


        @forelse ($fields as $f)


            @switch($f['type'])
            @firstcase('text')
            <section class="col col-{{$f['col'] or 6}} {{$f['parent-class'] or 'no'}}">
                <label class="input {{ $errors->has($f['name']) ? 'state-error' : '' }}">
                    <i class="icon-append fa {{$f['icon'] or 'fa-terminal'}}"></i>
                    @if(isset($f['readonly']))
                        <input type="text" value="{!! decodeStr($f['value']) !!}"
                               name="{!! $f['name'] !!}" readonly="readonly">
                    @else
                        {{Form::text($f['name'],decodeStr($f['value']),$f['attr'])}}
                    @endif


                    @if($f['tooltip']!=false)
                        <b class="tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                </label>
                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>
            @breakcase

            @case('text-date')
            <section class="col col-{{$f['col'] or 6}}">
                <label class="input {{ $errors->has($f['name']) ? 'state-error' : '' }}">
                    <i class="icon-append fa {{$f['icon'] or 'fa-terminal'}}"></i>
                    {{Form::text($f['name'],$f['value'],$f['attr'])}}
                    @if($f['tooltip']!=false)
                        <b class="tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                </label>
                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>
            <script>
                // START AND FINISH DATE
                $('#{{$f['name']}}').datepicker({
                    dateFormat: 'yy-mm-dd',
                    prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    onSelect: function (selectedDate) {
                        // $('#finishdate').datepicker('option', 'minDate', selectedDate);
                    }
                });
            </script>
            @breakcase


            @case('email')
            <section class="col col-{{$f['col'] or 6}}">
                <label class="input {{ $errors->has($f['name']) ? 'state-error' : '' }}">
                    <i class="icon-append fa {{$f['icon'] or 'fa-terminal'}}"></i>
                    {{Form::email($f['name'],$f['value'],$f['attr'])}}
                    @if($f['tooltip']!=false)
                        <b class="tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                </label>
                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>
            @breakcase

            @case('password')
            <section class="col col-{{$f['col'] or 6}}">
                <label class="input {{ $errors->has($f['name']) ? 'state-error' : '' }}">
                    <i class="icon-append fa {{$f['icon'] or 'fa-terminal'}}"></i>
                    {{Form::password($f['name'],$f['attr'])}}
                    @if($f['tooltip']!=false)
                        <b class="tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                </label>
                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>
            @breakcase
            @case('textarea')	<div style="display:none">
                @if(isset($f['text']))
                {{$f['text']}}
                @endif

                </div>
            <section class="col col-{{$f['col'] or 6}}">
                <label class="textarea {{ $errors->has($f['name']) ? 'state-error' : '' }}">
                    <i class="icon-append fa {{$f['icon'] or 'fa-terminal'}}"></i>

                    {{ Form::textarea($f['name'], decodeStr($f['value']), $f['attr']) }}

                    @if($f['tooltip']!=false)
                        <b class=" tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                    @if(isset($f['text']))
					@if($f['text']=="Story")
						@if(isset($f['attr']['maxlength'])&&!empty($f['attr']['maxlength']))
							<div class="text-xs-center character-title">
								You can type
								<span id="charNum_{{$f['name']}}">
									<?php



									if (isset($f['value']) && !empty($f['value'])) {
										$val = $f['value'];
										$val = str_replace("\r\n", "\n", $val);
										$val = str_replace("\r", "\n", $val);

										echo $f['attr']['maxlength'] - strlen($val);
									} else {
										echo $f['attr']['maxlength'];
									}
									?>
								</span>
								characters for your story
							</div>
						@endif
					@endif
					@endif


                </label>

                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>
            @breakcase


            @case('select')
            <section class="col col-{{$f['col'] or 6}} {{$f['parent-class'] or 'no'}}">
                <label class="input {{ $errors->has($f['name']) ? 'state-error' : '' }}" style="position: relative;">
                    <i></i>
                    {{Form::select($f['name'], decodeStr($f['options']), $f['value'],$f['attr'])}}

                    <span id="{{$f['name']}}_ajaxloader"
                          style="position: absolute;position: absolute;right: 1px;top: 4px; background: #eee; display: none;">
                        <loader class="fa fa-spinner fa-spin fa-2x fa-fw" style="color:black;"></loader>
                    </span>

                    @if($f['tooltip']!=false)
                        <b class="tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                </label>
                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>
            @breakcase

            @case('ajax_select')
            <section class="col col-{{$f['col'] or 6}}">
                <label class="select {{ $errors->has($f['name']) ? 'state-error' : '' }}">
                    <i></i>

                    {{Form::select($f['name'], $f['options'], $f['value'],$f['attr'])}}

                    @if($f['tooltip']!=false)
                        <b class="tooltip {{$f['tooltip_class']}}">
                            <i class="fa {{$f['icon'] or 'fa-terminal'}} txt-color-teal"></i>
                            {{$f['tooltip_message']}}
                        </b>
                    @endif
                </label>
                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif

                @if($f['ajax_bind'])
                    <script>
                        $(document).ready(function () {
                            var j = '{!! json_encode($f['ajax_bind']) !!}';


                            $("#{{$f['name']}}").on('change', function () {

                                var id = $(this).val();

                                var category_id = $("#category_id").val();
                                var sub_category_id = $("#sub_category_id").val();


                                if (j) {
                                    $.each(jQuery.parseJSON(j), function (key, value) {


                                        $("#" + value.dependent + "_ajaxloader").show();
                                        $("#" + value.dependent).attr("disabled", true);
                                        $("#" + value.dependent).select2('destroy').empty().select2({data: {}});

                                        $.ajax({
                                            url: value.url + "&id=" + id + "&category_id=" + category_id + "&sub_category_id=" + sub_category_id,
                                            success: function (result) {

                                                $("#" + value.dependent).attr("disabled", false);
                                                $("#" + value.dependent + "_ajaxloader").hide();
                                                $("#" + value.dependent).select2(result.data);


                                            }
                                        });

                                    });
                                }

                            });
                        })
                    </script>
                @endif

            </section>
            @breakcase

            @case('hidden')
            {{Form::hidden($f['name'],$f['value'],$f['attr'])}}
            @breakcase


            @case('checkbox-toggle')

            <section class="col col-{{$f['col'] or 6}}">
                <label class="toggle">
                    <input type="checkbox" name="{{$f['name']}}" id="{{$f['name']}}"
                           @if($f['value'] == 'Yes')
                           checked="checked"
                           @endif
                           value="Yes">
                    <i data-swchon-text="Yes" data-swchoff-text="No"></i>{{$f['label']}}</label>
            </section>
            @breakcase


            @case('file')
            <section class="col col-{{$f['col'] or 6}}">
                <label style="display: inline">
                    <div class="input input-file">
                        <span class="button bg-color-magenta txt-color-white">
                            <input
                                    id="{{$f['name']}}"
                                    type="file"
                                    name="{{$f['name']}}"
                                    onchange="console.log($(this).parent().next().val());$(this).parent().next().val(this.value)">
                            Browse
                        </span>
                        <input type="text" placeholder="{{$f['attr']['placeholder']}}" readonly="">

                    </div>


                </label>

                @if ($errors->has($f['name']))
                    <em id="name-error" class="invalid">{{ $errors->first($f['name']) }}</em>
                @endif
            </section>


            @if(isset($f['value'])&&!empty($f['value']))
                <div class="btn-group showUploeded" style=" cursor: pointer;">
                    {!! $f['value'] !!}
                    {{--<button class="btn btn-default dropdown-toggle" type="button">--}}
                    {{--<span class="glyphicon glyphicon-remove"></span>--}}
                    {{--</button>--}}
                </div>
            @endif


            @breakcase


            @case('html')
            <section class="col col-{{$f['col'] or 6}}">
                {!! $f['html'] or '' !!}
            </section>
            @breakcase




            @whatever
            No Fields Found
            @endswitch


        @empty
            <p>No field in form</p>
        @endforelse
    </div>


</fieldset>

<footer>

    <div class="col-md-12">

        <button class="btn bg-color-magenta txt-color-white" type="submit">
            <i class="fa fa-save"></i>
            {{$from['btn-text'] or 'Save'}}
        </button>

        <?php
        $removeCancel = isset($from['data']['removeCancel']) && !empty($from['data']['removeCancel']) ? $from['data']['removeCancel'] : 0;
        ?>
        @if($from['btn-text']=='Update' && $removeCancel ==0)
            <button class="btn bg-color-red txt-color-white" type="button" id="cancelBtn" url="{{ URL::previous() }}">
                <i class="fa fa-chevron-left "></i>
                Cancel
            </button>
        @endif
    </div>

</footer>

<script>
    $(".openImage").click(function () {
        if ($(this).attr('url'))
            window.open($(this).attr('url'));
    });
    $("#cancelBtn").click(function () {
        if ($(this).attr('url'))
            window.location = $(this).attr('url');
    });

    $(document).ready(function () {
        pageSetUp();
    });

</script>
{{ Form::close() }}




@if($from['enabled'])
    {!! JsValidator::formRequest("App\Http\Requests\\".str_replace("Frm","",$from['name'])."Request") !!}
@endif


<script>
    $('.select2').on('change', function () {

        $(this).valid();
    });

    $('#self_story').on('change', function () {
        if ($(this).is(':checked')) {

            $(".parent_class").removeClass("hide");
            $("#user_id").prop("disabled", true);
            // $(".js-example-disabled").prop("disabled", true);

            //  $('#user_id').select2("readonly", true)

            //$('#user_id').select2("disable")

            //$('#user_id').attr("disabled", true);
            //$('#user_id').next().addClass("select2-container--disabled")
            //.select2("enable", true);
        }

        else {
            $(".parent_class").addClass("hide");
            //   $('#user_id').select2("enable")
            $("#user_id").prop("disabled", false);
        }
    });
</script>
<style>
    .invalid {
        color: red !important;
    }

    textarea#the_story {
        resize: vertical;
        font-size: 17px;
        line-height: 23px;
    }
</style>