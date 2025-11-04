<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }


    function index() {
        // return view('web.admin.home');
        return 0;
    }

    function get_dashboard() {
        return view('web.admin.home');
    }
}
