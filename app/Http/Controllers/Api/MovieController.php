<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MovieController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum')->only([
            'get_watchMovie',
        ]);
        $this->middleware(['auth:sanctum', 'ability:admin'])->only([
            'post_store',
            'put_update',
            'delete',
            'get_showAdmin',
            'get_datatable',
        ]);
    }

    public function get_index(Request $request)
    {
        $category = $request->query('category');

        // $query = Movie::select('id', 'title', 'category', 'thumbnail', 'poster', 'age', 'duration', 'description', 'release_date', 'actor', 'writter', 'producer', 'production', 'rating', 'views')->query();
        $query = Movie::query();

        if ($category === 'popular') {
            $query->orderByDesc('views');
        } elseif ($category) {
            $query->where('category', $category)->latest();
        } else {
            $query->latest();
        }

        $movies = $query->paginate(15);

        $movies->getCollection()->makeHidden(['dacast_embed']);
        return response()->json($movies);
    }

    function get_search(Request $request) {
        $search = $request->query('search');

        if ($search) {
            $query = Movie::query();
            $query->where('title', 'LIKE', '%'. $search . '%')->orWhere('actor', 'LIKE', '%'. $search . '%')->latest();


            $movies = $query->paginate(15);

            $movies->getCollection()->makeHidden(['dacast_embed']);
            return response()->json($movies);
        }

        return response()->json(['data' => []]);
    }

    public function get_show(Request $request, $id)
    {
        $movie = Movie::select( 'id', 'title', 'category', 'thumbnail', 'poster', 'trailer_dacast_embed', 'age', 'duration', 'description', 'release_date', 'actor', 'writter', 'producer', 'production', 'rating', 'views',)->findOrFail($id);

        return response()->json($movie);
    }

    function get_watchMovie($id) {
        $movie = Movie::select( 'id', 'dacast_embed')->findOrFail($id);
        return  response()->json($movie);
    }

    function post_store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'dacast_embed' => 'dacast_embed',
            'trailer_dacast_embed' => 'trailer_dacast_embed',
        ];

        Movie::create($data);

        $movie = Movie::
        where('title', $data['title'])
        ->where('category', $data['category'])
        ->where('dacast_embed', $data['dacast_embed'])
        ->where('trailer_dacast_embed', $data['trailer_dacast_embed'])
        ->latest()
        ->first();

        $message = [
            'title' => 'Movie',
            'text' => 'Movie '. $movie['title'] .' telah ditambah!',
            'icon' => 'success'
        ];

        return response()->json([
            'message' => $message, 'data' => $movie
        ]);
    }

    function post_update(Request $request, $id) {

        // return response()->json($request->all());

        if ($request->action == 'updateMovie') {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'category' => 'required',
                'dacast_embed' => 'required',
                'trailer_dacast_embed' => 'required',
                'age' => 'required',
                'duration' => 'required',
                'description' => 'required',
                'release_date' => 'required',
                'actor' => 'required',
                'writter' => 'required',
                'producer' => 'required',
                'production' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $dataUpdate = [
                'title' => $request->title,
                'category' => $request->category,
                'dacast_embed' => $request->dacast_embed,
                'trailer_dacast_embed' => $request->trailer_dacast_embed,
                'age' => $request->age,
                'duration' => $request->duration,
                'description' => $request->description,
                'release_date' => $request->release_date,
                'actor' => $request->actor,
                'writter' => $request->writter,
                'producer' => $request->producer,
                'production' => $request->production,
            ];

        } elseif ($request->action == 'uploadThumbnail') {

            $validator = Validator::make($request->files->all(), [
                    'fileThumbnail' => 'required|image|mimes:png,jpg,jpeg',
                ]
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Simpan file ke folder public/uploads/
            $file = $request->file('fileThumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            $dataUpdate = ['thumbnail' => $filename];

        } elseif ($request->action == 'uploadPoster') {
            $validator = Validator::make($request->files->all(), [
                    'filePoster' => 'required|image|mimes:png,jpg,jpeg',
                ]
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Simpan file ke folder public/uploads/
            $file = $request->file('filePoster');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            $dataUpdate = ['poster' => $filename];
        }

        Movie::find($id)->update($dataUpdate);

        $movie = Movie::findOrfail($id);

        $message = [
            'title' => 'Movie',
            'text' => 'Movie '. $movie['title'] .' telah diupdate!',
            'icon' => 'success'
        ];

        return response()->json([
            'message' => $message, 'data' => $movie
        ]);
        // return response()->json(['action' => $request->action]);
    }

    function delete($id) {
        
    }

    function get_showAdmin(Movie $movie) {
        return response()->json($movie);
    }

    function get_datatable(Request $request) {

        // return response()->json(['msg' => 'oke' ]);
        $data = Movie::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                // ->addColumn('id', function ($data) {
                //     return $data->id;
                // })
                // ->addColumn('title', function ($data) {
                //     return $data->title;
                // })
                // ->addColumn('category', function ($data) {
                //     return $data->category;
                // })
                // ->addColumn('views', function ($data) {
                //     return $data->views;
                // })
                // ->addColumn('release_date', function ($data) {
                //     return $data->release_date;
                // })
                ->addColumn('poster', function ($data) {
                    $img = '<a target="_blank" href="'.$data->poster.'"><img src="'.$data->poster.'" alt="" style="max-width: 50px"></a>';
                    return $img;
                })
                ->addColumn('created_at', function ($data) {
                    return $data->created_at;
                })
                ->addColumn('action', function ($data) {
                    return '<div style="display: inline-flex;" class="">
                            <a href="/admin/movie/detail/'. $data->id .'" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action', 'poster'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
