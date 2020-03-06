<div class="jarviswidget jarviswidget-color-green" id="wid-id-1" data-widget-editbutton="false">
    <header>
        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
        <h2>Current Story Star List</h2>
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

            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="">Story Title</th>
                        <th width="">Author</th>
                        <th width="" class="text-center">Type</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Subcategory</th>
                        <th class="text-center">Featured Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>


                    @if($list)
                        @foreach ($list as $i)

                            <tr>
                                <td><?=$i->story_title;?></td>
                                <td><?=$i->author_name;?></td>
                                <td class="text-center"><?=$i->type;?></td>
                                <td class="text-center"><?=$i->category_title;?></td>
                                <td class="text-center"><?=$i->sub_category_title;?></td>
                                <td class="text-center"><?= my_date($i->created_timestamp);?></td>
                                <td class="text-center">
                                <?php
                                    echo '<a href="' . route('admin-story-star-high-rated', ["category_id" => $i->category_id, "sub_category_id" => $i->sub_category_id, "old_id" => $i->storystar_id, "star_type" => $i->type, "r" => "_all"]) . '" class="btn btn-xs btn-success" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> Change</a>';
                                ?>
                                </td>
                                
                            </tr>
                        @endforeach
                    @endif


                    </tbody>
                </table>

            </div>
        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>
						