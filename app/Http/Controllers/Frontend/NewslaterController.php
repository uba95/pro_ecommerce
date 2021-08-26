<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newslater;
use Illuminate\Http\Request;

class NewslaterController extends Controller
{
    public function store(Request $request) {

        $validatedData = $request->validate(['email' => 'required|email|unique:newslaters|max:255']);
        Newslater::create($validatedData);

        return response()->json(['success' => 'Thanks For Subscribing!']);
    }

    public function destroy(Request $request) {

        $newslater = Newslater::where('email', $request->email)->firstOrFail();
        $newslater->delete();

        return response()->json(['success' => 'Newslater Has Been Successfully Deleted']);
    }
}
