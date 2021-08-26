<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function __construct() {
        $this->middleware('can:view site settings',    ['only' => ['index']]);
        $this->middleware('can:edit site settings',    ['only' => ['edit', 'update']]);
    }
    
    public function index() {
        return view('admin.site-settings.index', ['settings' => SiteSettings::first()]);
    }

    public function edit() {
        return view('admin.site-settings.edit', ['settings' => SiteSettings::first()]);
    }

    public function update(Request $request) {
        SiteSettings::first()->update($request->all());
        return redirect()->route('admin.site_settings.index')->with(toastNotification('Site Settings', 'updated'));
    }
}
