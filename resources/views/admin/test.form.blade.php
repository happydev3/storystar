{{Form::open(array_merge(array('url' => $from['action'],'files' => $from['multipart'],'id'=>$from['name'],'name'=>$from['name'],'method'=>$from['method']),$from['attr']))}}
<header>
    {{$from['title'] or 'No Title'}}
</header>
<fieldset class="html-form">
    <div class="row">
        @forelse ($fields as $f)
            <section class="col col-{{$f['col'] or 6}}" style="@if($f['type']=='hidden')display:none;@endif">
                <label
                        @if($f['type'] == 'file')
                        style="display: inline"
                        @endif

                        @if($f['type']=='text' || $f['type']=='email'|| $f['type']=='password')
                        class="input {{ $errors->has($f['name']) ? 'state-error' : '' }}"
                        @elseif($f['type']=='select')
                        class="select {{ $errors->has($f['name']) ? 'state-error' : '' }}"
                        @else
                        class="{{ $errors->has($f['name']) ? 'state-error' : '' }}"
                        @endif
                >

                    @if($f['type'] == 'select')
                        <i></i>
                    @elseif($f['type'] == 'file')
                    @else
                        <i class="icon-append fa {{$f['icon'] or 'fa-terminal'}}"></i>
                    @endif

                    @switch($f['type'])

                    @firstcase('text')
                    {{Form::text($f['name'],$f['value'],$f['attr'])}}
                    @breakcase

                    @case('email')
                    {{Form::email($f['name'],$f['value'],$f['attr'])}}
                    @breakcase

                    @case('hidden')
                    {{Form::hidden($f['name'],$f['value'],$f['attr'])}}
                    @breakcase

                    @case('password')
                    {{Form::password($f['name'],$f['attr'])}}
                    @breakcase


                    @case('select')
                    {{Form::select($f['name'], $f['options'], $f['value']),$f['attr']}}
                    @breakcase

                    @case('file')


                    <div class="input input-file">
                        <span class="button">
                            <input
                                    id="{{$f['name']}}"
                                    type="file"
                                    name="{{$f['name']}}"
                                    onchange="console.log($(this).parent().next().val());$(this).parent().next().val(this.value)">
                            Browse
                        </span>
                        <input type="text" placeholder="{{$f['attr']['placeholder']}}" readonly="">
                    </div>
                    @breakcase

                    @whatever
                    No Fields Found
                    @endswitch

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
        @empty
            <p>No field in form</p>
        @endforelse
    </div>


</fieldset>

<footer>

    <div class="col-md-12">

        <button class="btn btn-primary" type="submit">
            <i class="fa fa-save"></i>
            {{$from['btn-text'] or 'Save'}}
        </button>

        <button class="btn btn-default" type="button">
            Cancel
        </button>
    </div>

</footer>

{{ Form::close() }}
