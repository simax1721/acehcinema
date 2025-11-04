@extends('web.desktop.layouts.master')

@section('main-content')
    <section id="hero-section">
        <!-- 🔹 Video Background -->
        <div class="video-background">
            {{-- <iframe 
            id="dacast-iframe"
            src="https://iframe.dacast.com/vod/39e5d509-c095-4ec0-7b41-1b13e9383df6/455a6b63-fa01-49e1-836b-9f94847cb265?autoplay=1&muted=1&loop=1"
            frameborder="0"
            allow="autoplay; fullscreen"
            allowfullscreen
            referrerpolicy="no-referrer"
        ></iframe> --}}
        </div>

        <!-- 🔹 Konten di atas video -->
        <div class="content-overlay ">
            <div class="row">
            <div class="col-md-6 col-sm-7 col-9">
                <img class="w-100" src="/assets/img/hero-section-logo.png" alt="">
                <p>Aceh Film Streaming Portal</p>
                <button id="button-watch" type="button" class="button-watch">Tonton Sekarang</button>
            </div>
            </div>
        </div>
    </section>

    <section class="movies" id="popular" data-category="popular">
      <div class="d-flex justify-content-between align-items-center movie-category">
        <h2>Popular</h2>
        <a href="{{ url('/section-movie/popular') }}"><i class="fa-solid fa-arrow-right"></i></a>
      </div>

      <div class="swiper swipers">
        <div class="swiper-wrapper">
          <!-- AJAX akan isi di sini -->
        </div>
      </div>
      <div class="swipper-button-costume">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </section>

    <section class="movies" id="fiction" data-category="fiction">
      <div class="d-flex justify-content-between align-items-center movie-category">
        <h2>Fiksi</h2>
        <a href="{{ url('/section-movie/fiction') }}"><i class="fa-solid fa-arrow-right"></i></a>
      </div>

      <div class="swiper swipers">
        <div class="swiper-wrapper"></div>
      </div>
      <div class="swipper-button-costume">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </section>

    <section class="movies" id="documentary" data-category="documentary">
      <div class="d-flex justify-content-between align-items-center movie-category">
        <h2>Dokumentari</h2>
        <a href="{{ url('/section-movie/documentary') }}"><i class="fa-solid fa-arrow-right"></i></a>
      </div>

      <div class="swiper swipers">
        <div class="swiper-wrapper"></div>
      </div>
      <div class="swipper-button-costume">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </section>

    

    
    
@endsection

@push('scripts')
<script>
  
  $(document).ready(function () {
    // === Load Movie Data per Section ===
    homeGetMovie();
  });

  
</script>

@endpush