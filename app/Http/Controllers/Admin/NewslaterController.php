<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Newslater;

class NewslaterController extends Controller
{
    public function __construct() {
        $this->middleware('can:view newslaters',    ['only' => ['index']]);
        $this->middleware('can:create newslaters',    ['only' => ['store']]);
        $this->middleware('can:delete newslaters',    ['only' => ['destroy']]);
    }

    public function index() {
        return view('admin.newslater', ['newslaters' => Newslater::all()]);
    }

    public function destroy(Newslater $newslater) {
        $newslater->delete();
        return redirect()->back()->with(toastNotification('Newslater', 'deleted'));
    }
}