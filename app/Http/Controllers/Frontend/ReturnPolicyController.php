<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ReturnPolicyController extends Controller
{
    public function __invoke() {
        return view('pages.return_policy');
    }
}

