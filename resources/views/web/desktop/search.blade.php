@extends('web.desktop.layouts.master')

@section('main-content')
    <section class="search">
        <h2 id="search-title">Pencarian</h2>

        <div class="search-wrapper">
            <div class="clear-search d-none">
                <i class="fa-solid fa-x fa-xl" id="clear-search"></i>
            </div>
            <div class="box-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search" placeholder="Cari Berdasarkan judul atau nama aktor">
            </div>
        </div>

        <div class="row justify-content-center mt-5" id="movie-list">
        <!-- data film akan dimasukkan lewat JS -->
        </div>

        <div class="text-center mt-4 load-movie-btn">
            <button id="load-more" class="">TAMPILKAN LAINNYA</button>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            searchMovie();
            // sectionMovie();
        });
    </script>
@endpush