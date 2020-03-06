@php
    if (Route::currentRouteName()=='app-profile'){
    $paginator->fragment('stories');
    }
@endphp

<link href="/assets/app/css/pagination.css?a=10" rel="stylesheet" id="bootstrap-css">
<div class="col-md-12 pagination-boxes " @if(isset($margin)) style="margin: {{$margin}}px;" @endif align="center">
    <div class="row">
        @if($position == 'top')
            @if($paginator->count())
                <div class="pagination-left" style="margin-top: 0px;width: auto">
                    <div class="sort-wrap">
                        <select class="styled" id="sort" name="sort" onchange="setSorting()">
                            <option value="-" disabled selected>Sort by</option>
                            <option value="latest">Newest
                            </option>
                            <option {{$pageData['sortby'] == 'oldest'?'selected="selected"':''}} value="oldest">Oldest
                            </option>
                            @if(\Request::route()->getName() != "app-fav-authors")
                                <option
                                    {{$pageData['sortby'] == 'views_asc'?'selected="selected"':''}} value="views_asc">
                                    Lowest Views
                                </option>

                                <option
                                    {{$pageData['sortby'] == 'views_desc'?'selected="selected"':''}} value="views_desc">
                                    Highest Views
                                </option>

                                <option {{$pageData['sortby'] == 'rank_asc'?'selected="selected"':''}} value="rank_asc">
                                    Lowest Rating
                                </option>

                                <option
                                    {{$pageData['sortby'] == 'rank_desc'?'selected="selected"':''}} value="rank_desc">
                                    Highest Rating
                                </option>
                            @else
                                <option {{$pageData['sortby'] == 'alpha'?'selected="selected"':''}} value="alpha">
                                    Alphabetic
                                </option>
                            @endif
                        </select>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endif
        @else

            @if($paginator->count())
                <div class="page-number col-md-3  col-lg-push-2"
                     style="font-size: 20px;font-weight: bold;color:white;margin-top: 0px;text-align: left;padding: 0px;">
                    Page {{$paginator->currentPage()}} of {{$paginator->lastPage()}}
                </div>
            @endif
        @endif

        @php
            $html ='';
            $pages = [];
            $numpages = $paginator->lastPage();
            $current_page = $paginator->currentPage();
            $dotshow = true;


            if( $current_page == 2 || $current_page == $numpages -1 ){

                $limit = 2;

            }else if($current_page >= 3 && $current_page != $numpages ){

                $limit = 1;

            }else{

                $limit = 3;
            }

            if ($numpages != 1) {
            $html.='<ul class="pagination">';
                $html .='<li><i class="fa fa-angle-left"></i></li>';// prev

                for($i=1; $i <= $numpages; $i++){


                    if ($i == 1 || $i == $numpages ||  ($i >= $current_page - $limit &&  $i <= $current_page + $limit) ) {
                          $dotshow = true;
                          if ($i != $current_page){
                            $html .='<a class="pagination-link"'.' href="'.$paginator->url($i).'">';
                            $html .='<li> '.$i.'</li>';
                            $html .='</a>';
                            $pages[] = $i;
                          }else{
                            $html .='<li class="current">';
                            $html .='<li> '.$i.'</li>';
                            $html .='</li>';
                            $pages[] =$i;
                          }
                       }else if ( $dotshow ){

                           $dotshow = false;
                            $html .='<li class="dots">';
                            $html .='<li> ... </li>';
                            $html .='</li>';
                            $pages[]='...';
                    }

                }
                $html .='<li><i class="fa fa-angle-right"></i></li>';// next
                $html.='</ul>';
            }

        @endphp

        <div class="col-md-6 col-lg-push-2" align="center" style="padding:0px">
            @if($position != 'top' && $paginator->hasPages())
                <ul class="pagination">
                    @if ($paginator->currentPage() == 1)
                        <li><span><</span></li>
                    @else
                        <li>
                            <a href="{{ $paginator->url($paginator->currentPage()-1) }}"><</a>
                        </li>
                    @endif
                    @foreach($pages as $page)
                        @if (is_string($page))
                            <li><span>...</span></li>
                        @else
                            @if ($page === $paginator->currentPage())
                                <li class="active"><span>{{$page}}</span></li>
                            @else
                                <li><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                    @if ($paginator->currentPage() == $paginator->lastPage())
                        <li><span>></span></li>
                    @else
                        <li>
                            <a href="{{ $paginator->url($paginator->currentPage()+1) }}">></a>
                        </li>
                    @endif
                </ul>
            @endif
        </div>

        {{--<div>--}}
        {{--{{ $paginator->links() }}--}}
        {{--</div>--}}
        @if ($paginator->lastPage()>4)
            <div class="page-number jmp_to col-md-3" style="padding: 0px;float: right;width: 149px;">
                <form action="" method="GET">
                    <input type="number" name="page"
                           style="width:100%;height: 38px;background-color: #206bd9 !important;color:white;padding: 10px;border:3px solid;"
                           placeholder="Jump to page">
                    <button type="submit"
                            style="transform: rotate(180deg);padding: 5px;background-color:Transparent;border: 0px;padding: 5px;position: absolute;right: 0px;top: 3px;">
                        <img src="{{ url('assets/app/images/arrow3.png?v=0.0.2') }}" alt="" class="loading"
                             data-was-processed="true">
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
