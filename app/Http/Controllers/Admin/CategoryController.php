<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Category;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class CategoryController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Category';
    public $pluralName = 'Categories';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Categories";

        // admin auth middleware
        $this->middleware('auth:admin');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {


        /* Set and Get list view for this page*/
        if ($this->selectedViewType)
            $this->selectedViewType = $this->listView($request);

        /* List View Data */
        if (request()->ajax()) {
            return $this->getAjaxData($request);
        }

        /* List UI Generator */
        $this->pageData['MainHeading'] = $this->singularName;


        // List Columns
        $viewColumns = [
            ['data' => 'category_id', 'name' => 'category_id', 'title' => 'Category ID', 'searchable' => true, 'class' => 'text-center', 'width' => 50],
            ['data' => 'category_title', 'name' => 'category_title', 'title' => 'Title', 'data-class' => 'expand', 'width' => 200],
            ['data' => 'page_title', 'name' => 'page_title', 'title' => 'Page Title', 'searchable' => false, 'class' => 'text-center', 'width' => 100],

            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "Category_TBL", $viewColumns, 'Avatar', 'admin-category-list');

        return view('admin.list', compact('html'))
            ->with(['pageData' => $this->pageData])
            ->with(['selectedViewType' => ucfirst($this->selectedViewType)]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->pageData['MainHeading'] = "Add " . $this->singularName;
        $this->pageData['PageTitle'] = "Add " . $this->singularName;
        $this->pageData['SubNav'] = "Add " . $this->singularName;
        $this->pageData['NavHeading'] = "New " . $this->singularName;

        // Add  App Form
        $form = $this->form();

        return view('admin.add')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));
    }

    public function form($id = "")
    {


        $data = array();
        if ($id):
            $action = route('admin-category-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-category-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('CategoryFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {

            $data = Category::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');

            $updatedAppFiled =
                [
                    //"attr" => ['readonly' => 'readonly'],
                    //"tooltip" => "You can't change the Field."
                ];
        }

        $categoryOrderOptions = [];

        $total = Category::all()->count();
        for ($i = 0; $i < $total; $i++) {
            $categoryOrderOptions[$i] = $i;
        }

        $fmForm
            ->add(array(
                    "col" => 12,
                    "type" => "text",
                    "name" => "category_title",
                    "label" => "Title",
                    "value" => (isset($data->category_title) ? $data->category_title : ""),
                )
            )->add(array(
                    "col" => "12",
                    "type" => "text",
                    "name" => "page_title",
                    "label" => "Page Title",
                    "value" => (isset($data->page_title) ? $data->page_title : ""),
                )
            )
            ->add(array(
                    "col" => "12",
                    "type" => "text",
                    "name" => "meta_description",
                    "label" => "Meta Description",
                    "value" => (isset($data->meta_description) ? $data->meta_description : ""),
                )
            )
            ->add(array(
                    "col" => "12",
                    "type" => "text",
                    "name" => "meta_keywords",
                    "label" => "Meta Keywords",
                    "value" => (isset($data->meta_keywords) ? $data->meta_keywords : ""),
                )
            );


        return $fmForm->getForm();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {


        try {
            $data = Category::create([
                'category_title' => $request['category_title'],
                'page_title' => $request['page_title'],
                'meta_keywords' => $request['meta_keywords'],
                'meta_description' => $request['meta_description'],
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->category_id) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->pageData['PageTitle'] = $this->singularName . " Detail";
        $this->pageData['SubNav'] = "Add " . $this->singularName;
        $this->pageData['MainHeading'] = $this->singularName . " Detail";

        $detailData = array();

        $detailData = Category::Select(
            'category_id as ID',
            'category_title as Category Title',
            'page_title as Page Title',
            'meta_keywords as Meta Keywords',
            'meta_description as Meta Description',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Created Date Time'] = my_date($detailData['Created Date Time'], '', '');
        $detailData['Updated Date Time'] = my_date($detailData['Updated Date Time'], '', '');


        return view('admin.detail')
            ->with(['pageData' => $this->pageData])
            ->with(compact('detailData'));;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "AddApp";
        $this->pageData['NavHeading'] = "Edit " . $this->singularName;

        $form = $this->form($id);

        return view('admin.add')
            ->with(['pageData' => $this->pageData])
            ->with(compact('form'))
            ->with(compact('jsValidator'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {


        // Update Backend User
        try {
            $updateRecord = Category::find($id);

            $updateRecord->category_title = $request->category_title;
            $updateRecord->page_title = $request->page_title;
            $updateRecord->meta_keywords = $request->meta_keywords;
            $updateRecord->meta_description = $request->meta_description;
            $updateRecord->updated_timestamp = time();


            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-category-list");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        // Soft Delete Method
        try {
            $category = Category::with("stories")->find($id);
            if ($category->stories->count() >= 1) {
                $request->session()->flash('alert-danger', 'Some stories belong to this category. So you need to delete the stories first before delete this category');
            } else {

                if ($category->delete()) {
                    $request->session()->flash('alert-success', $this->singularName . ' has been deleted successfully!');
                } else {
                    $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
                }
            }


        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->back();

    }


    public function getAjaxData($request)
    {

        // List Type Check On Get Data From DB
        if ($this->selectedViewType == 'simple') {
            // Remove action column for query
            if (in_array('action', $this->listViewSimple))
                $this->listViewSimple = array_diff($this->listViewSimple, array('action'));
            $columns = $this->listViewSimple;

        } else
            // All and Custom Case
            $columns = ['*'];


        $apps = Category::select($columns);

        $table = DataTables::of($apps);


        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-category-delete', $apps->category_id);

            return '<a href="' . route('admin-category-edit', $apps->category_id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-category-detail', $apps->category_id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="glyphicon glyphicon-th-list"></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    ';
        });


        $table->editColumn('created_timestamp', function ($apps) {
            return my_date($apps->created_timestamp);
        });
        $table->filterColumn('created_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(created_timestamp),' % d -%m -%Y % h:%i:%s') like ?", ["%$keyword%"]);
        });
        $table->editColumn('updated_timestamp', function ($apps) {
            return my_date($apps->updated_timestamp);
        });
        $table->filterColumn('updated_timestamp', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(FROM_UNIXTIME(updated_timestamp),' % d -%m -%Y % h:%i:%s') like ?", ["%$keyword%"]);
        });
        $table->rawColumns(['action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }
}
