<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Newslater;

class NewslaterController extends ParentController
{
    public function index() {
        
        return (new ParentController([Newslater::all()], ["newslaters"], 'admin.newslater'))->index();
    }

    public function store(Request $request) {
     
        $data = [[
            'email' => 'required|unique:newslaters|max:255',
        ]];
    
        return (new ParentController([Newslater::class], "Thanks For Subscribing!", '', $data))->store($request);
    }

    public function destroy($id) {

        return (new ParentController([Newslater::class], "Newslater"))->destroy($id);
    }

}
