<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('web')->only([
            'get_watch',
        ]);
    }
    
    function get_index() {
        // $data = Auth::guard('web')->user();
        // return response()->json($data);
        return view('web.desktop.home');
    }

    function get_sectionMovie($movie) {
        return view('web.desktop.section-movie');
    }

    function get_movie($id) {
        return view('web.desktop.movie-info');
    }

    function get_watch(Request $request, $id) {
        
        return view('web.desktop.movie-watch');
    }

    function get_search() {
        return view('web.desktop.search');
    }
}
