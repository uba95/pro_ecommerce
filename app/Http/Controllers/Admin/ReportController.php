<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request) {
            return view('admin.reports.index', ['report' => ReportService::get($request->report)]);
    }
}
