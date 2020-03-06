<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Events\SaveListViewCall;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $pageData = array();
    protected $selectedViewType = true;
    protected $advanceFilters = true;

    public function listView($request)
    {
        /* Update the list view in database for this user for this page*/
        SaveListViewCall::dispatch($request);

        /* Already added view for this page*/
        $savedViewType = getSetting('ListView');
        if ($request->view) {
            $this->selectedViewType = $request->view;
        } else /* If list view is enabled check*/ {
            if ($this->selectedViewType) {
                $this->selectedViewType = $this->selectedViewType && isset($savedViewType[$request->path()]) && !empty($savedViewType[$request->path()]) ? $savedViewType[$request->path()] : 'all';
            }
        }

        return $this->selectedViewType;
    }

    public function getDataTable(
        $builder,
        $tableID,
        $viewColumns,
        $restrictSearchFor,
        $filterRoute,
        $defaultSortBy = "",
        $multiDeleteOption = false,
        $passObj = ""
    ) {
        /* Set Advance Filters */
        $this->pageData['advanceFilters'] = $this->advanceFilters;

        $this->pageData['TableID'] = $tableID;

        // Simple List view Check
        if ($this->selectedViewType == 'simple') {
            foreach ($viewColumns as $k => $column) {
                if (!in_array($column['data'], $this->listViewSimple)) {
                    unset($viewColumns[$k]);
                }
            }

            // Re Index array
            $viewColumns = array_values($viewColumns);
        }

        //For Advance Filters
        if ($filterRoute != false) {
            if (\Request::route()->getName() == "admin-stories-edit") {
                $builder->ajax([
                    'url' => route("admin-comments-list", [\Request::route('id')]),
                    'type' => 'GET',
                    'data' => 'function(d){d.filter = bindFilters(); d.pass=JSON.stringify({' . $passObj . '})}'
                ]);
            } else {
                $builder->ajax([
                    'url' => route($filterRoute),
                    'type' => 'GET',
                    'data' => 'function(d){d.filter = bindFilters(); d.pass=JSON.stringify({' . $passObj . '})}'
                ]);
            }
        }

        $builder->parameters(data_table_attr($tableID, $restrictSearchFor, $defaultSortBy, $multiDeleteOption));
        $html = $builder->columns($viewColumns);
        return $html;
    }
}
