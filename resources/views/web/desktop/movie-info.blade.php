@extends('web.desktop.layouts.master')

@section('main-content')
    <section class="movie-about">
        
    </section>

    {{-- <section style="">
        test
    </section> --}}
@endsection

@push('scripts')
    <script>
        const movieId = window.location.pathname.split("/").pop();
        const movieAbout = $('.movie-about');
        

        $(document).ready(function () {
            getMovieInfo(movieAbout, movieId);
        });
    </script>
@endpush