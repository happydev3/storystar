<div class="row">

    <!-- NEW WIDGET START -->
    <article class="col-sm-12">

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
                        <i class="fa-fw fa fa-check"></i>
                        <strong>Success</strong>
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

</div>



{{--<div class="alert alert-success">--}}
    {{--<i class="fa fa-warning"></i>--}}
    {{--Warning Your monthly traffic is reaching limit. Warning Your monthly traffic is--}}
    {{--reaching limit. Warning Your monthly traffic is reaching limit.--}}
{{--</div>--}}
{{--<div class="alert alert-info">...</div>--}}
{{--<div class="alert alert-warning">...</div>--}}
{{--<div class="alert alert-danger">...</div>--}}