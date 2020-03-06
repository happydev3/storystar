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
                            <h2> {{$title}} </h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <div class="dt-toolbar">
                                    <table class="table table-striped table-bordered dataTable" id="Story_TBL"
                                           role="grid" aria-describedby="Story_TBL_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="text-center sorting_disabled" width="50" tabindex="0"
                                                    aria-controls="Story_TBL" rowspan="1" colspan="1"
                                                    style="width: 50px;"
                                                    aria-label="Story ID: activate to sort column ascending">Story ID
                                                </th>
                                                <th data-class="expand" class="no-filter sorting_disabled" width="700"
                                                    tabindex="0"
                                                    aria-controls="Story_TBL" rowspan="1" colspan="1"
                                                    style="width: 700px;">Story
                                                </th>
                                                <th class="text-center sorting_disabled" width="140" rowspan="1"
                                                    colspan="1"
                                                    style="width: 140px;" aria-label="Action">Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stories as $story)
                                                <tr role="row" class="{{($loop->index+1)%2?'even':'odd'}}">
                                                    <td class=" text-center">{{$story->story_id}}</td>
                                                    <td class=" no-filter"><span class="responsiveExpander"></span><b>
                                                            <a
                                                                href="{{route('admin-stories-detail',['id'=>$story->story_id])}}">{{$story->story_title}}</a></b>
                                                        by <span
                                                            style="color: #47588F">{{$story->author_name}}
                                                            (year:{{$story->author_dob}})</span><br>
                                                        <div class="product-deatil" style="padding: 5px 0 5px 0;">
                                                        <span class="fa fa-2x"><h5>
                                                                @if (isset($story->story_rating))
                                                                    @for($i=0;$i<round($story->story_rating->average_rate);$i++)
                                                                        <i class="fa fa-star fa-2x text-primary"
                                                                           style="color: #47588F"></i>
                                                                    @endfor
                                                                @endif
                                                                 ({{isset($story->story_rating)?number_format((float)$story->story_rating->average_rate, 1, '.', ''):''}})</h5></span>
                                                        </div>
                                                        Post date: {{my_date($story->created_timestamp, "Y-m-d")}} /
                                                        Views: {{$story->views}} {{isset($story->story_rating)?' / Votes: '.$story->story_rating->total_rate:' / Votes: 0 '}}
                                                        /
                                                        Country: {{$story->author_country}}{{isset($story->comment_count)?' / Comments: '.$story->comment_count:''}}
                                                        <br><br>This
                                                        story is listed
                                                        as: {{$story->category_id == 1? 'True Life':'Fiction'}}
                                                        for {{$story->subcategory->sub_category_title}} / <span
                                                            style="color: #47588F">Theme:</span>
                                                        {{$story->theme->theme_title}} / <span style="color: #47588F">Subject:</span> {{$story->subject->subject_title}}
                                                        <br><br>{{$story->short_description}}
                                                    </td>
                                                    <td class=" text-center">
                                                        <a href="{{route('admin-story-star-addfromstories', ['story_id' => $story->story_id, 'type' => strtolower($star_type)])}}"
                                                           class="btn btn-xs bg-color-orange txt-color-white"
                                                           rel="tooltip"
                                                           data-placement="top" data-original-title=""><i
                                                            class="glyphicon glyphicon-star"></i> Make Story Star
                                                        </a> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="dt-toolbar-footer">
                                        <div class="col-sm-6 col-xs-12 hidden-xs">
                                            <div class="dataTables_info" id="Story_TBL_info" role="status"
                                                 aria-live="polite">
                                                Showing {{(($stories->currentPage()-1)*$stories->perPage())+1}}
                                                to {{$stories->currentPage()*$stories->perPage()}}
                                                of {{$stories->total()}} stories
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                 id="Story_TBL_paginate">
                                                {{$stories->appends(request()->except(['page','_token']))->links()}}
                                            </div>
                                        </div>
                                    </div>
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
