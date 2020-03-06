@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
    <ul>
        @foreach($wrongEmails as $item)
            <li>
                {{$item->email}} - {{$item->problem_type}} - {{$item->repeated_attempts}} - {{$item->created_at}}
            </li>
        @endforeach
    </ul>
@stop
