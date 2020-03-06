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
        }
        else if (Array.isArray(source['search[filter][]'])) {
            $(source['search[filter][]']).each(function (i, v) {
                var m = {};
                m.filter = v;
                m.operator = source['search[operator][]'][i]
                m.value = source['search[value][]'][i]
                all_filters[i] = m;
            });
        }
        else {
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
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <h1 class="page-title txt-color-blueDark">
                <span> Comment List </span>
            </h1>
        </div>
        
        <article class="col-sm-12" id="notifciationMessage">
            
        </article>

    </div>

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

                    <header>

                        <div class="jarviswidget-ctrls" role="menu"></div>

                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>List </h2>

                    </header>
                    
                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">
                            <a name="comments"></a>
                            <form id="Form-{{$pageData['TableID']}}" method="get"
                                  action="{{$FormURL OR ''}}">

                                {!! $html->table(['class' => 'table table-striped table-bordered','id'=>$pageData['TableID']], true) !!}

                                {!! $html->scripts() !!}

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
<div class="modal fade" id="commentRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="RequestStoryComment" action="{{ route('admin-request-story-comment',$story_id) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="col-md-12" id="errorMessageRequest">                        
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">E-mails:                            
                        </label>
                        <small style="font-size: 9px"s><br/>Note : Add multiple email separated by `,`</small>
                        <textarea name="emails" class="form-control" id="message-text" required=""></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-primary">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#RequestStoryComment').on('submit',function(e){            
            e.preventDefault();
            var url = $(this).attr('action');
            var processData = true;
            var contentType = "application/x-www-form-urlencoded";
            var data = $(this).serialize();
            var $this = $(this);
            $.ajax({
                type: 'POST',
                url: url,
                data:  data,
                dataType: 'json',
                processData : processData,
                contentType : contentType,
                success : function(data) {
                    $this.closest('.modal').modal('hide');
                    $this[0].reset();
                    $('#notifciationMessage').append('<div class="alert alert-success fade in">'+
                        '<button class="close" data-dismiss="alert">'+
                            '×'+
                        '</button>'+
                        '<i class="fa-fw fa fa-check"></i>'+
                        '<strong>Success</strong> &nbsp;'+
                        'Comment Request has been send successfully!'+
                    '</div>');
                    
                },
                error : function(jqXHR, textStatus, errorThrown) {
                    $('#errorMessageRequest').empty().append('<div class="alert alert-danger fade in">'+
                        '<button class="close" data-dismiss="alert">'+
                            '×'+
                        '</button>'+
                        '<i class="fa-fw fa fa-check"></i>'+
                        'Please enter valid email!'+
                    '</div>');
                },
                complete : function(jqXHR, textStatus) {
                }
            }); 
        });
    });
    


    $(document).ready(function () {

        var allChecked = [];
        var dTable = window.LaravelDataTables["{{$pageData['TableID']}}"];

        // Retrieve the object from storage
        var SavedFilterObject = localStorage.getItem('filterObject');


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



</script>

