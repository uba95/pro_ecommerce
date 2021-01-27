<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Newslater;

class NewslaterController extends Controller
{
    public function index() {
     
        $newslaters = Newslater::all();
        return view('admin.newslater', compact('newslaters'));
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'email' => 'required|unique:newslaters|max:255',
        ]);
    
        Newslater::create($validatedData);

        $notification=array(
            'messege'=>'Thanks For Subscribing!',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);

    }

    public function destroy($id) {

        $newslater = Newslater::find($id);

        if (!$newslater) {
            return redirect()->back()->with(toastNotification('Newslater', 'not_found'));
        }

        $newslater->delete();

        return redirect()->back()->with(toastNotification('Newslater', 'deleted'));

    }

}
