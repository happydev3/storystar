<form method="POST" id="search-form" class="smart-form" novalidate="novalidate" style="display: none;">
    <fieldset>
        <legend>Advance Filters</legend>

        <div id="filters">
            <div class="row">

                <section class="col col-3">
                    <label class="select">
                        <select name="search[filter][]" class="form-control">
                            <option value="">Select Column</option>
                            @foreach ($html->getColumns() as $col)

                                @if($col->searchable ==true)
                                    <option value="{{$col->name}}">{{$col->title}}</option>
                                @endif
                            @endforeach
                        </select>
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
                            <option value="LIKE%">Begin with</option>
                            <option value="LIKE%%">Contains</option>
                            <option value="NOT LIKE">Does not contain</option>
                        </select>
                        <i></i>
                    </label>
                </section>
                <section class="col col-6">
                    <label class="input">
                        <input class="form-control" name="search[value][]"
                               placeholder="Enter search value">
                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>
                <section class="col col-1" style="text-align: right;padding-left: 0px;">
                    <label>

                        <a href="javascript:void(0);"
                           class="btn btn-default btn-circle display-none"
                           onclick="removeFilter($(this))"><i
                                    class="glyphicon glyphicon-minus"></i></a>

                        <a href="javascript:void(0);" class="btn btn-default btn-circle"
                           onclick="addNewFilter()"><i
                                    class="glyphicon glyphicon-plus"></i></a>


                    </label>
                </section>

            </div>
        </div>

        <div id="filters-div"></div>

        <button class="btn bg-color-green txt-color-white btn-padding" type="submit">
            <i class="glyphicon glyphicon-filter"></i>
            Search
        </button>
        <button class="btn bg-color-red txt-color-white btn-padding" type="reset" id="clearFilters">
            <i class="glyphicon glyphicon-refresh"></i>
            Clear
        </button>

    </fieldset>

    <br/>
    <hr/>


</form>
<script>

    function addNewFilter() {

        $("#filters-div").append($("#filters").html().replace(/display-none/g, ''));
    }

    function removeFilter(obj) {
        obj.parent().parent().parent().remove();
    }

</script>

@php

    $CustomListColumns =[];
    $CustomList =  getSetting('CustomList');
    $CurrentPath =  \Request::path();

    if(isset($CustomList[$CurrentPath])){
        $CustomListColumns = $CustomList[$CurrentPath];
    }

    if($selectedViewType=='Custom'):
    echo "<div class='custom-div'>Show/Hide Columns : &nbsp";
    $k = 0;
      foreach ($html->getColumns() as $col):
                    if($col->name !='action'):

                    // If new user show all columns in green color
                    if(empty($CustomListColumns)){
                        $colVal ="label-success";
                    }
                    else{

                        if (array_key_exists($k, $CustomListColumns)) {
                            $colVal = isset($CustomListColumns[$k])?$CustomListColumns[$k]:false;
                            $colVal =($colVal=='true')?"label-success":"label-default";
                        }
                        else{
                             $colVal ="label-success";
                        }

                    }

                    echo '<span class="label '.$colVal.'"><a class="toggle-vis txt-color-white" data-column="'.$k.'">';
                    echo  $col->title;
                    echo '</a></span>';
                    echo count($html->getColumns())-($k+2) ? "  " : "";

                    //dump($CustomListColumns);

                    endif;
                    $k++;
      endforeach;
    echo "</div>";
    endif;


@endphp
