<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Newslater;

class NewslaterController extends Controller
{
    public function index() {
        return view('admin.newslater', ['newslaters' => Newslater::all()]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate(['email' => 'required|unique:newslaters|max:255']);
        Newslater::create($validatedData);
        return redirect()->back()->with(toastNotification('Thanks For Subscribing!'));
    }

    public function destroy(Newslater $newslater) {
        $newslater->delete();
        return redirect()->back()->with(toastNotification('Newslater', 'deleted'));
    }
}