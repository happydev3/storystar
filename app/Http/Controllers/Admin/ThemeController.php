<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ThemeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Theme;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class ThemeController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Theme';
    public $pluralName = 'Themes';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Themes";

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
            ['data' => 'theme_id', 'name' => 'theme_id', 'title' => 'Theme ID', 'searchable' => true, 'class' => 'text-center', 'width' => 100],
            ['data' => 'theme_title', 'name' => 'theme_title', 'title' => 'Title', 'data-class' => 'expand', 'width' => 200],
            ['data' => 'theme_order', 'name' => 'theme_order', 'title' => 'Theme Order', 'searchable' => true, 'class' => 'text-center', 'width' => 100],
            ['data' => 'theme_class', 'name' => 'theme_class', 'title' => 'Box Color', 'searchable' => true, 'class' => 'text-center', 'width' => 100],
            ['data' => 'theme_image', 'name' => 'theme_image', 'title' => 'Thumbnail', 'searchable' => false, 'class' => 'text-center no-filter', 'width' => 100],
            ['data' => 'page_title', 'name' => 'page_title', 'title' => 'Page Title', 'searchable' => false, 'class' => 'text-center', 'width' => 100],
            ['defaultContent' => '', 'data' => 'action', 'name' => 'action', 'title' => 'Action', 'render' => '', 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'class' => 'text-center', 'width' => '120px']
        ];

        $html = $this->getDataTable($builder, "Theme_TBL", $viewColumns, 'Thumbnail', 'admin-theme-list');

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
            $action = route('admin-theme-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-theme-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('ThemeFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {


            $data = Theme::find($id);
            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');

            $updatedAppFiled =
                [
                    //"attr" => ['readonly' => 'readonly'],
                    //"tooltip" => "You can't change the Field."
                ];
        }

        $themeOrderOptions = [];

        $total = Theme::all()->count();
        for ($i = 0; $i < $total; $i++) {
            $themeOrderOptions[$i] = $i;
        }

        $fmForm
            ->add(array(
                    "type" => "text",
                    "name" => "theme_title",
                    "label" => "Title",
                    "value" => (isset($data->theme_title) ? $data->theme_title : ""),
                )
            )
            ->add(array(

                "type" => "select",
                "options" => ['love-box' => 'Pink', 'family-box' => 'Blue', 'inspira-box' => 'Yellow'],
                "name" => "theme_class",
                "label" => "Box Color",
                "value" => (isset($data->theme_class) ? $data->theme_class : ""),
                "attr" => ['style' => 'width:100%', 'class' => '']
            ))
            ->add(array(
                "type" => "select",
                "options" => $themeOrderOptions,
                "name" => "theme_order",
                "label" => "Theme Order",
                "value" => (isset($data['theme_order']) ? $data['theme_order'] : ""),
                "attr" => ['style' => 'width:100%', 'class' => '']
            ))
            ->add(array(
                "col" => (isset($data['theme_image']) ? 5 : 6),
                "type" => "file",
                "name" => "theme_image",
                "label" => "Thumbnail",
                "value" => (isset($data['theme_image']) ? getTheme($data['theme_image']) : "")
            ))
            ->add(array(
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
    public function store(ThemeRequest $request)
    {

        $theme_image = "";

        // File upload here
        $destinationPath = storage_path("themes");

        $file = $request->file('theme_image');
        if ($file) {
            //Move Uploaded File
            $theme_image = "theme_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $theme_image);
        }

        try {
            $data = Theme::create([
                'theme_title' => $request['theme_title'],
                'theme_order' => $request['theme_order'],
                'theme_image' => $theme_image,
                'theme_slug' => Theme::getSlug($request['theme_title']),
                'theme_class' => $request['theme_class'],
                'page_title' => $request['page_title'],
                'meta_keywords' => $request['meta_keywords'],
                'meta_description' => $request['meta_description'],
                'created_timestamp' => time(),
                'updated_timestamp' => time()
            ]);

            if ($data->theme_id) {
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


        $detailData = Theme::Select(
            'theme_id as ID',
            'theme_title as Theme Title',
            'page_title as Page Title',
            'meta_keywords as Meta Keywords',
            'meta_description as Meta Description',

            'theme_order as Theme Order',
            'theme_image as theme_image',
            'created_timestamp as Created Date Time',
            'updated_timestamp as Updated Date Time'
        )->Find($id)->toArray();

        $detailData['Thumbnail'] = getTheme($detailData['theme_image'], '');
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
    public function update(ThemeRequest $request, $id)
    {

        $theme_image = "";

        // File upload here
        $destinationPath = storage_path("themes");

        $file = $request->file('theme_image');
        if ($file) {
            //Move Uploaded File
            $theme_image = "theme_" . NewGuid() . "." . $file->guessExtension();
            $file->move($destinationPath, $theme_image);
        }

        // Update Backend User
        try {
            $updateRecord = Theme::find($id);

            $updateRecord->theme_title = $request->theme_title;
            $updateRecord->theme_order = $request->theme_order;
            $updateRecord->page_title = $request->page_title;
            $updateRecord->meta_keywords = $request->meta_keywords;
            $updateRecord->meta_description = $request->meta_description;
            $updateRecord->theme_slug = Theme::getSlug($request['theme_title']);
            $updateRecord->theme_class = $request->theme_class;

            $updateRecord->updated_timestamp = time();

            if ($theme_image)
                $updateRecord->theme_image = $theme_image;


            if ($updateRecord->save()) {
                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());

        }

        return redirect()->route("admin-theme-list");

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

            $theme = Theme::with("stories")->find($id);


            if ($theme->stories->count() >= 1) {
                $request->session()->flash('alert-danger', 'Some stories belong to this theme. So you need to delete the stories first before delete this theme');
            } else {
                if ($theme->delete()) {
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


        $apps = Theme::select($columns);

        $table = DataTables::of($apps);

        $table->addColumn('action', function ($apps) {

            $deleteURL = route('admin-theme-delete', $apps->theme_id);

            return '<a href="' . route('admin-theme-edit', $apps->theme_id) . '" class="btn btn-xs btn-primary" rel="tooltip" data-placement="top" data-original-title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> 
                    <a href="' . route('admin-theme-detail', $apps->theme_id) . '" class="btn btn-xs bg-color-pink txt-color-white" rel="tooltip" data-placement="top" data-original-title="Detail"><i class="glyphicon glyphicon-th-list"></i> </a>
                    <a href="javascript:void(0)"  class="btn btn-xs btn-danger txt-color-white" onclick="confirmBox(\'' . $deleteURL . '\')" rel="tooltip" data-placement="top" data-original-title="Delete"><i class="glyphicon glyphicon-remove" ></i> </a>
                    ';
        });

        $table->editColumn('theme_image', function ($user) {
            return getTheme($user->theme_image, $user->theme_title);
        });


        $table->editColumn('theme_class', function ($apps) {


            $class = ['love-box' => 'Pink', 'family-box' => 'Blue', 'inspira-box' => 'Yellow'];
            if (isset($apps->theme_class) && !empty($apps->theme_class)) {
                return $class[$apps->theme_class];
            }
        });


        $table->filterColumn('theme_class', function ($query, $keyword) {

            $class = ['pink' => 'love-box', 'blue' => 'family-box', 'yellow' => 'inspira-box'];

            $query->whereRaw("theme_class like ?", ["$class[$keyword]"]);

        });


        $table->rawColumns(['theme_image', 'action']);

        //If custom Filter Added.
        if ($this->advanceFilters)
            setAdvanceFilter($request, $table);

        return $table->make(true);
    }
}
