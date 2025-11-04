<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    function get_index() {
        return view('web.admin.movie');
    }

    function get_detail($id) {
        return view('web.admin.movie-detail');
    }
}
