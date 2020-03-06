<?php
use App\Models\Admin;


function data_table_attr($TableID, $RestrictSearchFor, $defaultSortBy, $multiDeleteOption)
{


    $Countries = App\Models\Story::Select("author_country")->groupBy('author_country')->orderBy('author_country', 'asc')->get()->toArray();
    $Countries = array_column($Countries, "author_country");
    $Countries = array_combine($Countries, $Countries);


    $Countries = array_merge(array("" => "All"), $Countries);

    $Countries = json_encode($Countries);


    /*$save = getSetting('save_filter');
    if ($save == 'Yes')
        $save = 'true';
    else
        $save == 'false';
    */

    $save = 'true';


    // Get the saved view list value for $currentPath
    $showHideCols = '';
    if (\Request::get('view')) {
        $selectedViewType = \Request::get('view');
    } else {
        $currentPath = \Request::path();
        $selectedViewType = getSetting('ListView');
        $selectedViewType = isset($selectedViewType[$currentPath]) && !empty($selectedViewType[$currentPath]) ? $selectedViewType[$currentPath] : '';
    }

    // if user select other than custom than clear the saved state
    if (isset($selectedViewType) && strtolower($selectedViewType) == 'custom'):
        $CustomList = getSetting('CustomList');
        $currentPath = \Request::path();

        if (isset($CustomList[$currentPath])) {

            foreach ($CustomList[$currentPath] as $k => $col):
                $showHideCols .= "api.column($k).visible(" . $CustomList[$currentPath][$k] . ");";
            endforeach;
        }
    endif;

    $multiDelete = [];
    if ($multiDeleteOption) {
        $multiDelete = ["columnDefs" => [['targets' => 0,
            'searchable' => false,
            'orderable' => false,
            'checkboxes' => ['selectRow' => true]]],
            "select" => ['style' => 'multi']];

    }


    $defaultSortByRec = [];
    if (isset($defaultSortBy) && !empty($defaultSortBy)) {
        $defaultSortByRec["order"] = $defaultSortBy;
    }


    $mainSettings = [


        "autoWidth" => false,
        'bFilter' => true,
        "lengthMenu" => [[15, 30, 60, 120, 150, 300, 600], [15, 30, 60, 120, 150, 300, 600]],
        "sDom" => "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs padding-right-0'l<'toolbar'>r>t<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        // 'bStateSave' => $save,
        'stateSave' => $save,

        // 'scrollX' => true,
        //"search" => ["regex" => true],

        "oLanguage" => [
            'sSearch' => "<span class='input-group-addon'><i class='glyphicon glyphicon-search'></i></span>",
            "sProcessing" => '<div id="loader"></div>',
            "sLengthMenu" => "_MENU_",
            "sZeroRecords" => "No records available",
        ],


        'initComplete' => 'function () {
                    var api = this.api();
                  
                  
        
                  
                    $("div.dataTables_filter input").unbind();
                    $("div.dataTables_filter input").keyup(function (e) {
                        if (e.keyCode == 13) {
                            api.search( this.value ).draw();
                        }
                        else if(e.keyCode == 8 || e.keyCode == 46){
                            if(this.value =="")  
                               api.search( this.value ).draw();
                        }
                    });
            
                    var r = $("#' . $TableID . ' tfoot tr");
                    $("#' . $TableID . ' thead").append(r);
            
                    this.api().columns().every(function (index) {
                    
                      var column = this;
                      var TH = $(\'#' . $TableID . '  thead th\');
                      var title = TH.eq( this.index() ).text();
                    
                      
                      if(title != "Action"){
                      
                            if(!TH.eq( this.index() ).hasClass("no-filter")){
          
          
                                // Select Dropdown
                                
                                 if(TH.eq( this.index() ).hasClass("countries")){
                                 
                                     var input = document.createElement("select");
                                    input.setAttribute("placeholder", "Search "+title);
                                    input.setAttribute("class","form-control");
                                    //Create and append the options
                                    var array = "";
                                 
                             
                                    var parsed = ' . $Countries . ';
                                    $.each( parsed, function( key, value ) {
                                            var option = document.createElement("option");
                                            option.setAttribute("value", key);
                                            option.text = value;
                                            input.appendChild(option);
                                    });
                                    
                                    
                                       if(api.state()){
                                                
                                            var countriesValue = api.state().columns[index].search.search;
                                            if(valueOfYesNO == "")
                                               input.value = "All";
                                            else 
                                                input.value =countriesValue;
                                             
                                       }
                                       
                                    
                                     $(input).appendTo($(column.footer()).empty()).on("change", function (e) {
                                   
                                 
                                  
                                        if($(this).val()){
                                            column.search($(this).val()).draw();
                                        } else{
                                        
                                             column.search("").draw();
                                        }
                                       
                                   
                                        
                                    });
                                    
                                      
                                      
                                 
                                 }
                                 else if(TH.eq( this.index() ).hasClass("yes-no")){
                    
                                    var input = document.createElement("select");
                                    input.setAttribute("placeholder", "Search "+title);
                                    input.setAttribute("class","form-control");
                                    //Create and append the options
                                    var array = ["All","Yes","No"];
                                    for (var i = 0; i < array.length; i++) {
                                        var option = document.createElement("option");
                                        option.setAttribute("value", array[i]);
                                        option.text = array[i];
                                        input.appendChild(option);
                                    }
                                    
                                      if(api.state()){
                                                
                                            var valueOfYesNO = api.state().columns[index].search.search;
                                            
                                            if(valueOfYesNO == "")
                                               input.value = "All";
                                            else if(valueOfYesNO == 0)
                                                input.value = "No";
                                            else if(valueOfYesNO == 1)
                                                input.value = "Yes";
                                         
                                                
                                       }
                                        
                                    
                                     $(input).appendTo($(column.footer()).empty()).on("change", function (e) {
                                   
                                        
                                        if($(this).val() == "No"){
                                          column.search("0").draw();
                                        }else if($(this).val() == "Yes"){
                                            column.search("1").draw();
                                        } else{
                                         column.search("").draw();
                                        }
                                       
                                   
                                        
                                    });
                                    
                                   
                                }
                                else{
                                
                                
                                       var input = document.createElement("input");
                                       input.setAttribute("placeholder", "Search "+title);
                                       input.setAttribute("class","form-control");
                                        if(api.state()){
                                            if(api.state().columns[index].search.search)
                                                input.setAttribute("value", api.state().columns[index].search.search);
                                        }
                                   
                                         $(input).appendTo($(column.footer()).empty()).on("keyup", function (e) {
                                       
                                            var code = e.keyCode || e.which;
                                       
                                            if(code == 13) { 
                                                column.search($(this).val()).draw();
                                            }
                                            else if(code == 8 || code == 46){
                                                if($(this).val()=="")  
                                                     column.search($(this).val()).draw();
                                            }
                                        });
                                    
                                }
                           
                           }
                           
                      }
                      else if(title == "Action") {
                        var input = document.createElement("input");
                        input.setAttribute("type", "button");
                        input.setAttribute("value", "reset");
                        input.setAttribute("onclick", "field_reset()");
                        input.setAttribute("class", "reset-button");
                        input.setAttribute("id", "reset");
                        $(input).appendTo($(column.footer()).empty()).on("change", function (e) {
                        });
                      }
                      
                    });
                    
                    ' . $showHideCols . '
                }',
        'preDrawCallback' => 'function () {
            
               // Initialize the responsive datatables helper once.
                if (!responsiveHelper_' . $TableID . ' ) {
                    responsiveHelper_' . $TableID . '  = new ResponsiveDatatablesHelper($(\'#' . $TableID . ' \'), breakpointDefinition);
                }
            
            }',
        'rowCallback' => 'function (nRow) {
       
                responsiveHelper_' . $TableID . ' .createExpandIcon(nRow);
            }',
        'drawCallback' => 'function (oSettings) {
            
               responsiveHelper_' . $TableID . ' .respond();
               $("[rel=tooltip], [data-rel=tooltip]").tooltip();
               
            }'
    ];

    //dd(array_merge($defaultSortByRec, $multiDelete, $mainSettings));

    return array_merge($defaultSortByRec, $multiDelete, $mainSettings);

}

