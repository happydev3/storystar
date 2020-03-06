<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LinksRequest;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\Story;
use App\Models\Content;
use App\Models\StoryCategory;
use Avatar;
use Image;
use JsValidator;

class LinksController extends Controller
{

    protected $pageData = array();
    public $singularName = 'Links';
    public $pluralName = 'Links';
    protected $jsValidation = true;
    protected $listViewSimple = [];
    protected $selectedViewType = false;

    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Stories";

        // admin auth middleware
        $this->middleware('auth:admin');
    }


    public function form($id = "", $callFrom = "")
    {


        $data = array();
        if ($id):
            $action = route('admin-links-update', $id);
            $method = 'patch';
        else:
            $action = route('admin-links-add');
            $method = 'post';
        endif;

        $fmForm = new FmForm('LinksFrm', $action, $method, ['class' => 'smart-form', 'novalidate' => 'novalidate'], true);

        $fmForm->title('Add New ' . $this->singularName);
        $fmForm->saveText('Save');
        $fmForm->jsValidation($this->jsValidation);


        $updatedAppFiled = [];
        // Get edit from data in case of edit record
        if ($id) {

            $data = Content::find($id);

            $fmForm->title('Update ' . $this->singularName);
            $fmForm->saveText('Update');
            $fmForm->setter(['removeCancel' => true]);

            $updatedFields = [
                "tooltip" => "You can't change the Field."
            ];
        }


        $fmForm
            ->add(array(
                    "col" => 12,
                    "type" => "textarea",
                    "name" => "content",
                    "attr" => ["rows" => 30],
                    "label" => "Link Content",
                    "value" => (isset($data->content) ? $data->content : ""),
                )
            )
            ->add(array(
                    "col" => 12,
                    "type" => "html",
                    "html" => "<hr/>",
                )
            );


        return $fmForm->getForm();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $callFrom = '')
    {


        $this->pageData['MainHeading'] = "Edit " . $this->singularName;
        $this->pageData['PageTitle'] = "Edit " . $this->singularName;
        $this->pageData['SubNav'] = "Edit Links";
        $this->pageData['NavHeading'] = "Edit " . $this->singularName;

        $form = $this->form($id, $callFrom);

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
    public function update(LinksRequest $request, $id)
    {


        // Update Backend User
        try {
            $updateRecord = Content::find($id);

            $updateRecord->content = $request['content'];


            if ($updateRecord->save()) {


                $request->session()->flash('alert-success', $this->singularName . ' has been added successfully!');

            } else {
                $request->session()->flash('alert-danger', 'There is some issue.Please try again!');
            }
        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }


        return redirect()->route("admin-links-edit", ["id" => $id]);


    }


}
