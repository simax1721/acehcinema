@extends('web.desktop.layouts.master')

@push('css') 
    
@endpush

@section('main-content')
    <section class="movie-watch">
        <div class="play-movie">
        </div>

        <div class="row more-watch">
            <div class="col-md-8 description-movie mb-5">
                
            </div>

            <div class="col-md-4 more-movie">
                <div class="row justify-content-center" id="movie-list">
                <!-- data film akan dimasukkan lewat JS -->
                </div>
                <div class="text-center mt-4 load-movie-btn">
                    <button id="load-more" class="">TAMPILKAN LAINNYA</button>
                </div>
            </div>
        </div>


    </section>
@endsection

@push('scripts')
    <script>
        // const movieIdB = window.location.pathname.split("/").pop();
        protectUrlRequiringLogin();
        $(document).ready(function () {       
            movieWatch(Auth.getToken());
        });
    </script>
@endpush