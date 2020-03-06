@extends('admin.layout.two-column')

@section('SmallBanner')
    @include('admin.components.small-banner')
@stop

@section('RightSide')

    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{assets('js/plugin/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{assets('js/plugin/datatables/dataTables.colVis.min.js')}}"></script>
    <script src="{{assets('js/plugin/datatables/dataTables.tableTools.min.js')}}"></script>
    <script src="{{assets('js/plugin/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{assets('js/plugin/datatable-responsive/datatables.responsive.min.js')}}"></script>
    <script type="text/javascript"
            src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/js/dataTables.checkboxes.min.js"></script>
    <script>

        $.fn.dataTable.ext.errMode = 'console';
        var responsiveHelper_{{$pageData['TableID']}} = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        function bindFilters() {
            var all_filters = {};
            var source = $('#search-form').serializeObject();

            if (source['advance-stories-filter'] == 1) {
                all_filters[0] = source;
            } else if (Array.isArray(source['search[filter][]'])) {
                $(source['search[filter][]']).each(function (i, v) {
                    var m = {};
                    m.filter = v;
                    m.operator = source['search[operator][]'][i]
                    m.value = source['search[value][]'][i]
                    all_filters[i] = m;
                });
            } else {
                var m = {};
                m.filter = source['search[filter][]'];
                m.operator = source['search[operator][]'];
                m.value = source['search[value][]'];
                all_filters[0] = m;
            }

            return JSON.stringify(all_filters)
        }

        function showAdvanceFilters() {
            $("#search-form").toggle();
        }

    </script>

    <!-- MAIN CONTENT -->
    <div id="content" style="display: <?=isset($request->r) && !empty($request->r) ? "none" : "";?>">
        <div class="row">
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-table fa-fw "></i>
                    {!! $pageData['MainHeading'] or '' !!}
                    <span>
                         List {{$categoryStr or ''}}
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

    <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                @include('admin.components.notification-messages')

                <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-blueDark"
                         id="wid-id-1"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-editbutton="false"
                         data-widget-grid="false"
                         data-widget-colorbutton="false"
                         data-widget-sortable="false"
                    >
                        <header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                            <div class="jarviswidget-ctrls" role="menu"></div>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>List </h2>
                            @if(isset($pageData['advanceFilters'])&&!empty($pageData['advanceFilters']))
                                <div class="widget-toolbar">
                                    <a href="javascript:void(0);" class="button-icon txt-color-white"
                                       rel="tooltip"
                                       title=""
                                       data-placement="bottom"
                                       data-original-title="Advance Filters"
                                       onclick="showAdvanceFilters()">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </a>
                                </div>
                            @endif
                            @if(isset($selectedViewType)&&!empty($selectedViewType))
                                <div class="widget-toolbar">
                                    <div class="dropdown dropup">
                                        <a href="javascript:void(0);"
                                           class="dropdown-toggle txt-color-white"
                                           rel="tooltip"
                                           data-placement="bottom"
                                           data-original-title="List View"
                                           data-toggle="dropdown"
                                           aria-expanded="true">
                                            <i class="glyphicon glyphicon-list"></i>
                                            &#160{{$selectedViewType OR ''}}&#160
                                            <b class="caret"></b></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li class="{{$selectedViewType =='All'?'active':''}}">
                                                <a href="{{\Request::url()}}?view=all" aria-expanded="true">All</a>
                                            </li>
                                            <li class="{{$selectedViewType =='Simple'?'active':''}}">
                                                <a href="{{\Request::url()}}?view=simple" aria-expanded="false">Simple</a>
                                            </li>
                                            <li class="{{$selectedViewType =='Custom'?'active':''}}">
                                                <a href="{{\Request::url()}}?view=custom" aria-expanded="false">Custom</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </header>

                        <!-- widget div-->
                        <div>
                            <div style="display:none;">Dibyasha</div>
                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->
                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <div class="widget-body no-padding">

                                @if(\Request::route()->getName() == "admin-stories-list")
                                    @include('admin.components.story-advance-filters')
                                @else
                                    @include('admin.components.advance-filters')
                                @endif

                                <form id="Form-{{$pageData['TableID']}}" method="get" action="{{$FormURL OR ''}}">
                                    {!! $html->table(['class' => 'table table-striped table-bordered','id'=>$pageData['TableID']], true) !!}
                                    {!! $html->scripts() !!}

                                    @if(isset($multipleDelete)&& $multipleDelete == 1)
                                        <div id="" class="btn-header transparent pull-left"
                                             style="padding-top:10px; padding-left:10px; padding-bottom: 10px">
                                            <span>
                                                <button id="deleteMultiple" class="btn btn-danger"
                                                        type="button" href="javascript:void(0)"
                                                        title="Delete Selected">
                                               <i class="glyphicon glyphicon-remove"></i> Delete Selected
                                                </button>
                                            </span>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->
                    </div>
                    <!-- end widget -->
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
    
    <script>
        $(document).ready(function () {
            var allChecked = [];
            var dTable = window.LaravelDataTables["{{$pageData['TableID']}}"];
            // Retrieve the object from storage
            var SavedFilterObject = localStorage.getItem('filterObject');
            $('#search-form').on('submit', function (e) {
                var filterObject = bindFilters();
                localStorage.setItem('filterObject', filterObject);
                dTable.draw();
                e.preventDefault();
            });

            //Clear filter action when user press clear btn on advance filters
            $("#clearFilters").click(function () {
                localStorage.setItem('filterObject', '');
                dTable.clear().page(0).draw('page');
                window.location = location.href.replace("", "");
            });

            @if(isset($multipleDelete)&& $multipleDelete == 1)
            $('#{{$pageData['TableID']}}').on('init.dt', function () {
                $('#{{$pageData['TableID']}} thead th input[type="checkbox"]').on('click', function (e) {
                    // Check/uncheck all checkboxes in the table
                    var rows = dTable.rows({'search': 'applied'}).nodes();
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    if (this.checked)
                        allChecked = rows.column(0).data();
                    else
                        allChecked = []
                });
            });

            $('#{{$pageData['TableID']}} tbody').on('click', 'input[type="checkbox"]', function (e) {
                // console.log(allChecked);
                var $row = $(this).closest('tr');
                var data = dTable.row($row).data();

                    @if(\Request::route()->getName() == "admin-stories-list")
                var rowId = data['story_id'];
                    @elseif(\Request::route()->getName() == "admin-site-member-list")
                var rowId = data['user_id'];
                    @endif

                var index = $.inArray(rowId, allChecked);
                if (this.checked) {
                    allChecked.push(rowId);
                    var Len = $('#{{$pageData['TableID']}} tbody  td input[type="checkbox"]').length;
                    var queLen = allChecked.length;

                    if (parseInt(Len) === parseInt(queLen)) {
                        $('#{{$pageData['TableID']}} thead th input[type="checkbox"]').prop('checked', true);
                    }
                } else {
                    allChecked.splice(index, 1);
                    $('#{{$pageData['TableID']}} thead th input[type="checkbox"]').removeAttr("checked");
                }
            });

            // Handle form submission event
            $('#deleteMultiple').on('click', function (e) {
                e.preventDefault();
                var form = this;
                // var rows_selected = dTable.column(0).checkboxes.selected();
                rows_selected = allChecked;
                if (rows_selected.length) {
                    // Iterate over all selected checkboxes
                    $.each(rows_selected, function (index, rowId) {
                        console.log(rowId);
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'id[]')
                                .val(rowId)
                        );
                    });
                    confirmBoxOnMultiple();
                }
                else {
                    $.SmartMessageBox({
                        title: ' <i class="fa fa-info txt-color-red"></i> Notification!',
                        content: "Please choose records to delete.",
                        buttons: '[OK]'
                    }, function (ButtonPressed) {
                    });
                }

            });
            @endif

                @if(isset($callFrom) && $callFrom == "StoriesList")
                @if($pageData['refresh_filter'] !='_all')
            if (SavedFilterObject) {
                SavedFilterObject = JSON.parse(SavedFilterObject);
                SavedFilterObject = SavedFilterObject[0];
                $("#author").val(SavedFilterObject.author);
                $("#s").val(SavedFilterObject.s);
                $("#state").val(SavedFilterObject.state);
                $("#theme").val(SavedFilterObject.theme);
                $("#subject").val(SavedFilterObject.subject);
                $("#category").val(SavedFilterObject.category);
                $("#subcategory").val(SavedFilterObject.subcategory);
                $("#country").val(SavedFilterObject.country);
                $("#gender").val(SavedFilterObject.gender);
                $("#rank_order").val(SavedFilterObject.rank_order);
                $("#date_order").val(SavedFilterObject.date_order);
                $("#showCopies").val(SavedFilterObject.showCopies);
                $("#havingComments").val(SavedFilterObject.havingComments);
                dTable.draw(false);
            }
            @else
            localStorage.setItem('filterObject', '');
            // dTable.clear().page(0).order([[1, 'desc']]).draw('page');
            localStorage.clear();
            window.location = "{{route("admin-stories-list")}}";
            @endif
            @endif

            @if(isset($callFrom) && $callFrom == "FilteredStoriesList")
            @if($pageData['refresh_filter'] =='_all')
            localStorage.setItem('filterObject', '');
            localStorage.clear();
            var link = window.location.href;
            link = link.replace("_all", "");
            window.location = link;
            @endif
            @endif
        });

        // When user click on delete btn . It is showing confirmation
        function confirmBox(value) {
            $.SmartMessageBox({
                title: ' <i class="fa fa-trash txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to delete this record?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }

        // When user click on delete btn . It is showing confirmation
        function confirmBoxApprove(value) {
            $.SmartMessageBox({
                title: ' <i class="fa fa-check txt-color-green"></i> Confirmation!',
                content: "Are you sure you want to approve this record?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }

        // When user click on delete btn . It is showing confirmation
        function confirmBoxOnBlock(value) {
            $.SmartMessageBox({
                title: ' <i class="fa  fa-exclamation txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to change status of this user?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    window.location = value;
                    return true;
                }
            });
            return false;
        }

        // When user click on delete btn . It is showing confirmation
        function confirmBoxOnMultiple(value) {
            $.SmartMessageBox({
                title: ' <i class="fa fa-trash txt-color-red"></i> Confirmation!',
                content: "Are you sure you want to delete these records?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {

                    setTimeout(function () {
                        $('#Form-{{$pageData['TableID']}}').submit();
                    }, 1000);
                    return true;
                }
            });
            return false;
        }
    </script>
@stop