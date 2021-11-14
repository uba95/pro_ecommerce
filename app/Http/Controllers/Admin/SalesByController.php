<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AjaxDatatablesService;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesByController extends Controller
{
    public function __construct() {
        $this->middleware('can:view reports',    ['only' => ['index']]);
    }

    public function index(Request $request) {
        return  request()->expectsJson() 
                ? AjaxDatatablesService::salesBy(ReportService::salesBy($request->from, $request->to))
                : view('admin.reports.salesBy');
    }
}
