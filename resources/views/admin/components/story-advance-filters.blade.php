{{--$this->pageData['category_id'] = isset($request->category_id) ? $request->category_id : 0;--}}
{{--$this->pageData['sub_category_id'] = isset($request->sub_category_id) ? $request->sub_category_id : 0;--}}

<form method="POST" id="search-form" class="smart-form" novalidate="novalidate">
    <fieldset>
        <legend>Story Advanced Filter</legend>

        <div id="filters">
            <div class="row">

                <input type="hidden" class="form-control" name="advance-stories-filter" value="1">

                <section class="col col-4">
                    <label class="input">
                        <input class="form-control" name="author" id="author"
                               placeholder="Author">

                        <b class="tooltip tooltip-top-right">
                            <i class="fa fa-terminal txt-color-teal"></i>
                            Search with author name.
                        </b>

                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>

                <section class="col col-4">
                    <label class="input">
                        <input class="form-control" name="s" id="s"
                               placeholder="Keyword">

                        <b class="tooltip tooltip-top-right">
                            <i class="fa fa-terminal txt-color-teal"></i>
                            Search with keyword in title.
                        </b>

                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>

                <section class="col col-4">
                    <label class="input">
                        <input class="form-control" name="state" id="state"
                               placeholder="City/Address">

                        <b class="tooltip tooltip-top-right">
                            <i class="fa fa-terminal txt-color-teal"></i>
                            Search with author's city/address.
                        </b>
                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-2">
                    <label class="input">
                        <select class="form-control" name="theme" id="theme">
                            <?php
                            $Themes = App\Models\Theme::orderBy("theme_order", "asc")->get()->toArray();
                            ?>
                            <option value="">All Themes</option>
                            @if($Themes)
                                @foreach($Themes as $k =>$theme)
                                    <option value="{{trim($theme['theme_id'])}}">
                                        {{ucwords($theme['theme_title'])}}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                    </label>
                </section>

                <section class="col col-2">
                    <label class="input">
                        <select class="form-control" name="subject" id="subject">
                            <?php
                            $Subjects = App\Models\Subject::orderBy("subject_title", "asc")->get()->toArray();
                            ?>
                            <option value="">All Subjects</option>
                            @if($Subjects)
                                @foreach($Subjects as $k =>$Subject)

                                    <option
                                            value="{{trim($Subject['subject_id'])}}">
                                        {{ucwords(html_entity_decode($Subject['subject_title']))}}
                                    </option>


                                @endforeach
                            @endif

                        </select>

                    </label>
                </section>

                <section class="col col-2">
                    <label class="input">
                        <?php
                        $Categories = getCategories();
                        ?>

                        <select class="form-control" name="category" id="category">
                            <option value="">All Categories</option>
                            @if($Categories)
                                @foreach($Categories as $k =>$Category)

                                    <option value="{{$k}}">
                                        {{ucwords($Category)}}
                                    </option>
                                @endforeach
                            @endif

                        </select>
                        <i></i>

                    </label>
                </section>

                <section class="col col-2">
                    <label class="input">
                        <?php
                        $subCategories = getSubCategories();
                        ?>

                        <select class="form-control" name="subcategory" id="subcategory">
                            <option value="">All Subcategories</option>
                            @if($subCategories)
                                @foreach($subCategories as $k =>$subCategory)

                                    <option value="{{$k}}">
                                        {{ucwords($subCategory)}}
                                    </option>
                                @endforeach
                            @endif

                        </select>
                        <i></i>

                    </label>
                </section>

                <section class="col col-2">
                    <label class="input">
                        <?php
                        $Countries = getCountries();
                        ?>
                        <select class="form-control" name="country" id="country">
                            <option value="">All Countries</option>
                            @if($Countries)
                                @foreach($Countries as $k =>$country)
                                    <option value="{{$k}}">
                                        {{ucwords($k)}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <i></i>

                    </label>
                </section>

                <section class="col col-2">
                    <label class="input">
                        <select name="gender" class="form-control" id="gender">
                            <option value="">Author's Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Unspecified">Unspecified</option>

                        </select>
                        <i></i>
                    </label>
                </section>


            </div>

            <div class="row hide">

                <section class="col col-1">
                    <label class="input">
                        <input name="month[filter]" class="form-control" value="Month" readonly
                               style="background: none">
                        <i></i>

                    </label>
                </section>
                <section class="col col-2">
                    <label class="input">
                        <select name="month[operator]" class="form-control">
                            <option value="">All</option>
                            <option value="c">Current Month</option>
                            <option value="e">Equal To (Month No)</option>
                            <option value="om">Older Than (Months)</option>
                            <option value="od">Older Than (Days)</option>
                        </select>
                        <i></i>
                    </label>
                </section>
                <section class="col col-4">
                    <label class="input">
                        <input class="form-control" name="month[value]"
                               placeholder="Enter search value">
                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>


            </div>
            <div class="row hide" id="StoryFilters">

                <section class="col col-1">
                    <label class="input">

                        <input name="search[filter][]" class="form-control" value="Rank" readonly
                               style="background: none">

                        {{--<select name="search[filter][]" class="form-control">--}}
                        {{--<option value="">Select Column</option>--}}
                        {{--<option value="average_rate">Rank</option>--}}
                        {{--<option value="views">Views</option>--}}
                        {{--</select>--}}

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
                        </select>
                        <i></i>
                    </label>
                </section>
                <section class="col col-4">
                    <label class="input">
                        <input class="form-control" name="search[value][]"
                               placeholder="Enter search value">
                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>

            </div>
            <div class="row hide" id="">

                <section class="col col-1">
                    <label class="input">

                        <input name="search[filter][]" class="form-control" value="Views" readonly
                               style="background: none">

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
                        </select>
                        <i></i>
                    </label>
                </section>
                <section class="col col-4">
                    <label class="input">
                        <input class="form-control" name="search[value][]"
                               placeholder="Enter search value">
                        <i class="icon-append fa fa-terminal"></i>

                    </label>
                </section>


            </div>


            <legend>Order By</legend>
            <br/>

            <div class="row" id="">

                <section class="col col-2">
                    <label class="input">

                        <input name="order_by_rank" class="form-control" value="Ranking Order" readonly
                               style="background: none">

                    </label>
                </section>
                <section class="col col-4">
                    <label class="input">
                        <select name="rank_order" id="rank_order" class="form-control">
                            <option value="">Choose order</option>
                            <option value="desc">Highest rated first</option>
                            <option value="asc">Lowest rated first</option>
                        </select>


                        <i></i>
                    </label>
                </section>

                <section class="col col-2">
                    <label class="input">

                        <input name="order_by_rank" class="form-control" value="Date Order" readonly
                               style="background: none">

                    </label>
                </section>
                <section class="col col-4">
                    <label class="input">
                        <select name="date_order" id="date_order" class="form-control">
                            <option value="">Choose order</option>
                            <option value="desc">Newest first</option>
                            <option value="asc">Oldest first</option>
                        </select>


                        <i></i>
                    </label>
                </section>

            </div>


            <div class="row">

                <section class="col col-6">
                    <legend>Show Story Copies</legend>
                    <br/>

                    <label class="input">
                        <select class="form-control" name="showCopies" id="showCopies">
                            <option value="Yes">
                                Yes
                            </option>
                            <option value="No">
                                No
                            </option>
                        </select>

                    </label>
                </section>

                <section class="col col-6">

                    <legend>Stories having comments</legend>
                    <br/>
                    <label class="input">
                        <select class="form-control" name="havingComments" id="havingComments">
                            <option value="">
                                All
                            </option>
                            <option value="Yes">
                                Yes
                            </option>
                            <option value="No">
                                No
                            </option>
                        </select>

                    </label>
                </section>

            </div>


            <div class="row">
                <div id="filters-div"></div>
            </div>

        </div>


        <button id="searchBtn" class="btn bg-color-green txt-color-white btn-padding" type="submit">
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

        $("#filters-div").append("<div>" + $("#StoryFilters").html().replace(/display-none/g, '') + "</div>");
    }
    function removeFilter(obj) {
        obj.parent().parent().parent().remove();
    }

    $(document).ready(function () {
        // $("#searchBtn").click();
    })


</script>

<style>

    #Story_TBL_filter {
        display: none;
    }
</style>
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


{{--<section class="col col-1" style="text-align: right;padding-left: 0px;">--}}
{{--<label>--}}

{{--<a href="javascript:void(0);"--}}
{{--class="btn btn-default btn-circle display-none"--}}
{{--onclick="removeFilter($(this))"><i--}}
{{--class="glyphicon glyphicon-minus"></i></a>--}}

{{--<a href="javascript:void(0);" class="btn btn-default btn-circle"--}}
{{--onclick="addNewFilter()"><i--}}
{{--class="glyphicon glyphicon-plus"></i></a>--}}


{{--</label>--}}
{{--</section>--}}