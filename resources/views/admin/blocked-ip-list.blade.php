@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')
    <!-- MAIN CONTENT -->
    <div id="content">
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
                            <h2> {{$pageData['MainHeading']}} </h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <div class="dt-toolbar">
                                    <table class="table table-striped table-bordered dataTable" id="Story_TBL"
                                           role="grid" aria-describedby="Story_TBL_info">
                                        <thead>
                                            <tr role="row">
                                                <th data-class="expand" class="no-filter sorting_disabled" width="700"
                                                    tabindex="0"
                                                    aria-controls="Story_TBL" rowspan="1" colspan="1"
                                                    style="width: 700px;">IP Address
                                                </th>
                                                <th class="text-center sorting_disabled" width="140" rowspan="1"
                                                    colspan="1"
                                                    style="width: 140px;" aria-label="Action">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($blocked_ip_addresses as $blocked_ip)
                                                <tr role="row" class="{{($loop->index+1)%2?'even':'odd'}}">
                                                    <td  class=" no-filter">{{$blocked_ip->ip_address}}</td>
                                                    <td class=" text-center">
                                                        <a href="{{route('admin-blocked-ip-delete', ['id' => $blocked_ip->id])}}"
                                                           class="btn btn-xs btn-danger"
                                                           rel="tooltip"
                                                           data-placement="top" data-original-title="Remove IP Address"><i
                                                            class="glyphicon glyphicon-trash"></i> Remove
                                                        </a> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if(isset($blocked_ip_addresses))
                                    <div class="dt-toolbar-footer">
                                        <div class="col-sm-6 col-xs-12 hidden-xs">
                                            @if($blocked_ip_addresses->total() > 0)
                                            <div class="dataTables_info" id="Story_TBL_info" role="status"
                                                 aria-live="polite">
                                                Showing {{(($blocked_ip_addresses->currentPage()-1)*$blocked_ip_addresses->perPage())+1}}
                                                to 
                                                @if($blocked_ip_addresses->currentPage()*$blocked_ip_addresses->perPage() < $blocked_ip_addresses->total())
                                                {{$blocked_ip_addresses->currentPage()*$blocked_ip_addresses->perPage()}}
                                                @else
                                                    {{$blocked_ip_addresses->total()}}
                                                @endif
                                                of {{$blocked_ip_addresses->total()}} IP Addresses
                                            </div>
                                            @else
                                            <div class="dataTables_info" id="Story_TBL_info" role="status"
                                                 aria-live="polite">
                                                No Result Found
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                 id="Story_TBL_paginate">
                                                {{$blocked_ip_addresses->appends(request()->except(['page','_token']))->links()}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
    <!-- END MAIN CONTENT -->
@stop