function getListingUrls()
{
    $url = [];
    $routeCollection = \Route::getRoutes();


    foreach ($routeCollection as $value) {

        if ($value->getName() == 'admin-dashboard' || $value->getName() == 'admin-settings')
            $url[$value->uri()] = $value->uri();

        if (ends_with($value->getName(), "-list") && !ends_with($value->getName(), "-userinfo-list"))
            $url[$value->uri()] = $value->uri();


    }
    return $url;
}

function setAdvanceFilter($request, $table)
{

    if (isset($request->updatedFilter) && !empty($request->updatedFilter))
        $customFilters = $request->updatedFilter;
    else
        $customFilters = $request->get('filter');

    if ($customFilters) {

        $customFilters = \GuzzleHttp\json_decode($customFilters, true);
        foreach ($customFilters as $k => $cf):
            if (sizeof($cf)) :

                $filter = isset($cf['filter']) && !empty($cf['filter']) ? $cf['filter'] : '';
                $value = isset($cf['value']) && !empty($cf['value']) ? $cf['value'] : '';
                $operator = isset($cf['operator']) && !empty($cf['operator']) ? $cf['operator'] : '';


                if ($filter && $value && $operator) {


                    switch ($operator):
                        case 'LIKE%':
                            $value = "$value%";
                            $operator = "LIKE";
                            break;
                        case 'LIKE%%':
                            $value = "%$value%";
                            $operator = "LIKE";
                            break;
                        case 'NOT LIKE':
                            $value = "$value%";
                            $operator = "NOT LIKE";
                            break;
                    endswitch;


                    if ($filter == 'created_timestamp' || $filter == 'updated_timestamp') {
                        $table->whereRaw("DATE_FORMAT(FROM_UNIXTIME(created_timestamp),'%d-%m-%Y %h:%i:%s') $operator ?", ["$value"]);
                    } else {
                        $table->where($filter, $operator, "$value");
                    }

                }

            endif;

        endforeach;
    }


    return $table;
}


?>