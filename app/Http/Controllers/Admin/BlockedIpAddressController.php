<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\Fmtables;
use App\Lib\FmForm;
use App\Models\BlockedIpAddress;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Avatar;
use Image;
use JsValidator;

class BlockedIpAddressController extends Controller
{
    protected $pageData = array();
    public $singularName = 'Blocked IP Address';
    public $pluralName = 'Blocked IP Addresses';
    protected $jsValidation = true;
    protected $listViewSimple = ['created_timestamp', 'updated_timestamp', 'action'];
    protected $selectedViewType = false;


    public function __construct()
    {
        $this->pageData['PageTitle'] = $this->pluralName . " List";
        $this->pageData['MainNav'] = $this->pluralName;
        $this->pageData['SubNav'] = "Manage Blocked IP Address";

        // admin auth middleware
        $this->middleware('auth:admin');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         /* List UI Generator */
        $this->pageData['MainHeading'] = $this->singularName;

        $blocked_ip_addresses = BlockedIpAddress::select('id','ip_address');
        if(trim($request->input('search')) != ''){
            $blocked_ip_addresses = $blocked_ip_addresses->where('ip_address','LIKE',$request->input('search'));
        }
        $blocked_ip_addresses = $blocked_ip_addresses->paginate(2);
        return view('admin.blocked-ip-list')
            ->with(['pageData' => $this->pageData, 'blocked_ip_addresses' => $blocked_ip_addresses]);

    }

    public function destroy(Request $request, $id)
    {
        try {
            $ip_address = BlockedIpAddress::find($id);
            $display = $ip_address->ip_address;
            if ($ip_address->delete()) {
                $request->session()->flash('alert-success', 'IP - '.$display.' can now access StoryStar!');
            } else {
                $request->session()->flash('alert-danger', 'There is some issue. Please try again!');
            }

        } catch (\Exception $e) {
            $request->session()->flash('alert-danger', $e->getMessage());
        }
        return redirect()->back();
    }
}
