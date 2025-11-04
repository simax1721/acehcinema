@extends('web.desktop.layouts.master')

@section('main-content')

<section class="movies-list">
    {{-- <div class="container"> --}}
        {{-- </div> --}}
    <h2 id="category-title"></h2>

    <div class="row justify-content-center" id="movie-list">
      <!-- data film akan dimasukkan lewat JS -->
    </div>

    <div class="text-center mt-4 load-movie-btn">
        <button id="load-more" class="">TAMPILKAN LAINNYA</button>
    </div>
</section>
    
@endsection

@push('scripts')
    
<script>
    // loadMoreBtn.hide();
    
    
    $(document).ready(function () {
        sectionMovie();
    });
</script>

@endpush